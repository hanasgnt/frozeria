@extends('layouts.app')
@section('title', 'Edit Kategori')

@section('content')
<div class="page-header">
    <div>
        <div style="font-size:13px; margin-bottom:6px;">
            <a href="{{ route('category.index') }}" style="color:var(--cyan-dark); text-decoration:none;">‹ Kembali</a>
        </div>
        <div class="page-title">Edit Kategori</div>
    </div>
</div>

<div class="card" style="max-width:560px;">
    <div class="card-body">
        <form action="{{ route('category.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
            <div class="form-group">
                <label>Nama Kategori <span style="color:var(--red)">*</span></label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
                @error('name')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label>Deskripsi (opsional)</label>
                <textarea name="description">{{ old('description', $category->description) }}</textarea>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <a href="{{ route('category.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>
@endsection
