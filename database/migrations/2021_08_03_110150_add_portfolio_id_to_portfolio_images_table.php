<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPortfolioIdToPortfolioImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('portfolio_images', function (Blueprint $table) {
            
            $table->unsignedBigInteger('portfolio_id');

            $table->foreign('portfolio_id')->references('id')->on('portofolio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('portfolio_images', function (Blueprint $table) {
            //
        });
    }
}
