<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('category_id')->index()->nullable();
            $table->foreign('category_id')->references('id')
                ->on('categories');

            $table->unsignedInteger('manufacturer_id')->nullable();
            $table->foreign('manufacturer_id')->references('id')
                ->on('companies');

            $table->unsignedInteger('measurement_unit_id');
            $table->foreign('measurement_unit_id')->references('id')
                ->on('measurement_units');

            $table->string('name');
            $table->string('part_number');
            $table->string('internal_code')->nullable();
            $table->integer('package_quantity')->nullable();
            $table->unsignedDecimal('list_price', 11, 2);
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
