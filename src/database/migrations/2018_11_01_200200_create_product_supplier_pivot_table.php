<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSupplierPivotTable extends Migration
{
    public function up()
    {
        Schema::create('product_supplier', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade');

            $table->integer('supplier_id')->unsigned();
            $table->foreign('supplier_id')->references('id')->on('companies');

            $table->integer('acquisition_price')->unsigned()->nullable();

            $table->boolean('is_default');

            $table->primary(['product_id', 'supplier_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_supplier');
    }
}
