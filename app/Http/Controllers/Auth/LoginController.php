<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];

        // Only validate reCAPTCHA in production/non-local environments to avoid localhost blocked key issues
        if (!app()->environment('local')) {
            $rules['g-recaptcha-response'] = ['required', 'recaptcha'];
        }

        $request->validate($rules, [
            'g-recaptcha-response.required' => 'Mohon selesaikan Captcha.',
            'g-recaptcha-response.recaptcha' => 'Captcha tidak valid.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return $this->redirectBasedOnRole();
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    // Google Login Redirect
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Google Login Callback
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->orWhere('email', $user->email)->first();

            if ($finduser) {
                // Update google_id if not set
                if (!$finduser->google_id) {
                    $finduser->update([
                        'google_id' => $user->id,
                        'avatar' => $user->avatar
                    ]);
                }
                Auth::login($finduser);
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'avatar' => $user->avatar,
                    'password' => null, // Password can be null for Google users
                    'role' => 'customer'
                ]);

                Auth::login($newUser);
            }

            return $this->redirectBasedOnRole();

        } catch (Exception $e) {
            return redirect('/login')->withErrors(['email' => 'Gagal login via Google: ' . $e->getMessage()]);
        }
    }

    protected function redirectBasedOnRole()
    {
        if (auth()->user()->role == 'admin') {
            return redirect('/admin/dashboard');
        } elseif (auth()->user()->role == 'courier') {
            return redirect('/courier/orders');
        }

        return redirect('/'); // customer
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }
}
