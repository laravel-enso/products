<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPicturesTable extends Migration
{
    public function up()
    {
        Schema::create('product_pictures', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');

            $table->unsignedInteger('order_index');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_pictures');
    }
}
