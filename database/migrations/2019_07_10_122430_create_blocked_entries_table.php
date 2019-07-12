<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockedEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocked_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('judge_id')->unsigned();
            $table->bigInteger('brand_id')->unsigned();
            $table->timestamps();

            $table->foreign('brand_id')->references('id')
                ->on('brands')->onDelete('cascade');
            $table->foreign('judge_id')->references('id')
                ->on('judges')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blocked_entries');
    }
}
