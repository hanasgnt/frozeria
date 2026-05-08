@extends('layouts.app')
@section('title', 'Detail Barang')

@section('content')
<div class="page-header">
    <div>
        <div style="font-size:13px; margin-bottom:6px;">
            <a href="{{ route('dashboard') }}" style="color:var(--cyan-dark); text-decoration:none;">‹ Kembali</a>
            &nbsp; <strong>Detail Barang</strong>
        </div>
        <div class="page-title">{{ $item->name }}</div>
        @if($item->category_id)
            <span class="badge" style="margin-top:4px;">{{ $item->category->name }}</span>
        @endif
    </div>
    <div style="display:flex; gap:8px;">
        <a href="{{ route('transaction.create', $item) }}" class="btn btn-primary">+ Input Stok</a>
        <a href="{{ route('transaction.history', $item) }}" class="btn btn-outline">📋 Riwayat</a>
        <a href="{{ route('item.edit', $item) }}" class="btn btn-secondary">Edit</a>
        <button class="btn btn-danger" onclick="openDeleteModal('{{ route('item.destroy', $item) }}', '{{ addslashes($item->name) }}')">Hapus</button>
    </div>
</div>

<div style="display:grid; grid-template-columns: 260px 1fr; gap:20px; align-items:start;">
    <!-- Foto -->
    <div class="card">
        <div class="card-body" style="text-align:center; padding:20px;">
            @if($item->photo)
                <img src="{{ asset('storage/'.$item->photo) }}" style="width:100%; max-height:220px; object-fit:cover; border-radius:8px;">
            @else
                <div style="width:100%; height:180px; background:var(--gray-100); border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:64px; color:var(--gray-300);">
                    🧊
                </div>
                <p style="font-size:12px; color:var(--gray-400); margin-top:10px;">Tidak ada foto</p>
            @endif
        </div>
    </div>

    <!-- Detail Fields -->
    <div class="card">
        <div class="card-header">Informasi Barang</div>
        <div class="card-body">
            <div class="detail-grid">
                <div class="detail-field">
                    <label>Jumlah Stok</label>
                    <div class="value
                        @if($item->stock == 0) stok-habis
                        @elseif($item->stock < 20) stok-menipis
                        @else stok-ok @endif
                    ">{{ $item->stock }} {{ $item->unit }}</div>
                </div>
                <div class="detail-field">
                    <label>Stok Minimum</label>
                    <div class="value">{{ $item->minimum_stock ?? '—' }} {{ $item->minimum_stock ? $item->unit : '' }}</div>
                </div>
                <div class="detail-field">
                    <label>Harga Jual</label>
                    <div class="value">{{ $item->selling_price ? 'Rp '.number_format($item->selling_price,0,',','.') : '—' }}</div>
                </div>
                <div class="detail-field">
                    <label>Harga Beli</label>
                    <div class="value">{{ $item->purchase_price ? 'Rp '.number_format($item->purchase_price,0,',','.') : '—' }}</div>
                </div>
                <div class="detail-field">
                    <label>Berat / Ukuran</label>
                    <div class="value">{{ $item->weight ? $item->weight . ' ' . $item->unit : '—' }}</div>
                </div>
                <div class="detail-field">
                    <label>Lokasi Simpan</label>
                    <div class="value">{{ $item->storage_location ?? '—' }}</div>
                </div>
                <div class="detail-field" style="grid-column:1/-1;">
                    <label>Deskripsi</label>
                    <div class="value" style="min-height:60px;">{{ $item->description ?? '—' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
