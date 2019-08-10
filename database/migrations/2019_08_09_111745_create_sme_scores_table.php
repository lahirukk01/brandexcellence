<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmeScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sme_scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sme_id')->unsigned();
            $table->bigInteger('judge_id')->unsigned();
            $table->decimal('opportunity', 5, 2);
            $table->decimal('satisfaction', 5, 2);
            $table->decimal('description', 5, 2);
            $table->decimal('targeting', 5, 2);
            $table->decimal('decision', 5, 2);
            $table->decimal('identity', 5, 2);
            $table->decimal('pod', 5, 2);
            $table->decimal('marketing', 5, 2);
            $table->decimal('performance', 5, 2);
            $table->decimal('engagement', 5, 2);
            $table->decimal('total', 5, 2);
            $table->text('good');
            $table->text('bad');
            $table->text('improvement');
            $table->enum('round', [1, 2]);
            $table->boolean('judge_finalized')->default(false);
            $table->timestamps();

            $table->foreign('sme_id')->references('id')
                ->on('smes')->onDelete('cascade');
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
        Schema::dropIfExists('sme_scores');
    }
}
