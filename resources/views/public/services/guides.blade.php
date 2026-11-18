@extends('layouts.app')

@section('title', 'Panduan Pengurusan Surat Desa')

@section('content')
@php
    $initialProps = [
        'routes' => [
            'home' => route('home'),
            'profile' => route('profile'),
            'newsIndex' => route('news.index'),
            'umkmIndex' => route('umkm.index'),
            'servicesGuides' => route('services.guides'),
            'servicesStoreRegister' => route('services.store-register'),
            'servicesFeedback' => route('services.feedback'),
            'demographics' => route('demographics'),
            'login' => route('login'),
        ],
        'csrfToken' => csrf_token(),
    ];
@endphp
<div id="guides-root" data-props='@json($initialProps)'>
    {{-- Fallback / Loading state --}}
    <div class="min-h-screen bg-[#BD6E37] flex items-center justify-center p-8">
        <div class="flex flex-col items-center gap-3 text-[#2B140B]">
            <div class="w-10 h-10 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
            <p class="font-serif italic text-lg font-bold text-white">Memuat Panduan Persyaratan Surat Desa...</p>
        </div>
    </div>
</div>
@endsection
