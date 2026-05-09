@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Dashboard</div>
        <div class="breadcrumb">Sistem Stok Opname — Frozeria</div>
    </div>
    <a href="{{ route('item.create') }}" class="btn btn-primary">+ Tambah Barang</a>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Barang</div>
        <div class="stat-value">{{ $totalItems }}</div>
    </div>
    <div class="stat-card success">
        <div class="stat-label">Total Kategori</div>
        <div class="stat-value">{{ $totalCategories }}</div>
    </div>
    <div class="stat-card warning">
        <div class="stat-label">Stok Menipis</div>
        <div class="stat-value">{{ $stokMenipis }}</div>
    </div>
    <div class="stat-card danger">
        <div class="stat-label">Stok Habis</div>
        <div class="stat-value">{{ $stokHabis }}</div>
    </div>
</div>

<!-- Table Card -->
<div class="card">
    <div class="card-body" style="padding-bottom:0">
        <!-- Toolbar -->
        <form method="GET" action="{{ route('dashboard') }}">
            <div class="toolbar">
                <div class="search-wrap">
                    <span class="icon-search">🔍</span>
                    <input type="text" name="search" placeholder="Cari nama barang..." value="{{ request('search') }}">
                </div>
                <select name="cid" style="width:180px" onchange="this.form.submit()">
                    <option value="">Semua kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('cid') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-secondary btn-sm">Cari</button>
                @if(request('search') || request('cid'))
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">Reset</a>
                @endif
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                    <th>Harga Jual</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i => $item)
                <tr>
                    <td style="color:var(--gray-400); font-size:12px;">{{ $items->firstItem() + $i }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            @if($item->photo)
                                <img src="{{ asset('storage/'.$item->photo) }}" class="photo-thumb">
                            @else
                                <div class="no-photo">🧊</div>
                            @endif
                            <span style="font-weight:500;">{{ $item->name }}</span>
                        </div>
                    </td>
                    <td>
                        @if($item->category)
                            <span class="badge">{{ $item->category->name }}</span>
                        @else
                            <span style="color:var(--gray-400); font-size:12px;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($item->stock == 0)
                            <span class="stok-habis">{{ $item->stock }}</span>
                        @elseif($item->stock < 20)
                            <span class="stok-menipis">{{ $item->stock }}</span>
                        @else
                            <span class="stok-ok">{{ $item->stock }}</span>
                        @endif
                    </td>
                    <td style="color:var(--gray-600);">{{ $item->unit }}</td>
                    <td style="font-family:'Space Mono',monospace; font-size:13px;">
                        @if($item->selling_price)
                            Rp {{ number_format($item->selling_price, 0, ',', '.') }}
                        @else —
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('transaction.create', $item) }}" class="btn btn-primary btn-sm">+ Stok</a>
                            <a href="{{ route('item.show', $item) }}" class="btn btn-outline btn-sm">Detail</a>
                            <a href="{{ route('item.edit', $item) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm" onclick="openDeleteModal('{{ route('item.destroy', $item) }}', '{{ addslashes($item->name) }}')">Hapus</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="icon">🧊</div>
                            <p>Belum ada data barang.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-wrap">
        <span>Menampilkan {{ $items->firstItem() }}–{{ $items->lastItem() }} dari {{ $items->total() }} barang</span>
        <div style="display:flex; gap:4px; align-items:center;">
            @if($items->onFirstPage())
                <span class="btn btn-secondary btn-sm" style="opacity:.4; cursor:default;">‹ Prev</span>
            @else
                <a href="{{ $items->previousPageUrl() }}" class="btn btn-secondary btn-sm">‹ Prev</a>
            @endif
            @for($p = 1; $p <= $items->lastPage(); $p++)
                <a href="{{ $items->url($p) }}" class="btn btn-sm {{ $items->currentPage() == $p ? 'btn-primary' : 'btn-secondary' }}">{{ $p }}</a>
            @endfor
            @if($items->hasMorePages())
                <a href="{{ $items->nextPageUrl() }}" class="btn btn-secondary btn-sm">Next ›</a>
            @else
                <span class="btn btn-secondary btn-sm" style="opacity:.4; cursor:default;">Next ›</span>
            @endif
        </div>
    </div>
</div>
@endsection