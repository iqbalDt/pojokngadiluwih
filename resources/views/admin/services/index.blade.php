@extends('layouts.admin')

@section('title', 'Pengelolaan Layanan Publik & Aspirasi')

@section('custom_header_title')
<div>
    <h1 class="font-serif-title text-xl sm:text-2xl lg:text-[26px] font-bold text-[#38190C] tracking-tight">
        Pengelolaan Layanan Publik & Aspirasi
    </h1>
    <p class="text-xs text-stone-500 mt-1 font-normal">
        Daftar aspirasi, pengajuan, dan laporan dari masyarakat
    </p>
</div>
@endsection

@section('content')
@php
    $aspirationsData = collect($aspirations->items())->map(function ($item) {
        return [
            'id' => (string) $item->id,
            'name' => $item->public_display_name ?? $item->name,
            'phone' => $item->is_anonymous ? 'Dirahasiakan' : ($item->phone ?? '-'),
            'dusun' => $item->dusun ?? null,
            'category' => $item->category ?? 'Pelayanan Administrasi',
            'title' => $item->title ?? '',
            'message' => $item->message ?? '',
            'status' => $item->status ?? 'pending',
            'created_at' => $item->created_at ? $item->created_at->toIso8601String() : null,
        ];
    })->values()->toArray();

    $props = [
        'aspirations' => $aspirationsData,
        'totalCount' => $totalCount ?? count($aspirationsData),
        'currentSearch' => $currentSearch ?? '',
        'currentStatus' => $currentStatus ?? '',
        'csrfToken' => csrf_token(),
        'routes' => [
            'status' => route('admin.services.status', ':id'),
            'index' => route('admin.services.index'),
        ],
    ];
@endphp

<!-- Container Mount React.js untuk Halaman Layanan & Aspirasi Admin -->
<div id="admin-services-root" data-props="{{ json_encode($props) }}">
    <div class="p-8 text-center text-xs text-stone-400">
        Memuat antarmuka React Layanan & Aspirasi...
    </div>
</div>

@if(method_exists($aspirations, 'hasPages') && $aspirations->hasPages())
<div class="mt-4 pt-4 border-t border-[#EADBCC]">
    {{ $aspirations->appends(['q' => $currentSearch, 'status' => $currentStatus])->links() }}
</div>
@endif

@endsection
