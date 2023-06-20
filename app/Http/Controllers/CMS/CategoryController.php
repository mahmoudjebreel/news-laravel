<?php

namespace App\Http\Controllers\CMS;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::withCount('articles')->get();
//        $categories = Category::where('visibility_status', 'Visible')
//            ->orderBy('title', 'asc')
//            ->take(10)
//            ->get();

        return view('cms.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        session()->put(['name'=>'Laravel Course']);
//        session()->forget('name');
//        session()->flush();
//        session()->flash('success_message','Category Created');
//        dd(session()->get('success_message'));

        return view('cms.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'category_title' => 'required|string|min:3|max:20',
            'category_details' => 'required|string|min:3|max:100',
            'category_visibility_status' => 'required|in:on,off'
        ], [
            'category_title.required' => 'Please enter category title!',
            'category_title.min' => 'Category title must be at least 3 characters'
        ]);

        $category = new Category();
        $category->title = $request->get('category_title');
        $category->details = $request->get('category_details');
        $category->visibility_status = $request->get('category_visibility_status') == "on" ? "Visible" : "Hidden";
        $isSaved = $category->save();

        $message = $isSaved ? "Category Created Successfully" : "Failed to create category!";
        session()->flash('status', $isSaved);
        session()->flash('message', $message);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $category = Category::find($id);
        if (!is_null($category)) {
            echo "Category name: " . $category->title;
        } else {
            echo "Not Found";
        }
    }

    public function showArticles($id)
    {
//        $articles = Article::where('category_id',$id)->get();
        $category = Category::with(['articles' => function ($query) use ($id) {
            $query->where('category_id', $id);
        }])->find($id);

        return view('cms.articles.index', ['articles' => $category->articles]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
        //
        $category = Category::find($id);
        return view('cms.categories.edit', ['category' => $category]);
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
        $request->request->add(['category_id' => $id]);
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'category_title' => 'required|string|min:3|max:20',
            'category_details' => 'required|string|min:3|max:100',
            'category_visibility_status' => 'required|in:on,off'
        ], [
            'category_title.required' => 'Please enter category title!',
            'category_title.min' => 'Category title must be at least 3 characters'
        ]);

        $category = Category::find($id);
        $category->title = $request->get('category_title');
        $category->details = $request->get('category_details');
        $category->visibility_status = $request->get('category_visibility_status') == "on" ? "Visible" : "Hidden";
        $isSaved = $category->save();

        $message = $isSaved ? "Category Updated Successfully" : "Failed to update category!";
        session()->flash('status', $isSaved);
        session()->flash('message', $message);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $isDeleted = Category::destroy($id);
        if ($isDeleted) {
            return redirect()->route('admin.categories.index');
        } else {

        }
    }
}
