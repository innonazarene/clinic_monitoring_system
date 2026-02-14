<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\TwoFactorCodeMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class TwoFactorController extends Controller
{
    public function index(Request $request): Response|RedirectResponse
    {
        if (!$request->session()->has('2fa:user:id')) {
            return redirect()->route('login');
        }

        return Inertia::render('Auth/TwoFactorChallenge');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $userId = $request->session()->get('2fa:user:id');

        if (!$userId) {
            return redirect()->route('login')
                ->withErrors(['code' => 'Session expired. Please login again.']);
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login')
                ->withErrors(['code' => 'User not found. Please login again.']);
        }

        if ($user->two_factor_expires_at && $user->two_factor_expires_at->isPast()) {
            return back()->withErrors(['code' => 'The verification code has expired. Please request a new one.']);
        }

        if ($user->two_factor_code !== $request->code) {
            return back()->withErrors(['code' => 'The verification code is incorrect.']);
        }

        $user->resetTwoFactorCode();

        $request->session()->forget('2fa:user:id');

        Auth::login($user, $request->session()->get('2fa:remember', false));

        $request->session()->forget('2fa:remember');
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function resend(Request $request): RedirectResponse
    {
        $userId = $request->session()->get('2fa:user:id');

        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login');
        }

        $user->generateTwoFactorCode();

        Mail::to($user->email)->send(new TwoFactorCodeMail($user));

        return back()->with('status', 'A new verification code has been sent to your email.');
    }
}
