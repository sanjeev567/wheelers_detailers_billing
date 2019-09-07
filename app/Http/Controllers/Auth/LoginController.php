<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'mobile';
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // check that the user role is allowed to log-in on website
        if(!in_array($user->role, ['admin'])){
            $this->guard()->logout();
            $request->session()->invalidate();

           return $this->sendFailedLoginResponse($request);
        }

        if ($user->active == 0) {
            $this->guard()->logout();
            $request->session()->invalidate();

            $errors = [$this->username() => 'Please wait for account activation'];

            if ($request->expectsJson()) {
                return response()->json($errors, 422);
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['status' => 1, 'data' => $user]);
        }
    }
}
