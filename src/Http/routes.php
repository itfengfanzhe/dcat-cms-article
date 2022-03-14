<?php

use Dcat\Admin\CmsArticle\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::resource('cms-article', Controllers\CmsArticleController::class);
Route::resource('cms-article-category', Controllers\CmsArticleCategory::class);
