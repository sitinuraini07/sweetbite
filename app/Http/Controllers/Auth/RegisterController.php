<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        // Only validate reCAPTCHA in production/non-local environments to avoid localhost blocked key issues
        if (!app()->environment('local')) {
            $rules['g-recaptcha-response'] = ['required', 'recaptcha'];
        }

        $request->validate($rules, [
            'g-recaptcha-response.required' => 'Mohon selesaikan Captcha.',
            'g-recaptcha-response.recaptcha' => 'Captcha tidak valid.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email welcome ke ' . $user->email . ': ' . $e->getMessage());
        }

        Auth::login($user);

        return redirect('/home');
    }
}
