<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_crawl_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seo_id');
            $table->longtext('content');
            $table->longtext('nlp');
            $table->longtext('terms');
            $table->longtext('headings');
            $table->longtext('titles');
            $table->longtext('paragraphs');
            $table->longtext('words');
            $table->longtext('images');
            $table->enum('status', ['0', '1','2'])->default('0');
            $table->timestamps();

            $table->foreign('seo_id')->references('id')->on('seo_keywords');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo_crawl_data');
    }
};
