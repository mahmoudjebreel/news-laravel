<?php

namespace App\Http\Controllers\CMS;

use App\Author;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $authors = Author::withCount('articles')->get();
        return view('cms.authors.index', ['authors' => $authors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('cms.authors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            'email' => 'required|email|unique:authors,email',
            'password' => 'required|string|min:4',
            'gender' => 'required|string|in:Male,Female',
            'mobile' => 'required|numeric|regex:/[0-9]{12}/|digits:12|unique:authors,mobile'
        ]);

        $author = new Author();
        $author->first_name = $request->get('first_name');
        $author->last_name = $request->get('last_name');
        $author->email = $request->get('email');
        $author->password = Hash::make($request->get('password'));
        $author->gender = $request->get('gender') == "Male" ? "M" : "F";
        $author->mobile = $request->get('mobile');
        $isSaved = $author->save();

        $message = $isSaved ? "Author created Successfully" : "Failed to create author!";
        session()->flash('status', $isSaved);
        session()->flash('message', $message);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $author = Author::find($id);
        return view('cms.authors.edit', ['author' => $author]);
    }

    public function showArticles($id)
    {
        $author = Author::with('articles')->find($id);
        return view('cms.articles.index', ['articles' => $author->articles]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $author = Author::find($id);
        return view('cms.authors.edit', ['author' => $author]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->request->add(['id' => $id]);
        $request->validate([
            'id' => 'required|exists:authors,id',
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            'email' => 'required|email|unique:authors,email,' . $id,
            'gender' => 'required|string|in:Male,Female',
            'mobile' => 'required|numeric|regex:/[0-9]{12}/|digits:12|unique:authors,mobile,' . $id
        ]);

        $author = Author::find($id);
        $author->first_name = $request->get('first_name');
        $author->last_name = $request->get('last_name');
        $author->email = $request->get('email');
        $author->gender = $request->get('gender') == "Male" ? "M" : "F";
        $author->mobile = $request->get('mobile');
        $isSaved = $author->save();

        $message = $isSaved ? "Author updated Successfully" : "Failed to update author!";
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
        $isDestroyed = Author::destroy($id);
        if ($isDestroyed) {
            return redirect()->route('admin.authors.index');
        }
    }
}
