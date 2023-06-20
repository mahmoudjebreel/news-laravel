<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:author')->except('logout');
    }

    public function showLoginForm()
    {
        return view('author.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        if (Auth::guard('author')->attempt($credentials, true)){
            switch (Auth::guard('author')->user()->status) {
                case "Active":
                    return redirect()->route('author.dashboard');
                    break;

                case "Blocked":
                    //Design a page for blocked!
                    break;
            }
        }else{
            return redirect()->back();
        }
    }

    public function logout(){
        Auth::guard('author')->logout();
//        $request->session()->invalidate();
        return redirect()->route('author.auth.login');
    }
}
