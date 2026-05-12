@extends('layouts.app')
@section('title', 'Tambah Barang')

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
        </div>

        <h3 class="fw-bold mb-0" style="color:var(--navy);">
            Tambah Barang Baru
        </h3>

    </div>

</div>

<!-- FORM -->
<form action="{{ route('item.store') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <div class="card border-0 shadow-sm mx-auto"
         style="max-width:820px;">

        <!-- FOTO -->
        <div class="card-header bg-white border-bottom fw-semibold py-3">
            Foto Barang
        </div>

        <div class="card-body">

            <div class="photo-upload-area"
                 onclick="document.getElementById('photo').click()">

                <div class="display-6 mb-2">
                    🖼
                </div>

                <p class="fw-medium mb-1">
                    Klik untuk memilih foto, atau seret file ke sini
                </p>

                <p class="small text-muted mb-0">
                    Format: JPG, PNG — Maks. 2 MB
                </p>

                <button type="button"
                        class="btn btn-secondary btn-sm mt-3"
                        onclick="event.stopPropagation(); document.getElementById('photo').click()">

                    Pilih Foto
                </button>

                <img id="photo-preview"
                     class="img-fluid rounded-3 mt-3 d-none"
                     style="max-height:200px; object-fit:cover;">

            </div>

            <input type="file"
                   id="photo"
                   name="photo"
                   accept="image/jpg,image/jpeg,image/png"
                   class="d-none"
                   onchange="previewFoto(this)">

            @error('photo')
                <div class="text-danger small mt-2">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <!-- INFORMASI -->
        <div class="card-header bg-white border-top fw-semibold py-3">
            Informasi Barang
        </div>

        <div class="card-body">

            <!-- NAMA -->
            <div class="mb-3">

                <label class="form-label fw-medium">
                    Nama Barang
                    <span class="text-danger">*</span>
                </label>

                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name') }}"
                       placeholder="Contoh: Ayam nugget crispy">

                @error('name')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <!-- KATEGORI -->
            <div class="row g-3">

                <div class="col-md-6">

                    <label class="form-label fw-medium">
                        Kategori
                        <span class="text-danger">*</span>
                    </label>

                    <select name="category_id"
                            class="form-select">

                        <option value="">
                            Pilih kategori
                        </option>

                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id') == $cat->id ? 'selected' : '' }}>

                                {{ $cat->name }}

                            </option>
                        @endforeach

                    </select>

                    @error('category_id')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="col-md-6">

                    <label class="form-label fw-medium">
                        Satuan
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="unit"
                           class="form-control"
                           value="{{ old('unit', 'pcs') }}"
                           placeholder="pcs, pack, kg, box...">

                    @error('unit')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

            <!-- STOK -->
            <div class="row g-3 mt-1">

                <div class="col-md-6">

                    <label class="form-label fw-medium">
                        Jumlah Stok
                        <span class="text-danger">*</span>
                    </label>

                    <input type="number"
                           name="stock"
                           class="form-control"
                           value="{{ old('stock', 0) }}"
                           min="0">

                    @error('stock')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="col-md-6">

                    <label class="form-label fw-medium">
                        Stok Minimum
                    </label>

                    <input type="number"
                           name="minimum_stock"
                           class="form-control"
                           value="{{ old('minimum_stock', 0) }}"
                           min="0">

                    @error('minimum_stock')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

            <!-- HARGA -->
            <div class="row g-3 mt-1">

                <div class="col-md-6">

                    <label class="form-label fw-medium">
                        Harga Jual (Rp)
                    </label>

                    <input type="number"
                           name="selling_price"
                           class="form-control"
                           value="{{ old('selling_price') }}"
                           min="0"
                           placeholder="35000">

                    @error('selling_price')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="col-md-6">

                    <label class="form-label fw-medium">
                        Harga Beli (Rp)
                    </label>

                    <input type="number"
                           name="purchase_price"
                           class="form-control"
                           value="{{ old('purchase_price') }}"
                           min="0"
                           placeholder="28000">

                    @error('purchase_price')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

            <!-- BERAT -->
            <div class="row g-3 mt-1">

                <div class="col-md-6">

                    <label class="form-label fw-medium">
                        Berat / Ukuran
                    </label>

                    <input type="text"
                           name="weight"
                           class="form-control"
                           value="{{ old('weight') }}"
                           placeholder="500 gram">

                </div>

                <div class="col-md-6">

                    <label class="form-label fw-medium">
                        Lokasi Simpan
                    </label>

                    <input type="text"
                           name="storage_location"
                           class="form-control"
                           value="{{ old('storage_location') }}"
                           placeholder="Rak A-3">

                </div>

            </div>

            <!-- DESKRIPSI -->
            <div class="mt-3">

                <label class="form-label fw-medium">
                    Deskripsi
                </label>

                <textarea name="description"
                          class="form-control"
                          rows="4"
                          placeholder="Deskripsi singkat tentang produk ini...">{{ old('description') }}</textarea>

            </div>

            <!-- BUTTON -->
            <div class="d-flex justify-content-end gap-2 mt-4">

                <a href="{{ route('dashboard') }}"
                   class="btn btn-secondary">

                    Batal
                </a>

                <button type="submit"
                        class="btn btn-primary">

                    Simpan Barang
                </button>

            </div>

        </div>

    </div>

</form>

@endsection

@push('scripts')
<script>
function previewFoto(input) {

    const file = input.files[0];

    if (!file) return;

    const reader = new FileReader();

    reader.onload = function(e){

        const img = document.getElementById('photo-preview');

        img.src = e.target.result;

        img.classList.remove('d-none');
    };

    reader.readAsDataURL(file);
}
</script>
@endpush