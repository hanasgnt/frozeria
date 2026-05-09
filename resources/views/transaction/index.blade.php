@extends('layouts.app')
@section('title', 'Riwayat Stok')

@section('content')
<div class="page-header">
    <div class="page-title">Riwayat Semua Transaksi Stok</div>
</div>

<!-- Filter -->
<div class="card" style="margin-bottom:20px;">
    <div class="card-body">
        <form method="GET" style="display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end;">
            <div>
                <label style="font-size:12px;">Barang</label>
                <select name="item" style="min-width:180px;">
                    <option value="">Semua Barang</option>
                    @foreach($items as $i)
                        <option value="{{ $i->id }}" {{ request('item') == $i->id ? 'selected' : '' }}>{{ $i->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="font-size:12px;">Jenis</label>
                <select name="t" style="width:160px;">
                    <option value="">Semua Jenis</option>
                    <option value="in"  {{ request('t') == 'in'  ? 'selected' : '' }}>Barang Masuk</option>
                    <option value="out" {{ request('t') == 'out' ? 'selected' : '' }}>Barang Keluar</option>
                    <option value="damaged"  {{ request('t') == 'damaged'  ? 'selected' : '' }}>Barang Rusak</option>
                    <option value="return"  {{ request('t') == 'return'  ? 'selected' : '' }}>Retur</option>
                </select>
            </div>
            <div>
                <label style="font-size:12px;">Dari Tanggal</label>
                <input type="date" name="from" value="{{ request('from') }}" style="width:160px;">
            </div>
            <div>
                <label style="font-size:12px;">Sampai Tanggal</label>
                <input type="date" name="to" value="{{ request('to') }}" style="width:160px;">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            @if(request()->hasAny(['item','t','from','to']))
                <a href="{{ route('transaction.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            @endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding:0;">
        @if($transactions->count() > 0)
        <table>
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
                @foreach($transactions as $t)
                <tr>
                    <td style="font-size:13px; white-space:nowrap;">
                        {{ $t->created_at->format('d M Y') }}<br>
                        <span style="font-size:11px; color:var(--gray-400);">{{ $t->created_at->format('H:i') }}</span>
                    </td>
                    <td>
                        <a href="{{ route('transaction.history', $t->item) }}" style="color:var(--cyan-dark); text-decoration:none; font-weight:500;">
                            {{ $t->item->name }}
                        </a>
                        @if($t->item->category)
                            <br><span class="badge" style="font-size:11px;">{{ $t->item->category->name }}</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge" style="
                            background: {{ match($t->type) { 'in'=>'#dcfce7','out'=>'#e0f2fe','damaged'=>'#fff7ed','return'=>'#f3f4f6' } }};
                            color: {{ match($t->type) { 'in'=>'#166534','out'=>'#0369a1','damaged'=>'#c2410c','return'=>'#374151' } }};
                        ">{{ $t->type }}</span>
                    </td>
                    <td style="font-family:'Space Mono',monospace; font-weight:700; color:{{ $t->isPositive() ? 'var(--green)' : 'var(--red)' }};">
                        {{ $t->quantity }} {{ $t->item->unit }}
                    </td>
                    <td style="font-family:'Space Mono',monospace; font-size:13px;">
                        <span style="color:var(--gray-400);">{{ $t->stock_before }}</span>
                        → <span style="color:var(--navy); font-weight:600;">{{ $t->stock_after }}</span>
                    </td>
                    <td style="font-size:13px; color:var(--gray-600); max-width:220px;">{{ $t->note ?? '—' }}</td>
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
            <p>Belum ada transaksi stok.</p>
        </div>
        @endif
    </div>
</div>
@endsection
@push('styles')
    <style>
        input[type="date"] {
            width: 100%;
            padding: 9px 13px;
            border: 1.5px solid var(--gray-200);
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-family: inherit;
            color: var(--gray-800);
            background: var(--white);
            transition: border-color .15s;
            outline: none;
        }
    </style>
@endpush
@push('scripts')
<script>
    document.querySelectorAll('select, input[type="date"]').forEach(el => {
        el.addEventListener('change', function () {
            this.form.submit();
        });
    });
</script>
@endpush