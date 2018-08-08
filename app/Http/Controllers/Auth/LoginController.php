<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Lang;
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

    protected $maxAttempts = 4;
    protected $decayMinutes = 5;

    /**
     * Where to redirect users after login.
     *
     */

    public function redirectTo()
    {
        return '/'.LaravelLocalization::getCurrentLocale().'/admin/'.Auth::id().'/dashboard';
    }

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
     * Functionality that is applied when login attempts are out of limit
     *
     * @param Request $request
     * @return mixed
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        return view('auth.login')
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                'attempt_limit_alert' =>Lang::get('auth.throttle', ['seconds' => ""]),
                'attempts' =>  false,
                'seconds' => $seconds
            ]);
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

    }

    /**
     * Get the throttle key for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function throttleKey(Request $request)
    {
        //-- Generate throttle key based on current IP address
        return $request->ip();
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                $this->username() => Lang::get('auth.failed'),
            ], 422);
        }


        //-- Get number of already used login attempts
        $attempts = $this->limiter()->attempts(
            $this->throttleKey($request)
        );


        //-- Get number of attempts that are left from this IP address
        $attemptsLeft = ($this->maxAttempts()+1) - $attempts;

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => Lang::get('auth.failed'),
                'attempts_left' =>  Lang::get('auth.attempts_left',['attemptsLeft' => $attemptsLeft])
            ]);
    }

}
