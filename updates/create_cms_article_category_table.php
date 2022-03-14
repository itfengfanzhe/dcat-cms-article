<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoryCmsArticleCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itffz_cms_article_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100)->nullable()->default('')->comment('标题');
            $table->integer('parent_id')->nullable()->default(0)->comment('父类');
            $table->string('icon')->nullable()->comment('图标');
            $table->integer('sort')->nullable()->default(0)->comment('排序');
            $table->tinyInteger('status')->nullable()->default(0)->comment('状态');
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
        Schema::dropIfExists('itffz_cms_article_category');
    }
}
