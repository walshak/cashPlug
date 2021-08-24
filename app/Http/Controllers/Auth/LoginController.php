<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
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
    //protected $redirectTo = RouteServiceProvider::HOME;

    protected function redirectTo()
    {
        if (Auth::user()->role == 2) {
            return redirect()->route('user.dashboard');
        } elseif (Auth::user()->role == 1) {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role == 0) {
            return redirect()->route('super-admin.dashboard');
        }
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

    public function login(Request $request)
    {
        if ($request->remember) {
            $inputs = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'remember' => 'nullable'

            ]);
            if (Auth::attempt(['email' => $inputs['email'], 'password' => $inputs['password']], $inputs['remember'])) {
                if (Auth::user()->role == 2) {
                    return redirect()->route('users.dashboard');
                } elseif (Auth::user()->role == 1) {
                    return redirect()->route('admin.dashboard');
                } elseif (Auth::user()->role == 0) {
                    return redirect()->route('super-admin.dashboard');
                }
            } else {
                return redirect()->route('login')->with('err', 'Incorrect email or password');
            }
        } else {

            $inputs = $request->validate([
                'email' => 'required|email',
                'password' => 'required',

            ]);

            if (Auth::attempt(['email' => $inputs['email'], 'password' => $inputs['password']])) {
                if (Auth::user()->role == 2) {
                    return redirect()->route('users.dashboard');
                } elseif (Auth::user()->role == 1) {
                    return redirect()->route('admin.dashboard');
                } elseif (Auth::user()->role == 0) {
                    return redirect()->route('super-admin.dashboard');
                }
            } else {
                return redirect()->route('login')->with('err', 'Incorrect email or password');
            }
        }
    }
}
