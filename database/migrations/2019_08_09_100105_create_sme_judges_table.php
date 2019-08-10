<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmeJudgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sme_judges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('judge_id');
            $table->string('id_string')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('sme_judges');
    }
}
