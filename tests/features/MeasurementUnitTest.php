<?php

use Tests\TestCase;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Forms\app\TestTraits\EditForm;
use LaravelEnso\Forms\app\TestTraits\CreateForm;
use LaravelEnso\Forms\app\TestTraits\DestroyForm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\Tables\app\Traits\Tests\Datatable;
use LaravelEnso\Products\app\Models\MeasurementUnit;

class MeasurementUnitTest extends TestCase
{
    use Datatable, DestroyForm, EditForm, CreateForm, RefreshDatabase;

    private $permissionGroup = 'administration.measurementUnits';
    private $testModel;

    protected function setUp(): void
    {
        parent::setUp();

        // $this->withoutExceptionHandling();

        $this->seed()
            ->actingAs(User::first());

        $this->testModel = factory(MeasurementUnit::class)
            ->make();
    }

    /** @test */
    public function can_store_measurement_unit()
    {
        $response = $this->post(
            route('administration.measurementUnits.store', [], false),
            $this->testModel->toArray()
        );

        $measurementUnit = MeasurementUnit::whereName($this->testModel->name)
            ->first();

        $response->assertStatus(200)
            ->assertJsonStructure(['message'])
            ->assertJsonFragment([
                'redirect' => 'administration.measurementUnits.edit',
                'param' => ['measurementUnit' => $measurementUnit->id],
            ]);
    }

    /** @test */
    public function can_update_measurement_unit()
    {
        tap($this->testModel)->save()
            ->name = 'updated';

        $this->patch(
            route('administration.measurementUnits.update', $this->testModel->id, false),
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

        $this->get(route('administration.measurementUnits.options', [
            'query' => $this->testModel->name,
            'limit' => 10,
        ], false))
        ->assertStatus(200)
        ->assertJsonFragment(['name' => $this->testModel->name]);
    }
}
