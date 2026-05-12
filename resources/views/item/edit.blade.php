@extends('layouts.app')
@section('title', 'Edit Barang')

@section('content')

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">

        <div>

            <div class="small mb-2">
                <a href="{{ route('dashboard') }}" class="text-decoration-none" style="color:var(--cyan-dark);">

                    ‹ Kembali
                </a>
            </div>

            <h3 class="fw-bold mb-0" style="color:var(--navy);">
                Edit Barang
            </h3>

        </div>

    </div>

    <!-- FORM -->
    <form action="{{ route('item.update', $item) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm mx-auto" style="max-width:820px;">

            <!-- FOTO -->
            <div class="card-header bg-white border-bottom fw-semibold py-3">
                Foto Barang
            </div>

            <div class="card-body">

                <div class="photo-upload-area" onclick="document.getElementById('photo').click()">

                    <div class="display-6 mb-2">
                        🖼
                    </div>

                    @if ($item->photo)
                        <img id="photo-preview" src="{{ asset('storage/' . $item->photo) }}"
                            class="img-fluid rounded-3 mt-2" style="max-height:200px; object-fit:cover;">
                    @else
                        <img id="photo-preview" class="img-fluid rounded-3 mt-3 d-none"
                            style="max-height:200px; object-fit:cover;">
                    @endif

                    <p class="fw-medium mt-3 mb-1">
                        Klik untuk mengganti foto, atau seret file ke sini
                    </p>

                    <p class="small text-muted mb-0">
                        Format: JPG, PNG — Maks. 2 MB
                    </p>

                    <button type="button" class="btn btn-secondary btn-sm mt-3"
                        onclick="event.stopPropagation(); document.getElementById('photo').click()">

                        Pilih Foto
                    </button>

                </div>

                <input type="file" id="photo" name="photo" accept="image/jpg,image/jpeg,image/png" class="d-none"
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

                    <input type="text" name="name" class="form-control" value="{{ old('name', $item->name) }}"
                        required>

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
                        </label>

                        <select name="category_id" class="form-select">

                            <option value="">
                                Pilih kategori
                            </option>

                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $item->category_id) == $cat->id ? 'selected' : '' }}>

                                    {{ $cat->name }}

                                </option>
                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-medium">
                            Satuan
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="unit" class="form-control" value="{{ old('unit', $item->unit) }}"
                            required>

                    </div>

                </div>

                <!-- STOK -->
                <div class="row g-3 mt-1">

                    <div class="col-md-6">

                        <label class="form-label fw-medium">
                            Jumlah Stok
                            <span class="text-danger">*</span>
                        </label>

                        <input type="number" name="stock" class="form-control" value="{{ old('stock', $item->stock) }}"
                            min="0" required>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-medium">
                            Stok Minimum
                        </label>

                        <input type="number" name="minimum_stock" class="form-control"
                            value="{{ old('minimum_stock', $item->minimum_stock) }}" min="20">

                    </div>

                </div>

                <!-- HARGA -->
                <div class="row g-3 mt-1">

                    <div class="col-md-6">

                        <label class="form-label fw-medium">
                            Harga Jual (Rp)
                        </label>

                        <input type="number" name="selling_price" class="form-control"
                            value="{{ old('selling_price', $item->selling_price) }}" min="0">

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-medium">
                            Harga Beli (Rp)
                        </label>

                        <input type="number" name="purchase_price" class="form-control"
                            value="{{ old('purchase_price', $item->purchase_price) }}" min="0">

                    </div>

                </div>

                <!-- BERAT -->
                <div class="row g-3 mt-1">

                    <div class="col-md-6">

                        <label class="form-label fw-medium">
                            Berat / Ukuran
                        </label>

                        <input type="text" name="weight" class="form-control"
                            value="{{ old('weight', $item->weight) }}">

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-medium">
                            Lokasi Simpan
                        </label>

                        <input type="text" name="storage_location" class="form-control"
                            value="{{ old('storage_location', $item->storage_location) }}">

                    </div>

                </div>

                <!-- DESKRIPSI -->
                <div class="mt-3">

                    <label class="form-label fw-medium">
                        Deskripsi
                    </label>

                    <textarea name="description" class="form-control" rows="4">{{ old('description', $item->description) }}</textarea>

                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">

                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary">

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

            reader.onload = function(e) {

                const img = document.getElementById('photo-preview');

                img.src = e.target.result;

                img.classList.remove('d-none');
            };

            reader.readAsDataURL(file);
        }
    </script>
@endpush
