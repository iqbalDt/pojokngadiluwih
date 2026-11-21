@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
@php
    $initialProps = [
        'latestNews' => $latestNews ?? [],
        'featuredUmkm' => $featuredUmkm ?? [],
        'routes' => [
            'home' => route('home'),
            'profile' => route('profile'),
            'newsIndex' => route('news.index'),
            'umkmIndex' => route('umkm.index'),
            'servicesGuides' => route('services.guides'),
            'servicesStoreRegister' => route('services.store-register'),
            'servicesFeedback' => route('services.feedback'),
            'demographics' => route('demographics'),
            'privacy' => route('privacy'),
            'login' => route('login'),
        ],
        'csrfToken' => csrf_token(),
    ];
@endphp
<div id="beranda-root" data-props='@json($initialProps)'>
    {{-- Fallback / Loading state --}}
    <div class="min-h-screen bg-[#F5EFE6] flex items-center justify-center p-8">
        <div class="flex flex-col items-center gap-3 text-[#3D1E0F]">
            <div class="w-10 h-10 border-4 border-[#BD6E37] border-t-transparent rounded-full animate-spin"></div>
            <p class="font-serif italic text-lg font-bold">Memuat PojokNgadiluwih...</p>
        </div>
    </div>
</div>
@endsection
