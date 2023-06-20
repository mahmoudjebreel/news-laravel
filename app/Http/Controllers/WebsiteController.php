<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;

class WebsiteController extends Controller
{
    //
    public function showHome()
    {
        $categories = Category::where('visibility_status', 'Visible')->get();
        $latestArticles = Article::orderBy('created_at', 'desc')
            ->where('visibility_status', 'Visible')
            ->limit(3)
            ->get();

        return view('website.home', [
            'categories' => $categories,
            'latestArticles' => $latestArticles
        ]);
    }

    public function showCategoryArticles($id)
    {
//        $articles = Article::where('category_id',$id)->get();
        $categories = Category::where('visibility_status', 'Visible')->get();
        $category = Category::with(['articles' => function ($query) {
            $query->where('visibility_status', 'Visible');
        }])->find($id);
        return view('website.news', ['categories' => $categories, 'category' => $category]);
    }

    public function showArticleDetails($id)
    {
        $article = Article::find($id);
        $categories = Category::where('visibility_status', 'Visible')->get();
        return view('website.news_details', ['categories' => $categories, 'article' => $article]);
    }

}
