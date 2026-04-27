<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnakAsuhController extends Controller
{
    public function index() {
        $anakAsuh = DB::table('anak_asuh')->get();
        return view('anak_asuh.index', compact('anakAsuh'));
    }

    public function create() {
        return view('anak_asuh.create');
    }

    public function store(Request $request) {
       $request->validate([
        'nama' => 'required',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required',
        'jenis_kelamin' => 'required',
    ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('anak_asuh', 'public');
        }

        \DB::table('anak_asuh')->insert([
        'nama' => $request->nama,
        'tempat_lahir' => $request->tempat_lahir,
        'tanggal_lahir' => $request->tanggal_lahir,
        'jenis_kelamin' => $request->jenis_kelamin,
        'nama_ayah' => $request->nama_ayah,
        'nama_ibu' => $request->nama_ibu,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

        return redirect()->route('anak-asuh.index')->with('success', 'Data berhasil disimpan!');
    }

    public function cetak() {
        $anakAsuh = DB::table('anak_asuh')->get();
        return view('anak_asuh.cetak', compact('anakAsuh'));
    }
}