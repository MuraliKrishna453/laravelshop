<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    protected function sendLoginResponse(Request $request) {
        $user = $request->user();
        $token = $user->createToken($user->email)->accessToken;
        if($user->role=='admin'){
            $admin = $user;
            return response()->json(compact('admin', 'token'));
        }else{
            return response()->json(compact('user', 'token'));
        }
    }

    public function logout() {
        try {
            if (\Auth::guard('api')->user() != null) {
                \Auth::guard('api')->user()->token()->revoke();
                \Auth::guard('api')->user()->token()->delete();
            }
        } catch (Exception $ex) {
            return response()->json('Technical Error Occurred', 500);
        }

        return response()->json('User Logged Out', 200);
    }

}
