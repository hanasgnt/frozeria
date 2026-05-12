@extends('layouts.app')
@section('title', 'Riwayat Stok')

@section('content')

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h3 class="fw-bold mb-0" style="color:var(--navy);">

                Riwayat Semua Transaksi Stok
            </h3>

            <small class="text-muted">
                Monitoring seluruh aktivitas keluar masuk stok barang
            </small>

        </div>

    </div>

    <!-- FILTER -->
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="d-flex align-items-end gap-2 flex-nowrap overflow-auto">

                    <!-- SEARCH -->
                    <div style="min-width:260px;">

                        <label class="form-label small fw-medium mb-1">
                            Search
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted" style="font-size:13px;"></i>
                            </span>

                            <input type="text" name="q" class="form-control border-start-0 ps-0"
                                placeholder="Cari barang / catatan..." value="{{ request('q') }}"
                                style="font-size:13.5px;">

                        </div>

                    </div>

                    <!-- BARANG -->
                    <div style="min-width:200px;">

                        <label class="form-label small fw-medium mb-1">
                            Barang
                        </label>

                        <select name="item" class="form-select" style="font-size:13.5px;">

                            <option value="">Semua Barang</option>

                            @foreach ($items as $i)
                                <option value="{{ $i->id }}" {{ request('item') == $i->id ? 'selected' : '' }}>

                                    {{ $i->name }}

                                </option>
                            @endforeach

                        </select>

                    </div>

                    <!-- JENIS -->
                    <div style="min-width:180px;">

                        <label class="form-label small fw-medium mb-1">
                            Jenis
                        </label>

                        <select name="t" class="form-select" style="font-size:13.5px;">

                            <option value="">Semua Jenis</option>

                            <option value="in" {{ request('t') == 'in' ? 'selected' : '' }}>
                                Barang Masuk
                            </option>

                            <option value="out" {{ request('t') == 'out' ? 'selected' : '' }}>
                                Barang Keluar
                            </option>

                            <option value="damaged" {{ request('t') == 'damaged' ? 'selected' : '' }}>
                                Barang Rusak
                            </option>

                            <option value="return" {{ request('t') == 'return' ? 'selected' : '' }}>
                                Retur
                            </option>

                        </select>

                    </div>

                    <!-- FROM -->
                    <div style="min-width:170px;">

                        <label class="form-label small fw-medium mb-1">
                            Dari
                        </label>

                        <input type="date" name="from" class="form-control" value="{{ request('from') }}"
                            style="font-size:13.5px;">

                    </div>

                    <!-- TO -->
                    <div style="min-width:170px;">

                        <label class="form-label small fw-medium mb-1">
                            Sampai
                        </label>

                        <input type="date" name="to" class="form-control" value="{{ request('to') }}"
                            style="font-size:13.5px;">

                    </div>

                    <!-- BUTTON -->
                    <div class="d-flex gap-2 flex-shrink-0">

                        <button type="submit" class="btn btn-secondary btn-sm px-3" style="height:35px;">

                            Filter

                        </button>

                        @if (request()->hasAny(['q', 'item', 't', 'from', 'to']))
                            <a href="{{ route('transaction.index') }}"
                                class="btn btn-outline-secondary btn-sm px-3 d-flex align-items-center"
                                style="height:35px;">

                                Reset

                            </a>
                        @endif

                    </div>

                </div>

            </form>

        </div>


        <div class="card-body">

            @if ($transactions->count() > 0)

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>
                            <tr>
                                <th>Tanggal & Waktu</th>
                                <th>Barang</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Sebelum → Sesudah</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($transactions as $t)
                                <tr>

                                    <!-- TANGGAL -->
                                    <td style="font-size:13px; white-space:nowrap;">

                                        {{ $t->created_at->format('d M Y') }}

                                        <br>

                                        <span class="text-muted small">
                                            {{ $t->created_at->format('H:i') }}
                                        </span>

                                    </td>

                                    <!-- BARANG -->
                                    <td>

                                        <a href="{{ route('transaction.history', $t->item) }}"
                                            class="text-decoration-none fw-medium" style="color:var(--cyan-dark);">

                                            {{ $t->item->name }}

                                        </a>

                                        @if ($t->item->category)
                                            <br>

                                            <span class="badge-kategori">
                                                {{ $t->item->category->name }}
                                            </span>
                                        @endif

                                    </td>

                                    <!-- JENIS -->
                                    <td>

                                        @php
                                            $badgeClass = match ($t->type) {
                                                'in' => 'success',
                                                'out' => 'primary',
                                                'damaged' => 'warning',
                                                'return' => 'secondary',
                                                default => 'dark',
                                            };
                                        @endphp

                                        <span class="badge text-bg-{{ $badgeClass }} text-uppercase"
                                            style="font-size:11px;">

                                            {{ $t->type }}

                                        </span>

                                    </td>

                                    <!-- JUMLAH -->
                                    <td>

                                        <span class="fw-bold"
                                            style="
                                    font-family:'Space Mono', monospace;
                                    color:{{ $t->isPositive() ? '#22c55e' : '#ef4444' }};
                                  ">

                                            {{ $t->quantity }} {{ $t->item->unit }}

                                        </span>

                                    </td>

                                    <!-- STOCK -->
                                    <td style="font-family:'Space Mono', monospace; font-size:13px;">

                                        <span class="text-muted">
                                            {{ $t->stock_before }}
                                        </span>

                                        →

                                        <span class="fw-semibold" style="color:var(--navy);">

                                            {{ $t->stock_after }}

                                        </span>

                                    </td>

                                    <!-- NOTE -->
                                    <td class="text-muted" style="font-size:13px; max-width:240px;">

                                        {{ $t->note ?? '—' }}

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

                <!-- PAGINATION -->
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 px-3 py-3 border-top"
                    style="font-size:13px; color:#64748b;">

                    <span>
                        Menampilkan
                        {{ $transactions->firstItem() }}–{{ $transactions->lastItem() }}
                        dari {{ $transactions->total() }} transaksi
                    </span>

                    <div class="d-flex gap-1">

                        @if (!$transactions->onFirstPage())
                            <a href="{{ $transactions->previousPageUrl() }}" class="btn btn-secondary btn-sm">

                                ‹ Prev
                            </a>
                        @endif

                        @if ($transactions->hasMorePages())
                            <a href="{{ $transactions->nextPageUrl() }}" class="btn btn-secondary btn-sm">

                                Next ›
                            </a>
                        @endif

                    </div>

                </div>
            @else
                <!-- EMPTY -->
                <div class="text-center py-5 text-muted">

                    <div style="font-size:56px;">
                        📋
                    </div>

                    <p class="mt-3 mb-0">
                        Belum ada transaksi stok.
                    </p>

                </div>

            @endif


        </div>

    @endsection

    @push('scripts')
        <script>
            document.querySelectorAll('select, input[type="date"]').forEach(el => {
                el.addEventListener('change', function() {
                    this.form.submit();
                });
            });
        </script>
    @endpush
