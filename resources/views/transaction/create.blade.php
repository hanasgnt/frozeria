@extends('layouts.app')
@section('title', 'Input Stok')

@section('content')
<div class="page-header">
    <div>
        <div style="font-size:13px; margin-bottom:6px;">
            <a href="{{ route('dashboard', $item) }}" style="color:var(--cyan-dark); text-decoration:none;">‹ Kembali ke Halaman</a>
        </div>
        <div class="page-title">Input Transaksi Stok</div>
        <div class="breadcrumb">{{ $item->name }}</div>
    </div>
</div>

<div style="display:grid; grid-template-columns: 1fr 320px; gap:20px; align-items:start; max-width:860px;">

    <!-- Form -->
    <div class="card">
        <div class="card-header">Form Transaksi Stok</div>
        <div class="card-body">
            <form action="{{ route('transaction.store', $item) }}" method="POST">
            @csrf

                <!-- Jenis Transaksi -->
                <div class="form-group">
                    <label>Jenis Transaksi <span style="color:var(--red)">*</span></label>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:4px;">
                        @foreach([
                            ['in',  '📦', 'Barang Masuk',  'Stok bertambah', 'var(--green)'],
                            ['out', '🛒', 'Barang Keluar', 'Stok berkurang', 'var(--cyan-dark)'],
                            ['damaged',  '🗑', 'Barang Rusak',  'Stok berkurang', 'var(--orange)'],
                            ['return',  '↩️', 'Retur',         'Stok bertambah', 'var(--navy)'],
                        ] as [$val, $icon, $label, $hint, $color])
                        <label class="type-option" for="type_{{ $val }}" style="cursor:pointer;">
                            <input type="radio" name="type" id="type_{{ $val }}" value="{{ $val }}"
                                {{ old('type', 'in') == $val ? 'checked' : '' }}
                                style="display:none;" onchange="updatePreview()">
                            <div class="type-card" data-val="{{ $val }}" style="border:2px solid var(--gray-200); border-radius:8px; padding:12px 14px; transition:all .15s; user-select:none;">
                                <div style="font-size:20px; margin-bottom:4px;">{{ $icon }}</div>
                                <div style="font-weight:600; font-size:14px; color:{{ $color }};">{{ $label }}</div>
                                <div style="font-size:12px; color:var(--gray-400); margin-top:2px;">{{ $hint }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('type')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Jumlah -->
                <div class="form-group">
                    <label>Jumlah <span style="color:var(--red)">*</span></label>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <button type="button" class="btn btn-secondary" onclick="adjustJumlah(-1)" style="font-size:18px; padding:6px 14px; line-height:1;">−</button>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1" style="width:120px; text-align:center; font-size:18px; font-weight:700;" oninput="updatePreview()">
                        <button type="button" class="btn btn-secondary" onclick="adjustJumlah(1)" style="font-size:18px; padding:6px 14px; line-height:1;">+</button>
                        <span style="color:var(--gray-400); font-size:14px;">{{ $item->unit }}</span>
                    </div>
                    @error('quantity')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Keterangan -->
                <div class="form-group">
                    <label>Keterangan / Alasan</label>
                    <textarea name="note" placeholder="Contoh: Terima dari supplier PT. Maju, PO #1234...">{{ old('note') }}</textarea>
                    @error('note')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:8px;">
                    <a href="{{ route('dashboard', $item) }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Preview -->
    <div>
        <div class="card" style="margin-bottom:16px;">
            <div class="card-header">Stok Saat Ini</div>
            <div class="card-body" style="text-align:center; padding:24px;">
                <div style="font-size:48px; font-weight:800; font-family:'Space Mono',monospace; color:var(--navy);" id="prev-stok">
                    {{ $item->stock }}
                </div>
                <div style="font-size:14px; color:var(--gray-400);">{{ $item->unit }}</div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Preview Setelah Transaksi</div>
            <div class="card-body" style="text-align:center; padding:24px;">
                <div id="preview-delta" style="font-size:22px; font-weight:700; margin-bottom:8px; color:var(--green);">+1</div>
                <div style="font-size:13px; color:var(--gray-400); margin-bottom:12px;">perubahan</div>
                <div style="border-top:1px solid var(--gray-200); padding-top:14px;">
                    <div style="font-size:11px; text-transform:uppercase; letter-spacing:.5px; color:var(--gray-400); margin-bottom:4px;">Stok Setelah</div>
                    <div id="preview-stok" style="font-size:40px; font-weight:800; font-family:'Space Mono',monospace; color:var(--cyan-dark);">
                        {{ $item->stock + 1 }}
                    </div>
                    <div style="font-size:14px; color:var(--gray-400);">{{ $item->unit }}</div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
.type-card.selected {
    border-color: var(--cyan) !important;
    background: var(--ice);
    box-shadow: 0 0 0 3px rgba(0,180,216,.15);
}
</style>
@endpush

@push('scripts')
<script>
const stokSekarang = {{ $item->stock }};

function updatePreview() {
    const type = document.querySelector('input[name=type]:checked')?.value || 'in';
    const jumlah = parseInt(document.getElementById('quantity').value) || 0;
    const isPositive = ['in','return'].includes(type);

    const stokBaru = isPositive
        ? stokSekarang + jumlah
        : Math.max(0, stokSekarang - jumlah);

    document.getElementById('preview-stok').textContent = stokBaru;
    document.getElementById('preview-delta').textContent = isPositive ? '+' + jumlah : '-' + jumlah;
    document.getElementById('preview-delta').style.color = isPositive ? 'var(--green)' : 'var(--red)';

    // Highlight selected card
    document.querySelectorAll('.type-card').forEach(c => c.classList.remove('selected'));
    const sel = document.querySelector(`.type-card[data-val="${type}"]`);
    if (sel) sel.classList.add('selected');
}

function adjustJumlah(delta) {
    const inp = document.getElementById('quantity');
    inp.value = Math.max(1, (parseInt(inp.value) || 0) + delta);
    updatePreview();
}

// Init
document.querySelectorAll('input[name=type]').forEach(r => r.addEventListener('change', updatePreview));
updatePreview();
</script>
@endpush
