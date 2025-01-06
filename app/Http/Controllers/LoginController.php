<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Schools;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display a form of the login.
     */
    public function login(): View
    {
        return view('login');
    }

    /**
     * Check Login credentials.
     */
    public function checkLogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {

            if(Auth::user()->hasRole('Scrutiny')){
                return redirect()->intended('first-scrutinize-count'); // Change to your desired redirect route
            }elseif(Auth::user()->hasRole('Review')){
                return redirect()->intended('first-review-count'); // Change to your desired redirect route
            }elseif(Auth::user()->hasRole('View')){
                return redirect()->intended('first-review-count'); // Change to your desired redirect route
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    /**
     * Display a form of the logout.
     */
    public function logout()
    {
//        Session::flush();
        Auth::logout();
        return redirect('/login'); // Change to your desired redirect route
    }
}
