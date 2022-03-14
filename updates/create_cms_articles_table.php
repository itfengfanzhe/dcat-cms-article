<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itffz_cms_articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255)->nullable()->default('')->comment('标题');
            $table->string('description', 500)->nullable()->default('')->comment('描述');
            $table->string('keywords', 500)->nullable()->default('')->comment('关键词');
            $table->jsonb('tags')->nullable()->comment('标签');
            $table->string('image')->nullable()->comment('封面图');
            $table->json('images')->nullable()->comment('多图');
            $table->longText('content')->nullable()->comment('内容');
            $table->tinyInteger('content_type')->nullable()->default(1)->comment('内容类型，1富文本2markdown');
            $table->tinyInteger('created_by')->nullable()->default(0)->comment('创建人');
            $table->tinyInteger('created_where')->nullable()->default(0)->comment('创建位置');
            $table->string('author')->nullable()->comment('作者');
            $table->string('origin')->nullable()->comment('来源');
            $table->tinyInteger('status')->nullable()->default(0)->comment('状态0关闭，1正常');
            $table->tinyInteger('is_hot')->nullable()->default(0)->comment('是否热门');
            $table->tinyInteger('is_top')->nullable()->default(0)->comment('是否置顶');
            $table->integer('click')->nullable()->default(0)->comment('点击量');
            $table->integer('sort')->nullable()->default(0)->comment('排序');
            $table->integer('category_id')->nullable()->default(0)->comment('分类id');
            $table->integer('categorys')->nullable()->default(0)->comment('多级分类，一个文章可以归属N个分类');
            $table->jsonb('extend_field')->nullable()->comment('扩展字段');
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
        Schema::dropIfExists('itffz_cms_articles');
    }
}
