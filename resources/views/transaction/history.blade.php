@extends('layouts.app')
@section('title', 'Riwayat Stok')

@section('content')
<div class="page-header">
    <div>
        <div style="font-size:13px; margin-bottom:6px;">
            <a href="{{ route('dashboard', $item) }}" style="color:var(--cyan-dark); text-decoration:none;">‹ Kembali ke Halaman</a>
        </div>
        <div class="page-title">Riwayat Stok</div>
        <div class="breadcrumb">{{ $item->name }}</div>
    </div>
    <a href="{{ route('transaction.create', $item) }}" class="btn btn-primary">+ Input Transaksi</a>
</div>

<div class="card">
    <div class="card-body" style="padding:0">
        @if($transactions->count() > 0)
        <table>
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
                    <td style="font-size:13px; color:var(--gray-600); white-space:nowrap;">
                        {{ $t->created_at->format('d M Y') }}<br>
                        <span style="font-size:11px; color:var(--gray-400);">{{ $t->created_at->format('H:i') }}</span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $t->type }}" style="
                            background: {{ match($t->type) {
                                'in'  => '#dcfce7',
                                'out' => '#e0f2fe',
                                'damaged'  => '#fff7ed',
                                'return'  => '#f3f4f6',
                            } }};
                            color: {{ match($t->type) {
                                'in'  => '#166534',
                                'out' => '#0369a1',
                                'damaged'  => '#c2410c',
                                'return'  => '#374151',
                            } }};
                        ">{{ $t->type }}</span>
                    </td>
                    <td>
                        <span style="font-family:'Space Mono',monospace; font-weight:700; font-size:15px;
                            color: {{ $t->isPositive() ? 'var(--green)' : 'var(--red)' }};">
                            {{ $t->quantity }}
                        </span>
                        <span style="font-size:12px; color:var(--gray-400);"> {{ $item->unit }}</span>
                    </td>
                    <td style="font-family:'Space Mono',monospace; color:var(--gray-600);">{{ $t->stock_before }}</td>
                    <td style="font-family:'Space Mono',monospace; font-weight:600; color:var(--navy);">{{ $t->stock_after }}</td>
                    <td style="font-size:13px; color:var(--gray-600); max-width:260px;">
                        {{ $t->note ?? '—' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination-wrap">
            <span>Menampilkan {{ $transactions->firstItem() }}–{{ $transactions->lastItem() }} dari {{ $transactions->total() }} transaksi</span>
            <div style="display:flex; gap:4px;">
                @if(!$transactions->onFirstPage())
                    <a href="{{ $transactions->previousPageUrl() }}" class="btn btn-secondary btn-sm">‹ Prev</a>
                @endif
                @if($transactions->hasMorePages())
                    <a href="{{ $transactions->nextPageUrl() }}" class="btn btn-secondary btn-sm">Next ›</a>
                @endif
            </div>
        </div>

        @else
        <div class="empty-state">
            <div class="icon">📋</div>
            <p>Belum ada transaksi stok untuk barang ini.</p>
            <a href="{{ route('transaction.create', $item) }}" class="btn btn-primary" style="margin-top:12px;">Input Transaksi Pertama</a>
        </div>
        @endif
    </div>
</div>
@endsection
