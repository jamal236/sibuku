@extends('layouts.app')

@section('content')
<div class="space-y-6">
    {{-- Header Halaman --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="font-display text-2xl font-bold text-forest-900">
                @yield('page-header')
            </h2>
            <p class="text-sm text-forest-500 mt-1">
                @yield('page-description')
            </p>
        </div>
        @yield('header-actions')
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="card bg-emerald-50/80 border-l-4 border-l-emerald-400 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check text-emerald-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-emerald-900">Berhasil!</p>
                    <p class="text-sm text-emerald-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="card bg-red-50/80 border-l-4 border-l-red-400 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation text-red-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-red-900">Gagal!</p>
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="card bg-red-50/80 border-l-4 border-l-red-400 p-4">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-red-900 mb-1">Terdapat {{ $errors->count() }} error:</p>
                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <div class="card">
        @yield('crud-content')
    </div>
</div>
@endsection