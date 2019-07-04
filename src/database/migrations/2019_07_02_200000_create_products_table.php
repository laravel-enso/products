<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('manufacturer_id')->unsigned();
            $table->foreign('manufacturer_id')->references('id')->on('companies');

            $table->integer('measurement_unit_id')->unsigned();
            $table->foreign('measurement_unit_id')->references('id')->on('measurement_units');

            $table->string('name');
            $table->integer('part_number');
            $table->string('internal_code')->nullable();
            $table->integer('list_price')->unsigned();
            $table->integer('vat_percent')->nullable();
            $table->integer('package_quantity')->nullable();
            $table->text('description')->nullable();

            $table->boolean('is_active');

            $table->unique(['part_number', 'manufacturer_id']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
