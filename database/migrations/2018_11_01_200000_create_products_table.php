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

            $table->unsignedInteger('manufacturer_id')->nullable();
            $table->foreign('manufacturer_id')->references('id')
                ->on('companies');

            $table->unsignedInteger('packaging_unit_id')->index()->nullable();
            $table->foreign('packaging_unit_id')->references('id')
                ->on('packaging_units');

            $table->unsignedInteger('measurement_unit_id');
            $table->foreign('measurement_unit_id')->references('id')
                ->on('measurement_units');

            $table->unsignedInteger('category_id')->index()->nullable();
            $table->foreign('category_id')->references('id')
                ->on('categories');

            $table->string('name')->index();
            $table->string('slug')->index();
            $table->string('part_number');
            $table->string('internal_code')->nullable()->unique();

            $table->unsignedInteger('package_quantity')->nullable();

            $table->unsignedDecimal('list_price', 13, 4);
            $table->tinyInteger('vat_percent')->unsigned();

            $table->text('description')->nullable();
            $table->text('html_description')->nullable();
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
