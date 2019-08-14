<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('brand_name');
            $table->string('company');
            $table->boolean('r2_selected')->default(false);
            $table->bigInteger('auditor_id')->unsigned()->nullable();
            $table->enum('medal', ['Gold', 'Silver', 'Bronze', 'Merit'])->nullable();
            $table->timestamps();

            $table->foreign('auditor_id')->references('id')
                ->on('auditors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('smes');
    }
}
