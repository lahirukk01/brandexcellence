<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndustryCategoryJudgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industry_category_judge', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('judge_id')->unsigned();
            $table->bigInteger('industry_category_id')->unsigned();
            $table->timestamps();

            $table->foreign('industry_category_id')->references('id')
                ->on('industry_categories')->onDelete('cascade');
            $table->foreign('judge_id')->references('id')->on('judges')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('industry_category_judge');
    }
}
