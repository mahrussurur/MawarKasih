<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * List account credentials and account status only. Profile information is
     * intentionally managed through the role-specific profile screens.
     */
    public function index(Request $request): View
    {
        $query = User::query()->latest();

        if ($request->filled('role')) {
            $query->where('role', $request->string('role')->value());
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->value();
            $query->where(function ($query) use ($search): void {
                $query->where('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        return view('admin.users.index', [
            'users' => $query->paginate(10)->withQueryString(),
            'activeRole' => $request->input('role'),
        ]);
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update credentials and account status without permitting role changes.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$user->id],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', 'min:8'],
            'status' => ['required', 'in:aktif,tidak_aktif'],
        ]);

        $accountData = [
            'username' => $validated['username'],
            'email' => $validated['email'],
            'status' => $validated['status'],
        ];

        if (filled($validated['password'] ?? null)) {
            $accountData['password'] = Hash::make($validated['password']);
        }

        $user->update($accountData);

        return redirect()->route('users.index')->with('success', 'Akun berhasil diperbarui.');
    }
}
