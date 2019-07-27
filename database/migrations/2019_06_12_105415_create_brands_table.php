<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_id')->unsigned();
            $table->string('name');
            $table->text('description');
            $table->string('entry_kit');
            $table->string('logo');
            $table->string('supporting_material')->nullable();
            $table->string('id_string');
            $table->boolean('show_options')->default(1);
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('industry_category_id')->unsigned();
            $table->boolean('r2_selected')->default(false);
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('industry_category_id')->references('id')->on('industry_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
    }
}
