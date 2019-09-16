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

            $table->integer('manufacturer_id')->unsigned()->nullable();
            $table->foreign('manufacturer_id')->references('id')->on('companies');

            $table->string('name');
            $table->string('part_number');
            $table->string('internal_code')->nullable();
            $table->tinyInteger('measurement_unit')->unsigned();
            $table->integer('package_quantity')->nullable();
            $table->integer('list_price')->unsigned();
            $table->tinyInteger('vat_percent')->unsigned();

            $table->text('description')->nullable();
            $table->string('link')->nullable();

            $table->boolean('is_active');

            $table->timestamps();

            $table->unique(['part_number', 'manufacturer_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
