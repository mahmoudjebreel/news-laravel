<?php

namespace App\Http\Controllers\CMS;

use App\Article;
use App\Author;
use App\Category;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $articles = Article::with(['category', 'author'])->get();
        return view('cms.articles.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        $authors = Author::where('status', 'Active')->get();
        return view('cms.articles.create', [
            'categories' => $categories,
            'authors' => $authors
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'category_id' => 'required|exists:categories,id|integer',
            'author_id' => 'required|exists:authors,id|integer',
            'article_title' => 'required|string|min:10|max:50',
            'article_short_description' => 'required|string|min:20|max:150',
            'article_full_description' => 'required|string|min:40',
            'article_image' => 'required',
            'article_visibility_status' => 'required|in:on,off'
        ]);

        $articleImage = $request->file('article_image');

        $timeNow = Carbon::now();

        $time = $timeNow->minute . '_' . $timeNow->second;
        $name = $time . '_' . $request->get('article_title') . '_' . $articleImage->getClientOriginalName();

        $articleImage->move('images/articles/', $name);

        $article = new Article();
        $article->title = $request->get('article_title');
        $article->short_description = $request->get('article_short_description');
        $article->full_description = $request->get('article_full_description');
        $article->visibility_status = $request->get('article_visibility_status') == 'on' ? 'Visible' : 'Hidden';
        $article->category_id = $request->get('category_id');
        $article->author_id = $request->get('author_id');
        $article->image = $name;
        $isSaved = $article->save();

        Mail::to('momen.sisalem@gmail.com')->send(new \App\Mail\NewArticleEmail($article));

        $message = $isSaved ? "Article created Successfully" : "Failed to create article!";
        session()->flash('status', $isSaved);
        session()->flash('message', $message);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     * @param int $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
        //
        $categories = Category::all();
        $article = Article::find($id);
        return view('cms.articles.edit', ['article' => $article, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        //
        $request->request->add(['id' => $id]);
        $request->validate([
            'id' => 'required|exists:articles,id|integer',
            'category_id' => 'required|exists:categories,id|integer',
            'article_title' => 'required|string|min:10|max:50',
            'article_short_description' => 'required|string|min:20|max:150',
            'article_full_description' => 'required|string|min:40',
            'article_image' => 'required',
            'article_visibility_status' => 'in:on,off'
        ]);

        $article = Article::find($id);
        $article->title = $request->get('article_title');
        $article->short_description = $request->get('article_short_description');
        $article->full_description = $request->get('article_full_description');
        $article->visibility_status = $request->get('article_visibility_status') == 'on' ? 'Visible' : 'Hidden';
        $article->category_id = $request->get('category_id');
        $article->image = 'image';
        $isSaved = $article->save();

        $message = $isSaved ? "Article updated Successfully" : "Failed to update article!";
        session()->flash('status', $isSaved);
        session()->flash('message', $message);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
        //
        $isDeleted = Article::destroy($id);
        if ($isDeleted) {
            return redirect()->route('admin.articles.index');
        } else {

        }
    }
}
