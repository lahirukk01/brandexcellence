<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('intent');
            $table->integer('content');
            $table->integer('health');
            $table->integer('performance');
            $table->integer('total');
            $table->text('good')->nullable();
            $table->text('bad')->nullable();
            $table->text('improvement')->nullable();
            $table->bigInteger('brand_id');
            $table->bigInteger('user_id');
            $table->timestamps();

            $table->foreign('brand_id')->references('id')
                ->on('brands')->onDelete('cascade');
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brand_user');
    }
}
