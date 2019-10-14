<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\Companies\app\Models\Company;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Forms\app\TestTraits\CreateForm;
use LaravelEnso\Forms\app\TestTraits\DestroyForm;
use LaravelEnso\Forms\app\TestTraits\EditForm;
use LaravelEnso\Products\app\Http\Resources\Supplier;
use LaravelEnso\Products\app\Models\Product;
use LaravelEnso\Tables\app\Traits\Tests\Datatable;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use Datatable, DestroyForm, EditForm, CreateForm, RefreshDatabase;

    private $permissionGroup = 'products';
    private $testModel;

    private const SupplierNumber = 5;

    protected function setUp(): void
    {
        parent::setUp();

        // $this->withoutExceptionHandling();

        $this->seed()
            ->actingAs(User::first());

        $this->testModel = factory(Product::class)->make([
            'manufacturer_id' => factory(Company::class)->create()->id,
        ]);

        $this->testModel->inCents = true;
    }

    /** @test */
    public function can_store_product()
    {
        $response = $this->post(
            route('products.store', [], false),
            $this->testModel->toArray()
        );

        $product = Product::whereName($this->testModel->name)
            ->first();

        $response->assertStatus(200)
            ->assertJsonStructure(['message'])
            ->assertJsonFragment([
                'redirect' => 'products.edit',
                'param' => ['product' => $product->id],
            ]);
    }

    /** @test */
    public function can_store_product_with_default_supplier()
    {
        $suppliers = Supplier::collection(
            factory(Company::class, static::SupplierNumber)->create()
        )
            ->toArray(null);

        $suppliers = $this->updatePivot($suppliers);

        $response = $response = $this->post(
            route('products.store', [], false),
            $this->testModel->toArray() + [
                'suppliers' => $suppliers,
                'defaultSupplierId' => $suppliers[0]['id'],
            ]
        );

        $product = Product::whereName($this->testModel->name)
            ->first();

        $response->assertStatus(200)
            ->assertJsonStructure(['message'])
            ->assertJsonFragment([
                'redirect' => 'products.edit',
                'param' => ['product' => $product->id],
            ]);

        $this->assertEqualsCanonicalizing(
            collect($suppliers)->pluck('id')->toArray(),
            $product->suppliers()->pluck('id')->toArray()
        );

        $this->assertEquals(
            $suppliers[0]['id'], $product->defaultSupplier()->id
        );

        $this->assertTrue(
            $product->suppliers->except($suppliers[0]['id'])->every(function ($supplier) {
                return $supplier->pivot->is_default === "0";
            })
        );
    }

    /** @test */
    public function can_update_default_supplier()
    {
        $suppliers = Supplier::collection(
            factory(Company::class, static::SupplierNumber)->create()
        )
            ->toArray(null);

        $suppliers = $this->updatePivot($suppliers);

        \Log::debug($suppliers);

        $this->testModel->save();
        $this->testModel->syncSuppliers($suppliers, $suppliers[0]['id']);


        $r = $this->patch(
            route('products.update', $this->testModel->id, false),
            $this->testModel->toArray() + [
                'suppliers' => $suppliers,
                'defaultSupplierId' => $suppliers[1]['id'],
            ]
        );


            $r->assertStatus(200)
            ->assertJsonStructure(['message']);

        $refreshedTestModel = $this->testModel->fresh();

        $this->assertEquals(
            $suppliers[1]['id'], $refreshedTestModel->defaultSupplier()->id
        );

        $this->assertTrue(
            $refreshedTestModel->suppliers->except($suppliers[1]['id'])
                ->every(function ($supplier) {
                    return $supplier->pivot->is_default === "0";
                })
        );
    }

    /** @test */
    public function can_update_product()
    {
        tap($this->testModel)->save()->name = 'updated';

        $this->patch(
            route('products.update', $this->testModel->id, false),
            $this->testModel->toArray()
        )->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertEquals(
            $this->testModel->name,
            $this->testModel->fresh()->name
        );
    }

    /** @test */
    public function get_option_list()
    {
        $this->testModel->save();

        $this->get(route('products.options', [
            'query' => $this->testModel->name,
            'limit' => 10,
        ], false))
            ->assertStatus(200)
            ->assertJsonFragment(['name' => $this->testModel->name]);
    }

    private function updatePivot($suppliers)
    {
        return collect($suppliers)
            ->map(function ($supplier) {
                $supplier['pivot']['part_number'] = $this->testModel->part_number;
                $supplier['pivot']['acquisition_price'] = $this->testModel->list_price - 1;

                return $supplier;
            })
            ->toArray();
    }
}
