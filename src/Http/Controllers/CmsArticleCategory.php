<?php

namespace Dcat\Admin\CmsArticle\Http\Controllers;

use Dcat\Admin\Admin;
use Dcat\Admin\CmsArticle\CmsArticleServiceProvider;
use Dcat\Admin\CmsArticle\Models\ArticleCategory;
use Dcat\Admin\CmsArticle\Models\Articles;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;

class CmsArticleCategory extends AdminController
{
    public function grid()
    {
        return Grid::make(new ArticleCategory(), function (Grid $grid) {
            $grid->tools("<a href='/admin/cms-article' class='btn btn-primary btn-outline'>文章列表</a>");
            if (CmsArticleServiceProvider::setting('qulick_create_category')) { // 判断是否在配置中开启
                // 快捷创建一个分类
                $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
                    $create->text('title', '分类标题');
                    $create->select('parent_id', '父类')->options(ArticleCategory::getMap());
                });
            }
            $grid->disableViewButton();
            $grid->column('id', 'ID')->sortable();
            $grid->column('title', '标题');
            $grid->column('status', '状态')->switch();
            $grid->column('sort', '排序')->editable();

        });
   }

    public function form()
    {
        return Form::make(new ArticleCategory(), function (Form $form) {
            $form->disableViewButton();
            $form->text('title', '标题');
            $form->select('parent_id', '父类');
            $form->image('icon', 'icon')->uniqueName();
            $form->switch('status', '状态')->default(1);

        });
    }
}
