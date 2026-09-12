@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div>
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-gray-900">Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p class="mt-1 text-sm font-medium text-gray-500">Ini adalah dashboard utama untuk Sekretaris.</p>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 text-center">
        <p class="text-gray-500">Konten dashboard akan ditambahkan di sini nanti.</p>
    </div>
</div>
@endsection
