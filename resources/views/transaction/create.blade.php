@extends('layouts.app')
@section('title', 'Input Stok')

@section('content')

<!-- PAGE HEADER -->
<div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">

    <div>

        <div class="small mb-2">

            <a href="{{ route('dashboard', $item) }}"
               class="text-decoration-none"
               style="color:var(--cyan-dark);">

                ‹ Kembali ke Halaman
            </a>

        </div>

        <h3 class="fw-bold mb-1"
            style="color:var(--navy);">

            Input Transaksi Stok
        </h3>

        <small class="text-muted">
            {{ $item->name }}
        </small>

    </div>

</div>

<div class="row g-4 justify-content-center">

    <!-- FORM -->
    <div class="col-12 col-lg-8">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white fw-semibold py-3">
                Form Transaksi Stok
            </div>

            <div class="card-body p-4">

                <form action="{{ route('transaction.store', $item) }}"
                      method="POST">

                    @csrf

                    <!-- JENIS TRANSAKSI -->
                    <div class="mb-4">

                        <label class="form-label fw-medium">
                            Jenis Transaksi
                            <span class="text-danger">*</span>
                        </label>

                        <div class="row g-3 mt-1">

                            @foreach([
                                ['in', '📦', 'Barang Masuk', 'Stok bertambah', '#22c55e'],
                                ['out', '🛒', 'Barang Keluar', 'Stok berkurang', '#0284c7'],
                                ['damaged', '🗑', 'Barang Rusak', 'Stok berkurang', '#f97316'],
                                ['return', '↩️', 'Retur', 'Stok bertambah', '#0f172a'],
                            ] as [$val, $icon, $label, $hint, $color])

                            <div class="col-12 col-md-6">

                                <label for="type_{{ $val }}"
                                       class="w-100"
                                       style="cursor:pointer;">

                                    <input type="radio"
                                           name="type"
                                           id="type_{{ $val }}"
                                           value="{{ $val }}"
                                           class="d-none"
                                           {{ old('type', 'in') == $val ? 'checked' : '' }}
                                           onchange="updatePreview()">

                                    <div class="type-card h-100"
                                         data-val="{{ $val }}"
                                         style="
                                            border:2px solid #e2e8f0;
                                            border-radius:12px;
                                            padding:14px;
                                            transition:.15s;
                                         ">

                                        <div style="font-size:22px;"
                                             class="mb-2">

                                            {{ $icon }}

                                        </div>

                                        <div class="fw-semibold"
                                             style="font-size:14px; color:{{ $color }};">

                                            {{ $label }}

                                        </div>

                                        <div class="text-muted small mt-1">
                                            {{ $hint }}
                                        </div>

                                    </div>

                                </label>

                            </div>

                            @endforeach

                        </div>

                        @error('type')
                            <div class="text-danger small mt-2">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <!-- JUMLAH -->
                    <div class="mb-4">

                        <label class="form-label fw-medium">
                            Jumlah
                            <span class="text-danger">*</span>
                        </label>

                        <div class="d-flex align-items-center gap-2 flex-wrap">

                            <button type="button"
                                    class="btn btn-secondary"
                                    onclick="adjustJumlah(-1)"
                                    style="font-size:18px; line-height:1;">

                                −
                            </button>

                            <input type="number"
                                   name="quantity"
                                   id="quantity"
                                   class="form-control text-center fw-bold"
                                   value="{{ old('quantity', 1) }}"
                                   min="1"
                                   style="
                                        width:120px;
                                        font-size:18px;
                                   "
                                   oninput="updatePreview()">

                            <button type="button"
                                    class="btn btn-secondary"
                                    onclick="adjustJumlah(1)"
                                    style="font-size:18px; line-height:1;">

                                +
                            </button>

                            <span class="text-muted small">
                                {{ $item->unit }}
                            </span>

                        </div>

                        @error('quantity')
                            <div class="text-danger small mt-2">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <!-- NOTE -->
                    <div class="mb-4">

                        <label class="form-label fw-medium">
                            Keterangan / Alasan
                        </label>

                        <textarea name="note"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Contoh: Terima dari supplier PT. Maju, PO #1234...">{{ old('note') }}</textarea>

                        @error('note')
                            <div class="text-danger small mt-2">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <!-- BUTTON -->
                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('dashboard', $item) }}"
                           class="btn btn-secondary">

                            Batal
                        </a>

                        <button type="submit"
                                class="btn btn-primary">

                            Simpan Transaksi
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- PREVIEW -->
    <div class="col-12 col-lg-4">

        <!-- STOK SAAT INI -->
        <div class="card border-0 shadow-sm mb-3">

            <div class="card-header bg-white fw-semibold py-3">
                Stok Saat Ini
            </div>

            <div class="card-body text-center py-4">

                <div id="prev-stok"
                     style="
                        font-size:48px;
                        font-weight:800;
                        font-family:'Space Mono', monospace;
                        color:var(--navy);
                     ">

                    {{ $item->stock }}

                </div>

                <div class="text-muted small">
                    {{ $item->unit }}
                </div>

            </div>

        </div>

        <!-- PREVIEW -->
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white fw-semibold py-3">
                Preview Setelah Transaksi
            </div>

            <div class="card-body text-center py-4">

                <div id="preview-delta"
                     class="fw-bold mb-2"
                     style="
                        font-size:22px;
                        color:#22c55e;
                     ">

                    +1

                </div>

                <div class="text-muted small mb-3">
                    perubahan
                </div>

                <div class="border-top pt-3">

                    <div class="text-uppercase text-muted mb-1"
                         style="
                            font-size:11px;
                            letter-spacing:.5px;
                         ">

                        Stok Setelah

                    </div>

                    <div id="preview-stok"
                         style="
                            font-size:40px;
                            font-weight:800;
                            font-family:'Space Mono', monospace;
                            color:var(--cyan-dark);
                         ">

                        {{ $item->stock + 1 }}

                    </div>

                    <div class="text-muted small">
                        {{ $item->unit }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('styles')
<style>
.type-card.selected{
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
    document.getElementById('preview-delta').textContent =
        isPositive ? '+' + jumlah : '-' + jumlah;

    document.getElementById('preview-delta').style.color =
        isPositive ? '#22c55e' : '#ef4444';

    document.querySelectorAll('.type-card')
        .forEach(c => c.classList.remove('selected'));

    const sel = document.querySelector(`.type-card[data-val="${type}"]`);

    if (sel) sel.classList.add('selected');
}

function adjustJumlah(delta) {
    const inp = document.getElementById('quantity');

    inp.value = Math.max(
        1,
        (parseInt(inp.value) || 0) + delta
    );

    updatePreview();
}

document.querySelectorAll('input[name=type]')
    .forEach(r => r.addEventListener('change', updatePreview));

updatePreview();
</script>
@endpush