<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class AdminAuthController extends Controller
{
    /**
     * Show the admin registration form.
     */
    public function showRegisterForm()
    {
        return view('admin.auth.register');
    }

    /**
     * Handle admin registration.
     */
    public function register(Request $request)
    {
        // Add detailed logging for debugging
        Log::info('Admin registration attempt', [
            'request_data' => $request->except('password', 'password_confirmation'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:super_admin,admin,moderator'],
        ]);

        try {
            Log::info('Creating admin with validated data', ['email' => $validated['email']]);

            $admin = Admin::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'is_active' => true,
            ]);

            Log::info('Admin created successfully', ['admin_id' => $admin->id]);

            Auth::guard('admin')->login($admin);

            Log::info('Admin logged in successfully');

            return redirect()->route('admin.dashboard')->with('success', 'Admin account created successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to create admin account', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'validated_data' => $validated
            ]);

            return back()->withErrors(['registration' => 'Failed to create admin account: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle admin login.
     */
    public function login(Request $request)
    {
        Log::info('Admin login attempt', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();

                $admin = Auth::guard('admin')->user();
                Log::info('Admin login successful', ['admin_id' => $admin->id, 'email' => $admin->email]);

                return redirect()->intended(route('admin.dashboard'));
            }

            Log::warning('Admin login failed - invalid credentials', ['email' => $request->email]);

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        } catch (\Exception $e) {
            Log::error('Admin login error', [
                'error' => $e->getMessage(),
                'email' => $request->email
            ]);

            return back()->withErrors([
                'email' => 'Login failed due to a system error. Please try again.',
            ])->onlyInput('email');
        }
    }

    /**
     * Handle admin logout.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
