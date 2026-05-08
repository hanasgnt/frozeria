@extends('layouts.app')
@section('title', 'Edit Barang')

@section('content')
<div class="page-header">
    <div>
        <div style="font-size:13px; margin-bottom:6px;">
            <a href="{{ route('dashboard') }}" style="color:var(--cyan-dark); text-decoration:none;">‹ Kembali</a>
        </div>
        <div class="page-title">Edit Barang</div>
    </div>
</div>

<form action="{{ route('item.update', $item) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="card" style="max-width:820px;">
    <div class="card-header">Foto Barang</div>
    <div class="card-body">
        <div class="foto-upload-area" onclick="document.getElementById('foto').click()">
            <div class="upload-icon">🖼</div>
            @if($item->photo)
                <img id="foto-preview" src="{{ asset('storage/'.$item->photo) }}" style="max-width:200px; max-height:180px; border-radius:8px; object-fit:cover; margin:8px auto 0; display:block;">
            @else
                <img id="foto-preview" style="display:none;">
            @endif
            <p style="margin-top:8px;">Klik untuk mengganti foto, atau seret file ke sini</p>
            <p class="hint">Format: JPG, PNG — Maks. 2 MB</p>
            <button type="button" class="btn btn-secondary btn-sm" style="margin-top:12px;" onclick="event.stopPropagation(); document.getElementById('foto').click()">Pilih Foto</button>
        </div>
        <input type="file" id="foto" name="foto" accept="image/jpg,image/jpeg,image/png" style="display:none;" onchange="previewFoto(this)">
    </div>

    <div class="card-header" style="border-top:1px solid var(--gray-200);">Informasi Barang</div>
    <div class="card-body">
        <div class="form-group">
            <label>Nama Barang <span style="color:var(--red)">*</span></label>
            <input type="text" name="name" value="{{ old('name', $item->name) }}" required>
            @error('name')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Kategori</label>
                <select name="category_id">
                    <option value="">Pilih kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $item->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Satuan <span style="color:var(--red)">*</span></label>
                <input type="text" name="unit" value="{{ old('unit', $item->unit) }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Jumlah Stok <span style="color:var(--red)">*</span></label>
                <input type="number" name="stock" value="{{ old('stock', $item->stock) }}" min="0" required>
            </div>
            <div class="form-group">
                <label>Stok Minimum</label>
                <input type="number" name="minimum_stock" value="{{ old('minimum_stock', $item->minimum_stock) }}" min="0">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Harga Jual (Rp)</label>
                <input type="number" name="selling_price" value="{{ old('selling_price', $item->selling_price) }}" min="0">
            </div>
            <div class="form-group">
                <label>Harga Beli (Rp)</label>
                <input type="number" name="purchase_price" value="{{ old('purchase_price', $item->purchase_price) }}" min="0">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Berat / Ukuran</label>
                <input type="text" name="weight" value="{{ old('weight', $item->weight) }}">
            </div>
            <div class="form-group">
                <label>Lokasi Simpan</label>
                <input type="text" name="storage_location" value="{{ old('storage_location', $item->storage_location) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description">{{ old('description', $item->description) }}</textarea>
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
        const img = document.getElementById('foto-preview');
        img.src = e.target.result;
        img.style.display = 'block';
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
