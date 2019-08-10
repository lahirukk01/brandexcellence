<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCsrScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csr_scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('brand_id')->unsigned();
            $table->bigInteger('judge_id')->unsigned();
            $table->decimal('intent', 5, 2);
            $table->decimal('recipient', 5, 2);
            $table->decimal('purpose', 5, 2);
            $table->decimal('vision', 5, 2);
            $table->decimal('mission', 5, 2);
            $table->decimal('identity', 5, 2);
            $table->decimal('strategic', 5, 2);
            $table->decimal('activities', 5, 2);
            $table->decimal('communication', 5, 2);
            $table->decimal('internal', 5, 2);
            $table->decimal('total', 5, 2);
            $table->enum('round', [1, 2]);
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
        Schema::dropIfExists('csr_scores');
    }
}
