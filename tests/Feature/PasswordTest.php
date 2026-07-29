<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

beforeEach(function () {
    $this->user = User::factory()->create();
    RateLimiter::clear('password-update|'.$this->user->id.'|127.0.0.1');
});

it('redirects guests away from the password page', function () {
    $this->get(route('admin.password.edit'))->assertRedirect(route('login'));
    $this->put(route('admin.password.update'))->assertRedirect(route('login'));
});

it('renders the password page', function () {
    $this->actingAs($this->user)
        ->get(route('admin.password.edit'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('admin/Password'));
});

it('updates the password with valid input', function () {
    $this->actingAs($this->user)
        ->from(route('admin.password.edit'))
        ->put(route('admin.password.update'), [
            'current_password' => 'password',
            'password' => 'RahasiaBaru123',
            'password_confirmation' => 'RahasiaBaru123',
        ])
        ->assertRedirect(route('admin.password.edit'))
        ->assertSessionHas('message', 'Password berhasil diperbarui.');

    expect(Hash::check('RahasiaBaru123', $this->user->fresh()->password))->toBeTrue();
});

it('rejects an incorrect current password', function () {
    $original = $this->user->password;

    $this->actingAs($this->user)
        ->from(route('admin.password.edit'))
        ->put(route('admin.password.update'), [
            'current_password' => 'password-salah',
            'password' => 'RahasiaBaru123',
            'password_confirmation' => 'RahasiaBaru123',
        ])
        ->assertSessionHasErrors(['current_password' => 'Password saat ini salah.']);

    expect($this->user->fresh()->password)->toBe($original);
});

it('rejects a mismatched confirmation', function () {
    $this->actingAs($this->user)
        ->from(route('admin.password.edit'))
        ->put(route('admin.password.update'), [
            'current_password' => 'password',
            'password' => 'RahasiaBaru123',
            'password_confirmation' => 'RahasiaLain123',
        ])
        ->assertSessionHasErrors(['password' => 'Konfirmasi password tidak cocok.']);

    expect(Hash::check('password', $this->user->fresh()->password))->toBeTrue();
});

it('rejects a new password identical to the current one', function () {
    $this->actingAs($this->user)
        ->from(route('admin.password.edit'))
        ->put(route('admin.password.update'), [
            'current_password' => 'password',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertSessionHasErrors([
            'password' => 'Password baru harus berbeda dari password saat ini.',
        ]);
});

it('rejects a password shorter than eight characters', function () {
    $this->actingAs($this->user)
        ->from(route('admin.password.edit'))
        ->put(route('admin.password.update'), [
            'current_password' => 'password',
            'password' => 'pendek',
            'password_confirmation' => 'pendek',
        ])
        ->assertSessionHasErrors('password');

    expect(Hash::check('password', $this->user->fresh()->password))->toBeTrue();
});

it('throttles repeated wrong current password attempts', function () {
    $payload = [
        'current_password' => 'password-salah',
        'password' => 'RahasiaBaru123',
        'password_confirmation' => 'RahasiaBaru123',
    ];

    foreach (range(1, 5) as $ignored) {
        $this->actingAs($this->user)
            ->from(route('admin.password.edit'))
            ->put(route('admin.password.update'), $payload)
            ->assertSessionHasErrors(['current_password' => 'Password saat ini salah.']);
    }

    $response = $this->actingAs($this->user)
        ->from(route('admin.password.edit'))
        ->put(route('admin.password.update'), $payload);

    $response->assertSessionHasErrors('current_password');

    expect(session('errors')->first('current_password'))
        ->toStartWith('Terlalu banyak percobaan.');
});

it('keeps the current session signed in after the password changes', function () {
    $this->actingAs($this->user)
        ->put(route('admin.password.update'), [
            'current_password' => 'password',
            'password' => 'RahasiaBaru123',
            'password_confirmation' => 'RahasiaBaru123',
        ])
        ->assertRedirect(route('admin.password.edit'));

    $this->get(route('admin.dashboard'))->assertOk();
    $this->assertAuthenticatedAs($this->user->fresh());
});

it('signs out sessions that hold an outdated password hash', function () {
    $this->actingAs($this->user)->get(route('admin.dashboard'))->assertOk();

    // Simulasi password diganti dari sesi lain.
    $this->user->forceFill(['password' => Hash::make('RahasiaBaru123')])->save();

    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    $this->assertGuest();
});
