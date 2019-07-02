<?php

namespace LaravelEnso\Products\app\Forms\Builders;

use LaravelEnso\Forms\app\Services\Form;
use LaravelEnso\Products\app\Models\MeasurementUnit;

class MeasurementUnitForm
{
    private const TemplatePath = __DIR__.'/../Templates/measurementUnit.json';

    private $form;

    public function __construct()
    {
        $this->form = new Form(self::TemplatePath);
    }

    public function create()
    {
        return $this->form->create();
    }

    public function edit(MeasurementUnit $measurementUnit)
    {
        return $this->form->edit($measurementUnit);
    }
}
