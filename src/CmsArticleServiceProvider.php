<?php

namespace Dcat\Admin\CmsArticle;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;

class CmsArticleServiceProvider extends ServiceProvider
{
	protected $js = [
        'js/index.js',
    ];
	protected $css = [
		'css/index.css',
	];

    // 定义菜单
    protected $menu = [
        [
            'title' => '文章管理',
            'uri'   => 'cms-article',
            'icon'  => '', // 图标可以留空
        ],
    ];

	public function register()
	{
		//
	}

	public function init()
	{
		parent::init();

		//

	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
