<?php

namespace App\Http\Controllers\Auth;

use App\Entities\PasswordReset;
use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\MessageService;
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

    /**
     * Forgot user password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse;|\Illuminate\Http\JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        try {
            $requestData = $request->all();
            $user = User::select('id', 'mobile', 'name')
                ->where('mobile', $requestData['mobile'])
                ->first();

            if (!empty($user)) {
                $resetToken = bcrypt($user->id . time());

                $resetId = \DB::table('password_resets')->insertGetId([
                    "mobile" => $user->mobile,
                    "user_id" => $user->id,
                    "token" => $resetToken,
                ]);

                $passwordResetData = [];
                if ($resetId) {
                    $otpResponse = MessageService::sendOtp($user->mobile);
                    $otpResponse = json_decode($otpResponse);
                    if ($otpResponse->type != 'error') {
                        $passwordResetData = [
                            "reset_id" => $resetId,
                            "mobile" => isset($user->mobile) ? $user->mobile : null,
                            "name" => isset($user->name) ? $user->name : null,
                            "reset_token" => $resetToken,
                            "otp_response" => $otpResponse,
                        ];

                        return redirect('verify-otp/' . encrypt($passwordResetData['mobile']) . '/' . encrypt($passwordResetData['reset_token']));
                    } else {
                        return view("forgot-password")->with([
                            "data" => null,
                            'error' => 'Unable to send OTP',
                        ]);
                    }

                } else {
                    return view("forgot-password")->with([
                        "data" => null,
                        'error' => 'Some error occured, plese try again',
                    ]);
                }
            } else {
                return view("forgot-password")->with([
                    "data" => null,
                    'error' => 'Mobile number not found',
                ]);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Forgot user password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse;|\Illuminate\Http\JsonResponse
     */
    public function verifyOtp(Request $request)
    {
        try {
            $requestData = $request->all();
            $otpResponse = MessageService::verifyOtp($requestData);
            $otpResponse = json_decode($otpResponse);

            if (!is_object($otpResponse) ) {
                return view("verify-otp")->with([
                    "mobile" => $requestData['mobile'],
                    "masked_mobile" => substr_replace(decrypt($requestData['mobile']), "*****", 2, 5),
                    "token" => $requestData['reset-token'],
                    "error" => 'Some Error Occured. Please try again later',
                ]);
            }

            if (is_object($otpResponse) && $otpResponse->type != 'error') {
                return redirect('reset-password/' . $requestData['reset-token']);
            } else {
                return view("verify-otp")->with([
                    "mobile" => $requestData['mobile'],
                    "masked_mobile" => substr_replace(decrypt($requestData['mobile']), "*****", 2, 5),
                    "token" => $requestData['reset-token'],
                    "error" => 'Incorrect OTP Entered',
                ]);
            }
        } catch (\Exception $e) {
            return $this->returnExceptionResponse($e);
        }
    }

    /**
     * Authenticating user with credentials
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse;|\Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        try {
            $requestData = $request->all();
            $token = decrypt($requestData['reset-token']);

            $user = PasswordReset::where('token', $token)
                ->where('status', 1)
                ->first();

            if (!empty($user)) {
                if ( $requestData['confirm-password'] != $requestData['password']) {
                    return \Redirect::back()->withErrors(['New Password and Confirm password must be same']);
                }

                User::where('id', $user->user_id)
                    ->update([
                        'password' => bcrypt($requestData['confirm-password']),
                        'password_txt' => $requestData['confirm-password'],
                    ]);
                PasswordReset::where('token', $token)
                    ->update([
                        'status' => 0,
                    ]);
                return redirect('login/');
            } else {
                return \Redirect::back()->withErrors(['Unable to reset password. Please try again later']);
            }
        } catch (\Exception $e) {
            return $this->returnExceptionResponse($e);
        }
    }

    /**
     * Function to return exception response
     */
    public function returnExceptionResponse(\Exception $e)
    {
        return response()->json(['status' => '0', 'msg' => $e->getMessage() . " on line " . $e->getLine() . " in file " . $e->getFile(), 'data' => null]);
    }

    /**
     * Returning forgot password view
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function forgotPasswordView()
    {
        return view("forgot-password");
    }

    /**
     * Returning reset password view
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function resetPasswordView($token)
    {
        return view("reset-password")->with([
            "token" => $token,
        ]);
    }

    /**
     * Returning reset password view
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function verifyOtpView($mobile, $token)
    {
        return view("verify-otp")->with([
            "mobile" => $mobile,
            "token" => $token,
            "masked_mobile" => substr_replace(decrypt($mobile), "*****", 2, 5),
        ]);
    }
}
