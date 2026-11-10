@extends('layouts.app')

@section('title', 'Akses Ditolak')
@section('page-title', '403 - Akses Ditolak')
@section('page-subtitle', 'Anda tidak memiliki izin untuk mengakses halaman ini')

@section('content')
<div class="flex flex-col items-center justify-center py-20">
    <div class="w-32 h-32 rounded-full bg-red-100 flex items-center justify-center mb-6">
        <i class="fas fa-lock text-6xl text-red-500"></i>
    </div>
    <h2 class="font-display text-3xl font-bold text-brand-darkest mb-2">Akses Ditolak</h2>
    <p class="text-gray-500 text-center max-w-md mb-8">
        Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. 
        Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
    </p>
    <div class="flex gap-3">
        <a href="{{ route('dashboard') }}" class="btn-primary inline-flex items-center gap-2">
            <i class="fas fa-home"></i>
            <span>Kembali ke Dashboard</span>
        </a>
        <button onclick="history.back()" class="btn-secondary inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </button>
    </div>
</div>
@endsection