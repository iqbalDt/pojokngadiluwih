@extends('layouts.admin')

@section('title', 'Manajemen & Kurasi Katalog UMKM')

@section('custom_header_title')
<div>
    <h1 class="font-serif-title text-xl sm:text-2xl lg:text-[26px] font-bold text-[#38190C] tracking-tight">
        Manajemen & Kurasi Katalog <span class="italic font-normal">UMKM</span>
    </h1>
    <p class="text-xs text-stone-500 mt-1 font-normal">
        Kelola data toko UMKM desa, verifikasi pengajuan warga, perbarui harga dan unggah foto produk
    </p>
</div>
@endsection

@section('content')
@php
    $umkmData = $umkms->map(function ($item) {
        return [
            'id' => (string) $item->id,
            'name' => $item->name,
            'owner_name' => $item->owner_name,
            'nik' => $item->nik ?? null,
            'category' => $item->category,
            'dusun' => $item->dusun ?? null,
            'products' => $item->products ?? (!empty($item->products_list) ? implode(', ', $item->products_list) : null),
            'whatsapp' => $item->whatsapp,
            'status' => $item->status ?? 'pending',
            'created_at' => $item->created_at ? $item->created_at->toIso8601String() : null,
            'image_url' => $item->image_url ?? null,
        ];
    })->values()->toArray();

    $props = [
        'umkms' => $umkmData,
        'pendingCount' => $pendingCount ?? 0,
        'approvedCount' => $approvedCount ?? 0,
        'currentStatus' => $currentStatus ?? 'pending',
        'csrfToken' => csrf_token(),
        'routes' => [
            'approve' => route('admin.umkm.approve', ':id'),
            'reject' => route('admin.umkm.reject', ':id'),
            'edit' => route('admin.umkm.edit', ':id'),
            'destroy' => route('admin.umkm.destroy', ':id'),
            'index' => route('admin.umkm.index'),
        ],
    ];
@endphp

<!-- Container Mount React.js untuk Halaman Katalog UMKM Admin -->
<div id="admin-umkm-root" data-props="{{ json_encode($props) }}">
    <div class="p-8 text-center text-xs text-stone-400">
        Memuat antarmuka React Katalog UMKM...
    </div>
</div>

@if(method_exists($umkms, 'hasPages') && $umkms->hasPages())
<div class="mt-4 pt-4 border-t border-[#EADBCC]">
    {{ $umkms->appends(['status' => $currentStatus])->links() }}
</div>
@endif

@endsection
