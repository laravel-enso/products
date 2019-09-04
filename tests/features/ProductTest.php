<?php

use Tests\TestCase;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Products\app\Models\Product;
use LaravelEnso\Companies\app\Models\Company;
use LaravelEnso\Forms\app\TestTraits\EditForm;
use LaravelEnso\Forms\app\TestTraits\CreateForm;
use LaravelEnso\Forms\app\TestTraits\DestroyForm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\Tables\app\Traits\Tests\Datatable;

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
            'manufacturer_id' => factory(Company::class)->create()->id
        ]);
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
        $supplierIds = factory(
            Company::class, static::SupplierNumber
        )->create()->pluck('id')->toArray();

        $response = $response = $this->post(
            route('products.store', [], false),
            $this->testModel->toArray() + [
                'suppliers' => $supplierIds,
                'defaultSupplierId' => $supplierIds[0],
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
            $supplierIds, $product->suppliers()->pluck('id')->toArray()
        );

        $this->assertEquals(
            $supplierIds[0], $product->defaultSupplier()->id
        );

        $this->assertTrue(
            $product->suppliers->except($supplierIds[0])->every(function($supplier) {
                return $supplier->pivot->is_default === "0";
            })
        );
    }

    /** @test */
    public function can_update_default_supplier()
    {
        $supplierIds = factory(
            Company::class, static::SupplierNumber
        )->create()->pluck('id')->toArray();
        $newSupplierId = factory(Company::class)->create()->id;

        $this->testModel->save();
        $this->testModel->syncSuppliers($supplierIds, $supplierIds[0]);


        $this->patch(
            route('products.update', $this->testModel->id, false),
            $this->testModel->toArray() + [
                'suppliers' => $supplierIds + [$newSupplierId],
                'defaultSupplierId' => $supplierIds[1]
            ]
        )->assertStatus(200)
        ->assertJsonStructure(['message']);

        $refreshedTestModel = $this->testModel->fresh();

        $this->assertEqualsCanonicalizing( 
            $supplierIds, $refreshedTestModel->suppliers()->pluck('id')->toArray()
        );
        
        $this->assertEquals(
            $supplierIds[1], $refreshedTestModel->defaultSupplier()->id
        );

        $this->assertTrue(
            $refreshedTestModel->suppliers->except($supplierIds[1])
                ->every(function($supplier) {
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
}
