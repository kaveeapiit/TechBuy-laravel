<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function profile(): View
    {
        /** @var User $user */
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit(): View
    {
        /** @var User $user */
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // 2MB max
        ]);

        try {
            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                // Delete old profile photo if exists
                if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }

                $photoPath = $request->file('profile_photo')->store('profile-photos', 'public');
                $validated['profile_photo_path'] = $photoPath;
            }

            $user->fill($validated);
            $user->save();

            return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update profile. Please try again.');
        }
    }

    /**
     * Show the form for changing password.
     */
    public function changePasswordForm(): View
    {
        return view('user.change-password');
    }

    /**
     * Update the user's password.
     */
    public function changePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        try {
            $user->password = Hash::make($validated['password']);
            $user->save();

            return redirect()->route('user.profile')->with('success', 'Password changed successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to change password. Please try again.');
        }
    }

    /**
     * Show the form for confirming account deletion.
     */
    public function deleteAccountForm(): View
    {
        return view('user.delete-account');
    }

    /**
     * Delete the user's account.
     */
    public function deleteAccount(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required'],
            'confirmation' => ['required', 'in:DELETE'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The password is incorrect.']);
        }

        try {
            // Delete profile photo if exists
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Delete related data (cart will be handled by database cascade)
            if ($user->cart) {
                $user->cart->delete();
            }

            // Log out the user
            Auth::logout();

            // Delete the user account
            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('success', 'Your account has been deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete account. Please contact support.');
        }
    }

    /**
     * Display user's order history.
     */
    public function orders(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $orders = $user->orders()->with('items')->orderBy('created_at', 'desc')->paginate(10);

        return view('user.orders', compact('orders'));
    }

    /**
     * Display specific order details.
     */
    public function orderDetails($orderNumber): View
    {
        /** @var User $user */
        $user = Auth::user();
        $order = $user->orders()
            ->where('order_number', $orderNumber)
            ->with('items')
            ->firstOrFail();

        return view('user.order-details', compact('order'));
    }
}
