<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

            $table->unsignedDecimal('acquisition_price', 11, 2)->nullable();
            $table->string('part_number')->nullable();

            $table->boolean('is_default');

            $table->timestamps();

            $table->primary(['product_id', 'supplier_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_supplier');
    }
}
