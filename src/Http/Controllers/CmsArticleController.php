<?php

namespace Dcat\Admin\CmsArticle\Http\Controllers;

use Dcat\Admin\Admin;
use Dcat\Admin\CmsArticle\CmsArticleServiceProvider;
use Dcat\Admin\CmsArticle\Models\ArticleCategory;
use Dcat\Admin\CmsArticle\Models\Articles;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;

class CmsArticleController extends AdminController
{
    public $category_options = [];

    public function __construct()
    {
        if (CmsArticleServiceProvider::setting('category_extend') == 'itfengfanzhe.dcat-admin-cms-article') { // 内置框架
            $this->category_options = ArticleCategory::getMap();
        } else if (CmsArticleServiceProvider::setting('category_extend') == 'itfengfanzhe.dcat-admin-category') { // 分类扩展
            // 判断是否开启了扩展
            if (!Admin::extension()->enabled('itfengfanzhe.dcat-admin-category')) {
                throw new \Exception('请开启itfengfanzhe.dcat-admin-category扩展，获将分类模型设置为内置');
            }
            $this->category_options = \Dcat\Admin\Category\Models\Category::cateMap(null, 'itffz_cms_article');
        } else if (CmsArticleServiceProvider::setting('category_extend') == 'api') { // 自定义接口
            $setting_api = CmsArticleServiceProvider::setting('category_model');
            if (empty($setting_api)) {
                throw new \Exception('请配置分类模型方法，或更改为内置分类');
            }
            $model = explode('.', $setting_api)[0];
            $action = explode('.', $setting_api)[1] ?? '';
            $model = "App\\Models\\$model";
            if (class_exists($model)) {
                if (method_exists($model, $action)) {
                    $this->category_options = (new $model)?->$action() ?? [];
                } else {
                    throw new \Exception($model.'数据模型中的'.$action.'方法不存在，请检查配置');
                }
            } else {
                throw new \Exception($model.'数据模型不存在');
            }
        }
    }

    public function grid()
    {
        return Grid::make(new Articles(), function (Grid $grid) {
            if (!CmsArticleServiceProvider::setting('category_extend') || CmsArticleServiceProvider::setting('category_extend') == 'itfengfanzhe.dcat-admin-cms-article') {
                $grid->tools("<a href='/admin/cms-article-category' class='btn btn-primary btn-outline'>分类管理</a>");
            } else if (CmsArticleServiceProvider::setting('category_extend') == 'itfengfanzhe.dcat-admin-category') {
                $grid->tools("<a href='/admin/category?table=itffz_cms_article' class='btn btn-primary btn-outline'>分类管理</a>");
            }
            $grid->model()->orderBy('id', 'desc');
            $grid->disableViewButton();
            if (CmsArticleServiceProvider::setting('qulick_create_category') && CmsArticleServiceProvider::setting('category_extend') == 'itfengfanzhe.dcat-admin-cms-article') { // 判断是否在配置中开启
                // 快捷创建一个分类
                $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
                    $create->action('cms-article-category');
                    $create->text('title', '分类标题');
                    $create->select('parent_id', '父类')->options($this->category_options);
                    $create->hidden('status', 1);
                });
            }

            $grid->column('id', 'ID')->sortable();
            $grid->column('title', '标题');
            $grid->column('image', '封面图')->image('', 60, 60);
            $grid->column('tags', '标签')->label();
            $grid->column('author', '作者');
            $grid->column('origin', '来源');
            $grid->column('sort', '排序')->editable();
            $grid->column('click', '点击量');
            $grid->column('status', '状态')->switch();
            $grid->column('is_hot', '热门')->switch();
            $grid->column('is_top', '置顶')->switch();

            $grid->quickSearch(['title', 'description']);
        });
   }

    public function form()
    {
        return Form::make(new Articles(), function (Form $form) {
            $form->text('title', '标题');
            $form->select('category_id', '分类')->options($this->category_options);
            $form->textarea('description', '描述');
            $form->text('keywords', '关键词');
            $form->tags('tags', '标签')->saveAsJson();
            $form->image('image', '封面图')->uniqueName();
            $form->multipleImage('images', '多图')->uniqueName()->saveAsJson();
            $form->radio('content_type', '内容类型')->options(['1' => '富文本', 2 => 'markdown']);
            $form->editor('content', '内容');
            $form->hidden('created_by')->default(Admin::user()->id);
            $form->hidden('created_where')->default(1);
            $form->number('sort', '排序')->default(0);
            $form->text('author', '作者');
            $form->text('origin', '来源');
            $form->switch('status', '状态');
            $form->switch('is_hot', '热门');
            $form->switch('is_top', '置顶');
        });
    }
}
