<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJudgePanelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('judge_panel', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('judge_id')->unsigned();
            $table->bigInteger('panel_id')->unsigned();
            $table->timestamps();

            $table->foreign('judge_id')->references('id')
                ->on('judges')->onDelete('cascade');
            $table->foreign('panel_id')->references('id')->on('panels')
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
        Schema::dropIfExists('judge_panel');
    }
}
