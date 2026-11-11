<?php

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

test('login request authorize returns true', function () {
    $request = new LoginRequest();
    expect($request->authorize())->toBeTrue();
});

test('login request rules contain email and password validations', function () {
    $request = new LoginRequest();
    $rules = $request->rules();

    expect($rules)->toHaveKeys(['email', 'password']);
    expect($rules['email'])->toContain('required', 'string', 'email');
    expect($rules['password'])->toContain('required', 'string');
});

test('login request throttleKey generates lowercased email and ip key', function () {
    $request = LoginRequest::create('/login', 'POST', [
        'email' => 'User.Test@Example.COM',
    ], [], [], ['REMOTE_ADDR' => '127.0.0.1']);

    expect($request->throttleKey())->toBe('user.test@example.com|127.0.0.1');
});

test('login request authenticate logs in user with valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
        'status' => 'aktif',
    ]);

    $request = LoginRequest::create('/login', 'POST', [
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);

    $request->authenticate();

    $this->assertAuthenticatedAs($user);
});

test('login request authenticate throws validation exception with invalid credentials', function () {
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
    ]);

    $request = LoginRequest::create('/login', 'POST', [
        'email' => 'test@example.com',
        'password' => 'wrong-pass',
    ]);

    $request->authenticate();
})->throws(ValidationException::class);

test('login request ensureIsNotRateLimited dispatches lockout event when locked', function () {
    Event::fake([Lockout::class]);

    $request = LoginRequest::create('/login', 'POST', [
        'email' => 'spammer@example.com',
    ], [], [], ['REMOTE_ADDR' => '127.0.0.1']);

    $key = $request->throttleKey();

    for ($i = 0; $i < 5; $i++) {
        RateLimiter::hit($key);
    }

    try {
        $request->ensureIsNotRateLimited();
        $this->fail('Expected ValidationException was not thrown.');
    } catch (ValidationException $e) {
        Event::assertDispatched(Lockout::class);
        expect($e->errors())->toHaveKey('email');
    } finally {
        RateLimiter::clear($key);
    }
});

