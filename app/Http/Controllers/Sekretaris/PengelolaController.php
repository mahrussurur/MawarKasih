<?php

namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PengelolaController extends Controller
{
    public function index(Request $request, string $roleFilter)
    {
        $this->ensureSupportedRole($roleFilter);

        $query = User::where('role', $roleFilter)->latest();

        if ($this->usesPengelolaProfile($roleFilter)) {
            $query->with('profilPengelola');
        } elseif ($this->usesDonaturProfile($roleFilter)) {
            $query->with('profilDonatur');
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->value();

            $query->where(function ($query) use ($search, $roleFilter) {
                $query->where('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");

                if ($this->usesPengelolaProfile($roleFilter)) {
                    $query->orWhereHas('profilPengelola', function ($profileQuery) use ($search) {
                        $profileQuery->where('nama', 'like', "%{$search}%")
                            ->orWhere('no_hp', 'like', "%{$search}%");
                    });
                } elseif ($this->usesDonaturProfile($roleFilter)) {
                    $query->orWhereHas('profilDonatur', function ($profileQuery) use ($search) {
                        $profileQuery->where('nama', 'like', "%{$search}%")
                            ->orWhere('no_hp', 'like', "%{$search}%");
                    });
                }
            });
        }

        $users = $query->paginate(10)->withQueryString();
        $roleLabel = $this->roleLabel($roleFilter);
        $usesPengelolaProfile = $this->usesPengelolaProfile($roleFilter);
        $usesDonaturProfile = $this->usesDonaturProfile($roleFilter);

        return view('sekretaris.pengelola.index', compact('users', 'roleFilter', 'roleLabel', 'usesPengelolaProfile', 'usesDonaturProfile'));
    }

    public function show(string $roleFilter, User $user)
    {
        $this->ensureSupportedRole($roleFilter);
        $this->ensureMatchingRole($roleFilter, $user);

        if ($this->usesPengelolaProfile($roleFilter)) {
            $user->load('profilPengelola');
        } elseif ($this->usesDonaturProfile($roleFilter)) {
            $user->load('profilDonatur');
        }

        $donasi = $roleFilter === 'donatur'
            ? $user->donasi()->latest()->take(10)->get()
            : null;

        return view('sekretaris.pengelola.show', [
            'user' => $user,
            'roleFilter' => $roleFilter,
            'roleLabel' => $this->roleLabel($roleFilter),
            'usesPengelolaProfile' => $this->usesPengelolaProfile($roleFilter),
            'usesDonaturProfile' => $this->usesDonaturProfile($roleFilter),
            'donasi' => $donasi,
        ]);
    }

    private function ensureSupportedRole(string $roleFilter): void
    {
        abort_unless(in_array($roleFilter, ['pengasuh', 'bendahara', 'sekretaris', 'donatur'], true), 404);
    }

    private function ensureMatchingRole(string $roleFilter, User $user): void
    {
        abort_unless($user->role === $roleFilter, 403);
    }

    private function usesPengelolaProfile(string $roleFilter): bool
    {
        return in_array($roleFilter, ['pengasuh', 'bendahara', 'sekretaris'], true);
    }

    private function usesDonaturProfile(string $roleFilter): bool
    {
        return $roleFilter === 'donatur';
    }

    private function roleLabel(string $roleFilter): string
    {
        return ucfirst($roleFilter);
    }
}
