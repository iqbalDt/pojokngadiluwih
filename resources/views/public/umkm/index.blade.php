@extends('layouts.app')

@section('title', 'Katalog UMKM Desa Ngadiluwih')

@section('content')
@php
    $umkmItems = collect($umkms->items())->map(function ($item) {
        return [
            'id' => $item->id ?? null,
            'name' => $item->name ?? '',
            'slug' => $item->slug ?? '',
            'category' => $item->category ?? 'Kuliner',
            'dusun' => !empty($item->dusun) ? (str_starts_with($item->dusun, 'Dusun ') ? $item->dusun : 'Dusun ' . $item->dusun) : 'Dusun Sukorejo',
            'description' => $item->description ?? '',
            'price' => !empty($item->price) ? (is_numeric($item->price) ? 'Rp. ' . number_format((float)$item->price, 0, ',', '.') : $item->price) : 'Rp. 25.000 / 500gr',
            'image_url' => $item->image_url ?? null,
            'phone' => $item->phone ?? $item->whatsapp ?? null,
            'show_url' => !empty($item->slug) ? route('umkm.show', $item->slug) : '#',
        ];
    })->values()->all();

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
        'currentSearch' => $currentSearch ?? request('q', ''),
        'currentCategory' => $currentCategory ?? request('category', ''),
        'umkms' => $umkmItems,
        'pagination' => [
            'currentPage' => $umkms->currentPage(),
            'lastPage' => $umkms->lastPage(),
            'total' => $umkms->total(),
            'perPage' => $umkms->perPage(),
            'hasMorePages' => $umkms->hasMorePages(),
            'nextPageUrl' => $umkms->nextPageUrl(),
            'prevPageUrl' => $umkms->previousPageUrl(),
        ],
        'csrfToken' => csrf_token(),
    ];
@endphp
<div id="umkm-root" data-props='@json($initialProps)'>
    {{-- Fallback / Loading state --}}
    <div class="min-h-screen bg-[#BD6E37] flex items-center justify-center p-8">
        <div class="flex flex-col items-center gap-3 text-[#2B140B]">
            <div class="w-10 h-10 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
            <p class="font-serif italic text-lg font-bold text-white">Memuat Katalog UMKM Desa Ngadiluwih...</p>
        </div>
    </div>
</div>
@endsection
