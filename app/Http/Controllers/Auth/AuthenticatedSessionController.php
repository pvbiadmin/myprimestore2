<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Application|Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        if ($request->user()->status === 'inactive') {
            Auth::guard('web')->logout();

            $request->session()->regenerateToken();

            /*toastr('account has been banned from website please connect with support!', 'error', 'Account Banned!');*/
            return redirect('/')
                ->with(['message' => 'Account Deactivated, Please Contact Support.', 'alert-type' => 'error']);
        }

        if ($request->user()->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } elseif ($request->user()->role === 'vendor') {
            return redirect()->intended('/vendor/dashboard');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user(); // Get the logged-in user

        Auth::guard('web')->logout();

        event(new Logout('web', $user)); // Pass the guard and user instance

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
