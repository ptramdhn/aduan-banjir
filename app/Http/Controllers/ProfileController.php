<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        // 1. Validasi Input (Nama & No HP)
        // Kita tidak memvalidasi email karena email tidak boleh diubah
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:15'],
        ]);

        // 2. Update User
        $user = $request->user();

        // Kita update manual field-nya agar Email tidak ikut berubah
        $user->forceFill([
            'name' => $request->name,
            'no_hp' => $request->no_hp,
        ])->save();

        return Redirect::route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete the user's account. (Biarkan bawaan Breeze)
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
