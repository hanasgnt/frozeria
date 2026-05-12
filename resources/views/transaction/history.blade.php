@extends('layouts.app')
@section('title', 'Riwayat Stok')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <div class="small mb-1">
            <a href="{{ route('dashboard', $item) }}" class="text-decoration-none" style="color:var(--cyan-dark);">
                ‹ Kembali ke Halaman
            </a>
        </div>

        <h3 class="fw-bold mb-1" style="color:var(--navy);">
            Riwayat Stok
        </h3>

        <div class="text-secondary small">
            {{ $item->name }}
        </div>
    </div>

    <a href="{{ route('transaction.create', $item) }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Input Transaksi
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        @if($transactions->count() > 0)

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Tanggal & Waktu</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Stok Sebelum</th>
                        <th>Stok Sesudah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($transactions as $t)
                    <tr>

                        <!-- Tanggal -->
                        <td class="small text-secondary" style="white-space:nowrap;">
                            {{ $t->created_at->format('d M Y') }}
                            <br>
                            <span class="text-muted" style="font-size:11px;">
                                {{ $t->created_at->format('H:i') }}
                            </span>
                        </td>

                        <!-- Jenis -->
                        <td>
                            @php
                                $badgeClass = match($t->type) {
                                    'in' => 'success',
                                    'out' => 'info',
                                    'damaged' => 'warning',
                                    'return' => 'secondary',
                                    default => 'dark'
                                };

                                $label = match($t->type) {
                                    'in' => 'Barang Masuk',
                                    'out' => 'Barang Keluar',
                                    'damaged' => 'Barang Rusak',
                                    'return' => 'Retur',
                                    default => ucfirst($t->type)
                                };
                            @endphp

                            <span class="badge rounded-pill text-bg-{{ $badgeClass }}">
                                {{ $label }}
                            </span>
                        </td>

                        <!-- Jumlah -->
                        <td>
                            <span
                                class="fw-bold"
                                style="
                                    font-family:'Space Mono', monospace;
                                    font-size:15px;
                                    color: {{ $t->isPositive() ? '#22c55e' : '#ef4444' }};
                                "
                            >
                                {{ $t->quantity }}
                            </span>

                            <span class="text-muted small">
                                {{ $item->unit }}
                            </span>
                        </td>

                        <!-- Sebelum -->
                        <td
                            class="text-secondary"
                            style="font-family:'Space Mono', monospace;"
                        >
                            {{ $t->stock_before }}
                        </td>

                        <!-- Sesudah -->
                        <td
                            class="fw-semibold"
                            style="
                                font-family:'Space Mono', monospace;
                                color:var(--navy);
                            "
                        >
                            {{ $t->stock_after }}
                        </td>

                        <!-- Keterangan -->
                        <td
                            class="small text-secondary"
                            style="max-width:260px;"
                        >
                            {{ $t->note ?? '—' }}
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 px-4 py-3 border-top">

            <div class="small text-secondary">
                Menampilkan
                {{ $transactions->firstItem() }}
                –
                {{ $transactions->lastItem() }}
                dari
                {{ $transactions->total() }}
                transaksi
            </div>

            <div>
                {{ $transactions->links() }}
            </div>

        </div>

        @else

        <!-- Empty State -->
        <div class="text-center py-5 px-4">

            <div class="mb-3" style="font-size:56px;">
                📋
            </div>

            <h5 class="fw-semibold mb-2">
                Belum ada transaksi stok
            </h5>

            <p class="text-secondary mb-4">
                Belum ada transaksi stok untuk barang ini.
            </p>

            <a href="{{ route('transaction.create', $item) }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                Input Transaksi Pertama
            </a>

        </div>

        @endif

    </div>
</div>

@endsection