<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::where('visibility_status', 'Visible')->get();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'categories' => $categories
        ]);
    }

    public function showArticles(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $request->validate(['id' => 'required|exists:categories,id|numeric']);
//        $articles = Article::where('category_id',$id)->get();
        $category = Category::with('articles')->find($id);
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'articles' => $category->articles
        ]);
    }
}
