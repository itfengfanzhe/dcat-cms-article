<?php

namespace Dcat\Admin\CmsArticle;

use Dcat\Admin\Admin;
use Dcat\Admin\Extend\Setting as Form;

class Setting extends Form
{
    public function form()
    {
        // 这里的扩展都是我之前开发的，看看是否安装，如果安装了就能用，目前没有找到更好的方法去调用
        $category_extend['itfengfanzhe.dcat-admin-cms-article'] = '内置分类';
        if (Admin::extension()->enabled('itfengfanzhe.dcat-admin-category')) {
            $category_extend["itfengfanzhe.dcat-admin-category"] = 'dcat-admin-category';
        }

        $category_extend['api'] = '自定义模型';
        $this->tab('分类设置', function ()use($category_extend) {
            $this->switch('qulick_create_category', '快捷创建分类');
//            $this->switch('open_category', '内置分类功能')->default(1)->help('是否开启内容之分，如果开始则其他分类使用方式则不能用');
            if (!empty($category_extend)) {
                $this->radio('category_extend', '分类扩展')->options($category_extend)->default('itfengfanzhe.dcat-admin-cms-article');
            }
            $this->text('category_model', '分类模型')->help('当分类扩展为自定义模型时可用。自定义方法example:Category.getMap注意大小写,返回一个数组[$key=>$val...]');

        });
    }
}
