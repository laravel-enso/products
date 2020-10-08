<?php

namespace LaravelEnso\Products\Tests\Features;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use LaravelEnso\Companies\Models\Company;
use LaravelEnso\Core\Models\User;
use LaravelEnso\Forms\TestTraits\CreateForm;
use LaravelEnso\Forms\TestTraits\DestroyForm;
use LaravelEnso\Forms\TestTraits\EditForm;
use LaravelEnso\Products\Http\Resources\Supplier;
use LaravelEnso\Products\Models\Product;
use LaravelEnso\Tables\Traits\Tests\Datatable;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use Datatable, DestroyForm, EditForm, CreateForm, RefreshDatabase;

    private string $permissionGroup = 'products';
    protected Product $testModel;

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->seed()
            ->actingAs(App::make(User::class)->first());

        $this->initTestModel();
    }

    /** @test */
    public function can_store_product()
    {
        $response = $this->post(
            route('products.store', [], false),
            $this->testModel->toArray()
            + ['suppliers' => []]
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
        $suppliers = $this->suppliers();

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
            array_column($suppliers, 'id'),
            $product->suppliers()->pluck('id')->toArray()
        );

        $this->assertEquals(
            $suppliers[0]['id'],
            $product->defaultSupplier()->id
        );

        $this->assertTrue(
            $product->suppliers->except($suppliers[0]['id'])
                ->every(fn ($supplier) => $supplier->pivot->is_default === false)
        );
    }

    /** @test */
    public function can_update_default_supplier()
    {
        $suppliers = $this->suppliers();
        $this->testModel->save();

        $this->testModel->syncSuppliers($suppliers, $suppliers[0]['id']);

        $this->patch(
            route('products.update', $this->testModel->id, false),
            $this->testModel->toArray() + [
                'suppliers' => $suppliers,
                'defaultSupplierId' => $suppliers[1]['id'],
            ]
        )->assertStatus(200)
            ->assertJsonStructure(['message']);

        $refreshedTestModel = $this->testModel->fresh();

        $this->assertEquals(
            $suppliers[1]['id'],
            $refreshedTestModel->defaultSupplier()->id
        );

        $this->assertTrue(
            $refreshedTestModel->suppliers->except($suppliers[1]['id'])
                ->every(fn ($supplier) => $supplier->pivot->is_default === false)
        );
    }

    /** @test */
    public function can_update_product()
    {
        tap($this->testModel)->save()->name = 'updated';

        $this->patch(
            route('products.update', $this->testModel->id, false),
            $this->updateParams()
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

    protected function initTestModel(): void
    {
        $this->testModel = Product::factory()->make([
            'manufacturer_id' => Company::factory()->create()->id,
        ]);
    }

    protected function updateParams(array $params = []): array
    {
        return (new Collection(['suppliers' => []]))
            ->merge($this->testModel->toArray())
            ->merge($params)
            ->toArray();
    }

    protected function suppliers()
    {
        $suppliers = Supplier::collection(
            Company::factory()->count(5)->create()
        )->resolve();

        return (new Collection($suppliers))
            ->map(fn ($supplier) => $this->supplier($supplier))
            ->toArray();
    }

    protected function supplier($supplier)
    {
        $supplier['pivot']['part_number'] = $this->testModel->part_number;
        $supplier['pivot']['acquisition_price'] = $this->testModel->list_price - 1;

        return $supplier;
    }
}
