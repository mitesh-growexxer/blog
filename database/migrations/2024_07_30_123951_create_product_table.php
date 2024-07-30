<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->string('name' , 180);
            $table->longText('description')->nullable();
            $table->date('purchase_date');
            $table->double('product_price');
            $table->enum('type' , [ config('constants.PRODUCT_TYPE')  ,  config('constants.SERVICE_TYPE') ] )->default(config('constants.PRODUCT_TYPE') );
            $table->longText('industry')->nullable();
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('products');
    }
}
