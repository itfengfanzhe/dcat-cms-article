<?php
namespace Dcat\Admin\CmsArticle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Articles extends Model
{
    use SoftDeletes;

    protected $table = 'itffz_cms_articles';

}
