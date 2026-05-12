@extends('layouts.app')
@section('title', 'Tambah Kategori')

@section('content')
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <div class="small mb-2">
                <a href="{{ route('category.index') }}" class="text-decoration-none"
                    style="color:var(--cyan-dark);">‹Kembali</a>
            </div>
            <h3 class="fw-bold mb-0" style="color:var(--navy);">Tambah Kategori</h3>
        </div>
    </div>
    <div class="card border-0 shadow-sm" style="max-width:560px;">
        <div class="card-body p-4">

            <form action="{{ route('category.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-medium"> Nama Kategori
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                        placeholder="Contoh: Ayam" required>
                    @error('name')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="form-label fw-medium"> Deskripsi
                        <span class="text-muted">(opsional)</span>
                    </label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Produk berbahan dasar ayam beku...">{{ old('description') }}</textarea>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('category.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
@endsection
