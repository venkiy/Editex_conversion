<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('publisher_id')->nullable();
            $table->string('publisher_name')->nullable();
            $table->string('article_id')->unique();            
            $table->unsignedTinyInteger('noecs')->default(0);
            $table->timestamp('noecse_start')->nullable();
            $table->timestamp('noecse_end')->nullable();
            $table->unsignedTinyInteger('galleypdf')->default(0);
            $table->timestamp('galleypdf_start')->nullable();
            $table->timestamp('galleypdf_end')->nullable();
            $table->unsignedTinyInteger('typeset')->default(0);
            $table->timestamp('typeset_start')->nullable();
            $table->timestamp('typeset_end')->nullable();
            $table->unsignedTinyInteger('active')->default(1);
            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
