<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordController extends Controller
{
    /**
     * Maximum number of failed current-password attempts before throttling.
     */
    protected const MAX_ATTEMPTS = 5;

    public function edit(): Response
    {
        return Inertia::render('admin/Password');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'max:255', 'confirmed', 'different:current_password', Password::default()],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.max' => 'Password maksimal 255 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.different' => 'Password baru harus berbeda dari password saat ini.',
        ]);

        $this->ensureIsNotRateLimited($request);

        /** @var User $user */
        $user = $request->user();

        if (! Hash::check($validated['current_password'], $user->password)) {
            RateLimiter::hit($this->throttleKey($request));

            throw ValidationException::withMessages([
                'current_password' => 'Password saat ini salah.',
            ]);
        }

        RateLimiter::clear($this->throttleKey($request));

        $user->update(['password' => $validated['password']]);

        // Sesi di perangkat lain memegang hash password lama, sehingga middleware
        // `auth.session` akan mengeluarkan mereka pada request berikutnya. Panggilan
        // ini menyegarkan cookie "ingat saya" milik perangkat yang sedang dipakai.
        Auth::logoutOtherDevices($validated['password']);

        $request->session()->regenerate();

        return redirect()->route('admin.password.edit')
            ->with('message', 'Password berhasil diperbarui.');
    }

    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), self::MAX_ATTEMPTS)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'current_password' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
        ]);
    }

    protected function throttleKey(Request $request): string
    {
        /** @var User $user */
        $user = $request->user();

        return 'password-update|'.$user->id.'|'.$request->ip();
    }
}
