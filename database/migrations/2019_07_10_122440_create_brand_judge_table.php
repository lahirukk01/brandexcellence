<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandJudgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_judge', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('intent', 5, 2);
            $table->decimal('content', 5, 2);
            $table->decimal('process', 5, 2);
            $table->decimal('health', 5, 2);
            $table->decimal('performance', 5, 2);
            $table->decimal('total', 5, 2);
            $table->text('good')->nullable();
            $table->text('bad')->nullable();
            $table->text('improvement')->nullable();
            $table->bigInteger('brand_id')->unsigned();
            $table->bigInteger('judge_id')->unsigned();
            $table->enum('round', [1, 2])->default(1);
            $table->boolean('judge_finalized')->default(false);
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
        Schema::dropIfExists('brand_judge');
    }
}
