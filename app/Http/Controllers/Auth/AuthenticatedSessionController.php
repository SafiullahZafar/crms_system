<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $superAdminEmail = (string) config('demo.super_admin_email');
        $superAdminPassword = (string) config('demo.super_admin_password');
        $isSuperAdminLogin = $superAdminEmail !== ''
            && $superAdminPassword !== ''
            && strcasecmp($credentials['email'], $superAdminEmail) === 0;

        if ($isSuperAdminLogin && hash_equals($superAdminPassword, $credentials['password'])) {
            $user = User::firstOrNew(['email' => $superAdminEmail]);

            if (! $user->exists) {
                $user->name = (string) config('demo.super_admin_name', 'Super Admin');
                $user->password = $superAdminPassword;
                $user->role = 'admin';
                $user->email_verified_at = now();
                $user->save();
            }

            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages(['email' => 'The provided credentials do not match our records.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
