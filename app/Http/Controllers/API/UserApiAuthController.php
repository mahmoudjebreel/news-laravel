<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserApiAuthController extends Controller
{

    function __construct()
    {

    }

    public function login(Request $request)
    {
        $request->validate([
            'mobile' => 'required|numeric|regex:/[0-9]{9}/|digits:9',
            'password' => 'required|string'
        ]);

        $user = User::where('mobile', $request->get('mobile'))->first();
        if ($user) {
            $this->revokePreviousTokens($user->id);
            if ($user->status == "Active") {
                $tokenResult = $user->createToken('NewsApp');
                $token = $tokenResult->accessToken;
                $user->setAttribute('token', $token);

                return response()->json([
                    'status' => true,
                    'message' => "Login Success",
                    'object' => $user,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Blocked account",
                ], 403);
            }

        } else {
            return response()->json([
                'status' => false,
                'message' => "Login failed!",
            ]);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name'=>'required|string|min:3|max:10',
            'last_name'=>'required|string|min:3|max:10',
            'email'=>'required|email',
            'mobile' => 'required|numeric|regex:/[0-9]{9}/|digits:9',
            'password'=>'required|string',
            'gender'=>'required|in:M,F'
        ]);

        $user = new User();
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');
        $user->mobile = $request->get('mobile');
        $user->password = Hash::make($request->get('password'));
        $user->gender = $request->get('gender') == "M" ? "Male" : "Female";
        $isSaved = $user->save();
        if ($isSaved){
            return response()->json([
                'status' => true,
                'message' => "Register Success",
                'object' => $user,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => "Register failed",
            ]);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    private function revokePreviousTokens($userId)
    {
        DB::table('oauth_access_tokens')
            ->where('user_id', $userId)
            ->update([
                'revoked' => true
            ]);
    }
}
