<?php
namespace Dcat\Admin\CmsArticle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCategory extends Model
{
    use SoftDeletes;

    protected $table = 'itffz_cms_article_category';

    /**
     * 获取所有分类，键值形式返回
     * @param null $index
     * @return array|mixed|string
     * @author 张建伟 <itfengfanzhe@163.com>
     */
    public static function getMap($index = null)
    {
        $map = ArticleCategory::query()->where('status', 1)->pluck('title', 'id')?->toArray() ?? [];

        if ($index === null) return $map;

        return $map[$index] ?? '';
    }

}
