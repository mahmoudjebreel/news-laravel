<?php

namespace App\Http\Controllers\CMS;

use App\Article;
use App\Category;
use App\Http\Controllers\Controller;

class CMSDashboardController extends Controller
{
    //

    public function showAdminDashboard()
    {
        $categoriesCount = Category::count();
        $articlesCount = Article::count();
        $authorsCount = Article::count();

        return view('cms.dashboard', ['categoriesCount' => $categoriesCount, 'articlesCount' => $articlesCount, 'authorsCount' => $authorsCount]);
    }
}
