<?php

use App\Http\Middleware\RoleMiddleware;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

test('guest user is redirected to login by role middleware', function () {
    $middleware = new RoleMiddleware();
    $request = Request::create('/test-role', 'GET');

    $response = $middleware->handle($request, fn () => new Response('OK'), 'admin');

    expect($response)->toBeInstanceOf(RedirectResponse::class);
    expect($response->getTargetUrl())->toContain('login');
});

test('user with exact matching role is allowed by role middleware', function () {
    $user = User::factory()->create(['role' => 'donatur', 'status' => 'aktif']);
    $middleware = new RoleMiddleware();
    $request = Request::create('/donatur/test', 'GET');
    $request->setUserResolver(fn () => $user);

    $this->actingAs($user);

    $response = $middleware->handle($request, fn () => new Response('SUCCESS'), 'donatur');

    expect($response->getContent())->toBe('SUCCESS');
});

test('admin can access non-ketua role restricted route', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
    $middleware = new RoleMiddleware();
    $request = Request::create('/bendahara/test', 'GET');
    $request->setUserResolver(fn () => $admin);

    $this->actingAs($admin);

    $response = $middleware->handle($request, fn () => new Response('SUCCESS_ADMIN'), 'bendahara');

    expect($response->getContent())->toBe('SUCCESS_ADMIN');
});

test('admin is forbidden from accessing ketua-only route', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
    $middleware = new RoleMiddleware();
    $request = Request::create('/ketua/test', 'GET');
    $request->setUserResolver(fn () => $admin);

    $this->actingAs($admin);

    $middleware->handle($request, fn () => new Response('FAIL'), 'ketua');
})->throws(HttpException::class);

test('user with mismatched role is forbidden by role middleware', function () {
    $donatur = User::factory()->create(['role' => 'donatur', 'status' => 'aktif']);
    $middleware = new RoleMiddleware();
    $request = Request::create('/admin/test', 'GET');
    $request->setUserResolver(fn () => $donatur);

    $this->actingAs($donatur);

    $middleware->handle($request, fn () => new Response('FAIL'), 'admin');
})->throws(HttpException::class);

