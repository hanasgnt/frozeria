@extends('layouts.app')
@section('title', 'Detail Barang')

@section('content')

<!-- PAGE HEADER -->
<div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">

    <div>

        <div class="small mb-2">
            <a href="{{ route('dashboard') }}"
               class="text-decoration-none"
               style="color:var(--cyan-dark);">

                ‹ Kembali
            </a>

            <span class="mx-1 text-muted">/</span>

            <strong>Detail Barang</strong>
        </div>

        <h3 class="fw-bold mb-1" style="color:var(--navy);">
            {{ $item->name }}
        </h3>

        @if($item->category_id)
            <span class="badge-kategori">
                {{ $item->category->name }}
            </span>
        @endif

    </div>

    <!-- ACTION BUTTON -->
    <div class="d-flex flex-wrap gap-2">

        <a href="{{ route('transaction.create', $item) }}"
           class="btn btn-primary">

            <i class="bi bi-plus-lg me-1"></i>
            Input Stok
        </a>

        <a href="{{ route('transaction.history', $item) }}"
           class="btn btn-outline-secondary">

            <i class="bi bi-clock-history me-1"></i>
            Riwayat
        </a>

        <a href="{{ route('item.edit', $item) }}"
           class="btn btn-secondary">

            <i class="bi bi-pencil-square me-1"></i>
            Edit
        </a>

        <button class="btn btn-danger"
                onclick="openDeleteModal(
                    '{{ route('item.destroy', $item) }}',
                    '{{ addslashes($item->name) }}'
                )">

            <i class="bi bi-trash me-1"></i>
            Hapus
        </button>

    </div>

</div>

<!-- CONTENT -->
<div class="row g-4 align-items-start">

    <!-- FOTO -->
    <div class="col-lg-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body text-center p-3">

                @if($item->photo)

                    <img src="{{ asset('storage/'.$item->photo) }}"
                         class="img-fluid rounded-3"
                         style="width:100%; max-height:240px; object-fit:cover;">

                @else

                    <div class="d-flex align-items-center justify-content-center rounded-3"
                         style="
                            height:220px;
                            background:#f1f5f9;
                            color:#94a3b8;
                            font-size:64px;
                         ">

                        🧊

                    </div>

                    <p class="small text-muted mt-3 mb-0">
                        Tidak ada foto
                    </p>

                @endif

            </div>

        </div>

    </div>

    <!-- INFORMASI -->
    <div class="col-lg-9">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white border-bottom fw-semibold py-3">
                Informasi Barang
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <!-- STOK -->
                    <div class="col-md-6">

                        <label class="small text-muted mb-1 d-block">
                            Jumlah Stok
                        </label>

                        <div class="detail-value
                            @if($item->stock == 0)
                                stok-habis
                            @elseif($item->stock < 20)
                                stok-menipis
                            @else
                                stok-ok
                            @endif
                        ">
                            {{ $item->stock }} {{ $item->unit }}
                        </div>

                    </div>

                    <!-- STOK MIN -->
                    <div class="col-md-6">

                        <label class="small text-muted mb-1 d-block">
                            Stok Minimum
                        </label>

                        <div class="detail-value">
                            {{ $item->minimum_stock ?? '—' }}
                            {{ $item->minimum_stock ? $item->unit : '' }}
                        </div>

                    </div>

                    <!-- HARGA JUAL -->
                    <div class="col-md-6">

                        <label class="small text-muted mb-1 d-block">
                            Harga Jual
                        </label>

                        <div class="detail-value">

                            {{ $item->selling_price
                                ? 'Rp '.number_format($item->selling_price,0,',','.')
                                : '—'
                            }}

                        </div>

                    </div>

                    <!-- HARGA BELI -->
                    <div class="col-md-6">

                        <label class="small text-muted mb-1 d-block">
                            Harga Beli
                        </label>

                        <div class="detail-value">

                            {{ $item->purchase_price
                                ? 'Rp '.number_format($item->purchase_price,0,',','.')
                                : '—'
                            }}

                        </div>

                    </div>

                    <!-- BERAT -->
                    <div class="col-md-6">

                        <label class="small text-muted mb-1 d-block">
                            Berat / Ukuran
                        </label>

                        <div class="detail-value">

                            {{ $item->weight
                                ? $item->weight . ' ' . $item->unit
                                : '—'
                            }}

                        </div>

                    </div>

                    <!-- LOKASI -->
                    <div class="col-md-6">

                        <label class="small text-muted mb-1 d-block">
                            Lokasi Simpan
                        </label>

                        <div class="detail-value">
                            {{ $item->storage_location ?? '—' }}
                        </div>

                    </div>

                    <!-- DESKRIPSI -->
                    <div class="col-12">

                        <label class="small text-muted mb-1 d-block">
                            Deskripsi
                        </label>

                        <div class="detail-value" style="min-height:80px;">

                            {{ $item->description ?? '—' }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection