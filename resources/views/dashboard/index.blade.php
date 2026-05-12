@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0" style="color:var(--navy);">Dashboard</h4>
            <small class="text-muted">Sistem Stok Opname — Frozeria</small>
        </div>
        <a href="{{ route('item.create') }}" class="btn btn-primary btn-sm px-3">
            <i class="bi bi-plus-lg me-1"></i> Tambah Barang
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm stat-card h-100">
                <div class="card-body position-relative">
                    <div class="stat-icon position-absolute">
                        <i class="bi bi-box-seam"></i>
                    </div>

                    <div class="stat-label mb-1">Total Barang</div>
                    <div class="stat-value">{{ $totalItems }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm stat-card success h-100">
                <div class="card-body">
                    <div class="stat-icon position-absolute">
                        <i class="bi bi-tags"></i>
                    </div>
                    <div class="stat-label mb-1">Total Kategori</div>
                    <div class="stat-value">{{ $totalCategories }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm stat-card warning h-100">
                <div class="card-body">
                    <div class="stat-icon position-absolute">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div class="stat-label mb-1">Stok Menipis</div>
                    <div class="stat-value">{{ $stokMenipis }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm stat-card danger h-100">
                <div class="card-body">
                    <div class="stat-icon position-absolute">
                        <i class="bi bi-x-circle"></i>
                    </div>
                    <div class="stat-label mb-1">Stok Habis</div>
                    <div class="stat-value">{{ $stokHabis }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body pb-0">
            <form method="GET" action="{{ route('dashboard') }}">
                <div class="d-flex align-items-center gap-2 flex-nowrap mb-3 overflow-auto">
                    <div class="input-group flex-grow-1" style="min-width:260px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted" style="font-size:13px;"></i>
                        </span>
                        <input type="text" name="search"
                            class="form-control border-start-0 ps-0"placeholder="Cari nama barang..."
                            value="{{ request('search') }}" style="font-size:13.5px;">
                    </div>
                    <select name="cid" class="form-select flex-shrink-0" style="width:200px; font-size:13.5px;"
                        onchange="this.form.submit()">
                        <option value="">Semua kategori</option>
                        <option value="null" {{ request('cid') === 'null' ? 'selected' : '' }}>
                            Tanpa Kategori
                        </option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('cid') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="btn btn-secondary btn-sm px-3 flex-shrink-0"style="font-size:13px; height:35px;">
                        Cari
                    </button>
                    @if (request('search') || request('cid'))
                        <a href="{{ route('dashboard') }}"
                            class="btn btn-outline-secondary btn-sm px-3 flex-shrink-0"style="font-size:13px; height:35px; display:flex; align-items:center;">
                            Reset
                        </a>
                    @endif

                </div>
            </form>

            <form method="GET" class="d-flex align-items-center gap-2 mb-3">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="cid" value="{{ request('cid') }}">
                <small class="text-muted">Tampilkan</small>
                <select name="per_page" class="form-select form-select-sm" style="width:75px;"
                    onchange="this.form.submit()">
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th style="width:25%">Nama Barang</th>
                            <th style="width:15%">Kategori</th>
                            <th style="width:10%">Stok</th>
                            <th style="width:10%">Satuan</th>
                            <th style="width:15%">Harga Jual</th>
                            <th style="width:20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $i => $item)
                            <tr>
                                <td class="text-muted" style="font-size:12px;">{{ $items->firstItem() + $i }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($item->photo)
                                            <img src="{{ asset('storage/' . $item->photo) }}" class="photo-thumb">
                                        @else
                                            <div class="no-photo">🧊</div>
                                        @endif
                                        <span class="fw-500">{{ $item->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if ($item->category)
                                        <span class="badge-kategori">{{ $item->category->name }}</span>
                                    @else
                                        <span class="text-muted" style="font-size:12px;">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->stock == 0)
                                        <span class="stok-habis">{{ $item->stock }}</span>
                                    @elseif($item->stock < 20)
                                        <span class="stok-menipis">{{ $item->stock }}</span>
                                    @else
                                        <span class="stok-ok">{{ $item->stock }}</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $item->unit }}</td>
                                <td style="font-size:13px;">
                                    @if ($item->selling_price)
                                        Rp {{ number_format($item->selling_price, 0, ',', '.') }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('transaction.create', $item) }}" class="btn btn-primary btn-sm"
                                            style="font-size:12px;">
                                            <i class="bi bi-plus"></i> Stok
                                        </a>
                                        <a href="{{ route('item.show', $item) }}" class="btn btn-outline-primary btn-sm"
                                            style="font-size:12px;">
                                            Detail
                                        </a>
                                        <a href="{{ route('item.edit', $item) }}" class="btn btn-secondary btn-sm"
                                            style="font-size:12px;">
                                            Edit
                                        </a>
                                        <button class="btn btn-danger btn-sm" style="font-size:12px;"
                                            onclick="openDeleteModal('{{ route('item.destroy', $item) }}', '{{ addslashes($item->name) }}')">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="text-center py-5 text-muted">
                                        <div style="font-size:48px;">🧊</div>
                                        <p class="mt-2 mb-0">Belum ada data barang.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PAGINATION -->
        @if ($items->total() > 0)
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 px-3 py-3 border-top"
                style="font-size:13px; color:#475569;">
                <span>
                    Menampilkan {{ $items->firstItem() }}–{{ $items->lastItem() }}
                    dari {{ $items->total() }} barang
                </span>
                <div class="d-flex align-items-center gap-2">
                    <nav>
                        <ul class="pagination pagination-sm mb-0 gap-1">
                            @if ($items->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link rounded">‹ Prev</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link rounded" href="{{ $items->previousPageUrl() }}">
                                        ‹ Prev
                                    </a>
                                </li>
                            @endif
                            @for ($p = 1; $p <= $items->lastPage(); $p++)
                                <li class="page-item {{ $items->currentPage() == $p ? 'active' : '' }}">
                                    <a class="page-link rounded" href="{{ $items->url($p) }}">
                                        {{ $p }}
                                    </a>
                                </li>
                            @endfor
                            @if ($items->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link rounded" href="{{ $items->nextPageUrl() }}">
                                        Next ›
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link rounded">Next ›</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        @endif
    </div>
@endsection
