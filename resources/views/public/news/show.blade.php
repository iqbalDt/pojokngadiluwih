@extends('layouts.app')

@section('title', $news->title)

@section('content')
@php
    $newsData = [
        'id' => $news->id ?? null,
        'title' => $news->title ?? '',
        'slug' => $news->slug ?? '',
        'category' => $news->category ?? 'Warta Desa',
        'published_at' => $news->published_at ? \Carbon\Carbon::parse($news->published_at)->translatedFormat('d F Y') : null,
        'author_name' => $news->author_name ?? 'Pemerintah Desa Ngadiluwih',
        'read_time' => $news->read_time ?? '2 menit membaca',
        'content' => $news->content ?? '',
        'image_url' => $news->image_url ?? null,
    ];

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
        'news' => $newsData,
    ];
@endphp

<div id="news-detail-root" data-props='@json($initialProps)'></div>
@endsection
