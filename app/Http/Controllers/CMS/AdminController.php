<?php

namespace App\Http\Controllers\CMS;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $admins = Admin::all();
        return view('cms.admins.index', ['admins' => $admins]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('cms.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            'email' => 'required|email|unique:authors,email',
            'mobile' => 'required|numeric|regex:/[0-9]{12}/|digits:12|unique:admins,mobile',
            'age' => 'required|numeric',
            'password' => 'required',
            'gender' => 'required|string|in:Male,Female',
        ]);

        $admin = new Admin();
        $admin->first_name = $request->get('first_name');
        $admin->last_name = $request->get('last_name');
        $admin->email = $request->get('email');
        $admin->mobile = $request->get('mobile');
        $admin->age = $request->get('age');
        $admin->gender = $request->get('gender') == "Male" ? "M" : "F";
        $admin->password = Hash::make($request->get('password'));
        $isSaved = $admin->save();

        $message = $isSaved ? "CMS Created Successfully" : "Failed to create admin!";
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
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        //
        $admin = Admin::find($id);
        return view('cms.admins.edit', ['admin' => $admin]);
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
            'id' => 'required|exists:admins,id|numeric',
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            'email' => 'required|email|unique:authors,email,' . $id,
            'mobile' => 'required|numeric|regex:/[0-9]{12}/|digits:12|unique:admins,mobile,' . $id,
            'age' => 'required|numeric',
            'password' => 'required',
            'gender' => 'required|string|in:Male,Female',
        ]);

        $admin = Admin::find($id);
        $admin->first_name = $request->get('first_name');
        $admin->last_name = $request->get('last_name');
        $admin->email = $request->get('email');
        $admin->mobile = $request->get('mobile');
        $admin->age = $request->get('age');
        $admin->gender = $request->get('gender') == "Male" ? "M" : "F";
        $admin->password = Hash::make($request->get('password'));
        $isSaved = $admin->save();

        $message = $isSaved ? "CMS Updated Successfully" : "Failed to update admin!";
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
        $isDeleted = Admin::destroy($id);
        if ($isDeleted) {
            return response()->json(['title' => 'Deleted', 'message' => "Admin Deleted Successfully", 'type' => "success"], 200);
        }else{
            return response()->json(['title' => 'Error', 'message' => "Admin Delete Failed!", 'type' => "error"], 400);
        }
    }
}
