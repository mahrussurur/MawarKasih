<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonaturController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where('role', 'donatur')->with('profilDonatur')->latest();

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->value();

            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhereHas('profilDonatur', function ($profileQuery) use ($search) {
                        $profileQuery->where('nama', 'like', "%{$search}%")
                            ->orWhere('no_hp', 'like', "%{$search}%");
                    });
            });
        }

        $donaturs = $query->paginate(10)->withQueryString();

        return view('ketua.donatur.index', compact('donaturs'));
    }

    public function show(User $user): View
    {
        abort_unless($user->role === 'donatur', 404);

        $user->load('profilDonatur');
        $donasi = $user->donasi()->latest()->take(10)->get();

        return view('ketua.donatur.show', compact('user', 'donasi'));
    }
}
