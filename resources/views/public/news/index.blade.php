@extends('layouts.app')

@section('title', 'Berita & Pengumuman Desa')

@section('content')
@php
    $newsItems = collect($news->items())->map(function ($item) {
        return [
            'id' => $item->id ?? null,
            'title' => $item->title ?? '',
            'slug' => $item->slug ?? '',
            'excerpt' => $item->excerpt ?? '',
            'category' => $item->category ?? 'Warta',
            'image_url' => $item->image_url ?? null,
            'published_at' => $item->published_at ? \Carbon\Carbon::parse($item->published_at)->isoFormat('D MMM Y') : null,
            'read_time' => $item->read_time ?? '2 menit membaca',
            'location' => $item->location ?? $item->dusun ?? 'Desa Ngadiluwih',
            'show_url' => !empty($item->slug) ? route('news.show', $item->slug) : '#',
        ];
    })->values()->all();

    $initialProps = [
        'routes' => [
            'home' => route('home'),
            'profile' => route('profile'),
            'newsIndex' => route('news.index'),
            'umkmIndex' => route('umkm.index'),
            'servicesGuides' => route('services.guides'),
            'servicesFeedback' => route('services.feedback'),
            'demographics' => route('demographics'),
            'login' => route('login'),
        ],
        'currentSearch' => $currentSearch ?? request('q', ''),
        'currentCategory' => $currentCategory ?? request('category', ''),
        'news' => $newsItems,
        'pagination' => [
            'currentPage' => $news->currentPage(),
            'lastPage' => $news->lastPage(),
            'total' => $news->total(),
            'perPage' => $news->perPage(),
            'hasMorePages' => $news->hasMorePages(),
            'nextPageUrl' => $news->nextPageUrl(),
            'prevPageUrl' => $news->previousPageUrl(),
        ],
        'csrfToken' => csrf_token(),
    ];
@endphp
<div id="berita-root" data-props='@json($initialProps)'>
    {{-- Fallback / Loading state --}}
    <div class="min-h-screen bg-[#BD6E37] flex items-center justify-center p-8">
        <div class="flex flex-col items-center gap-3 text-[#2B140B]">
            <div class="w-10 h-10 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
            <p class="font-serif italic text-lg font-bold text-white">Memuat Berita & Pengumuman Desa Ngadiluwih...</p>
        </div>
    </div>
</div>
@endsection
