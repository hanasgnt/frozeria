@extends('layouts.app')
@section('title', 'Tambah Barang')

@section('content')
<div class="page-header">
    <div>
        <div style="font-size:13px; margin-bottom:6px;">
            <a href="{{ route('dashboard') }}" style="color:var(--cyan-dark); text-decoration:none;">‹ Kembali</a>
        </div>
        <div class="page-title">Tambah Barang Baru</div>
    </div>
</div>

<form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="card" style="max-width:820px;">
    <div class="card-header">Foto Barang</div>
    <div class="card-body">
        <div class="foto-upload-area" onclick="document.getElementById('photo').click()">
            <div class="upload-icon">🖼</div>
            <p>Klik untuk memilih foto, atau seret file ke sini</p>
            <p class="hint">Format: JPG, PNG — Maks. 2 MB</p>
            <button type="button" class="btn btn-secondary btn-sm" style="margin-top:12px;" onclick="event.stopPropagation(); document.getElementById('photo').click()">Pilih Foto</button>
            <img id="photo-preview" style="display:none;">
        </div>
        <input type="file" id="photo" name="photo" accept="image/jpg,image/jpeg,image/png" style="display:none;" onchange="previewFoto(this)">
        @error('photo')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="card-header" style="border-top:1px solid var(--gray-200);">Informasi Barang</div>
    <div class="card-body">
        <div class="form-group">
            <label>Nama Barang <span style="color:var(--red)">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Ayam nugget crispy">
            @error('name')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Kategori <span style="color:var(--red)">*</span></label>
                <select name="category_id">
                    <option value="">Pilih kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label>Satuan <span style="color:var(--red)">*</span></label>
                <input type="text" name="unit" value="{{ old('unit', 'pcs') }}" placeholder="pcs, pack, kg, box...">
                @error('unit')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Jumlah Stok <span style="color:var(--red)">*</span></label>
                <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0">
                @error('stock')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label>Stok Minimum</label>
                <input type="number" name="minimum_stock" value="{{ old('minimum_stock', 0) }}" min="0">
                @error('minimum_stock')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Harga Jual (Rp)</label>
                <input type="number" name="selling_price" value="{{ old('selling_price') }}" min="0" placeholder="35000">
                @error('selling_price')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label>Harga Beli (Rp)</label>
                <input type="number" name="purchase_price" value="{{ old('purchase_price') }}" min="0" placeholder="28000">
                @error('purchase_price')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Berat / Ukuran</label>
                <input type="text" name="weight" value="{{ old('weight') }}" placeholder="500 gram">
            </div>
            <div class="form-group">
                <label>Lokasi Simpan</label>
                <input type="text" name="storage_location" value="{{ old('storage_location') }}" placeholder="Rak A-3">
            </div>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" placeholder="Deskripsi singkat tentang produk ini...">{{ old('description') }}</textarea>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:8px;">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Barang</button>
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
    reader.onload = e => {
        const img = document.getElementById('photo-preview');
        img.src = e.target.result;
        img.style.display = 'block';
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
