@extends('layouts.app')

@section('title', $umkm->name)

@section('content')
@php
    $umkmData = [
        'id' => $umkm->id ?? null,
        'name' => $umkm->name ?? '',
        'slug' => $umkm->slug ?? '',
        'category' => $umkm->category ?? 'Kuliner & Camilan',
        'dusun' => !empty($umkm->dusun) ? (str_starts_with($umkm->dusun, 'Dusun ') ? str_replace('Dusun ', '', $umkm->dusun) : $umkm->dusun) : 'Ngadiluwih',
        'owner_name' => $umkm->owner_name ?? '',
        'address' => $umkm->address ?? '',
        'description' => $umkm->description ?? '',
        'price' => !empty($umkm->price) ? (is_numeric($umkm->price) ? 'Rp. ' . number_format((float)$umkm->price, 0, ',', '.') : $umkm->price) : null,
        'products_list' => $umkm->products_list ?? [],
        'whatsapp' => $umkm->whatsapp ?? '',
        'whatsapp_order_url' => $umkm->whatsapp_order_url ?? '',
        'image_url' => $umkm->image_url ?? null,
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
        'umkm' => $umkmData,
    ];
@endphp

<div id="umkm-detail-root" data-props='@json($initialProps)'></div>
@endsection
