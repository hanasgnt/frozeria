@extends('layouts.app')
@section('title', 'Kategori')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-0" style="color:var(--navy);">
                Daftar Kategori
            </h3>
            <small class="text-muted">
                Kelola kategori barang Frozeria
            </small>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal"><i
                class="bi bi-plus-lg me-1"></i>Tambah Kategori</button>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body pb-0">
            <form method="GET" class="mb-3 w-100">
                <div class="input-group w-100">
                    <input type="text" name="search" class="form-control"
                        placeholder="Cari kategori..."value="{{ request('search') }}" style="font-size:13.5px;">
                    <button class="btn btn-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>

            </form>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Barang</th>
                            <th>Dibuat</th>
                            <th style="width:160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                            <tr>
                                <td class="fw-medium">
                                    {{ $cat->name }}
                                </td>
                                <td>
                                    <span class="text-muted" style="font-size:13px;">
                                        {{ $cat->description ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-kategori">
                                        {{ $cat->items_count }} barang
                                    </span>
                                </td>
                                <td class="text-muted" style="font-size:13px;">
                                    {{ $cat->created_at->format('j M Y') }}
                                </td>
                                <td>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <button class="btn btn-secondary btn-sm"
                                            data-bs-toggle="modal"data-bs-target="#editCategoryModal{{ $cat->id }}">Edit</button>
                                        <button class="btn btn-danger btn-sm"
                                            onclick="openDeleteModal(
                                        '{{ route('category.destroy', $cat) }}',
                                        '{{ addslashes($cat->name) }}',
                                        'kategori'
                                    )">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="editCategoryModal{{ $cat->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg" style="border-radius:16px;">
                                        <form action="{{ route('category.update', $cat) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header border-0 pb-0">
                                                <div>
                                                    <h5 class="modal-title fw-bold" style="color:var(--navy);">
                                                        Edit Kategori
                                                    </h5>
                                                    <small class="text-muted">
                                                        Ubah informasi kategori
                                                    </small>
                                                </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body pt-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-medium">
                                                        Nama Kategori
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="name"
                                                        class="form-control"value="{{ old('name', $cat->name) }}" required>
                                                </div>
                                                <div>
                                                    <label class="form-label fw-medium">
                                                        Deskripsi
                                                        <span class="text-muted">(opsional)</span>
                                                    </label>
                                                    <textarea name="description" rows="4" class="form-control">{{ old('description', $cat->description) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    Simpan Perubahan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="text-center py-5 text-muted">
                                        <div style="font-size:52px;">
                                            🗂
                                        </div>
                                        <p class="mt-3 mb-0">
                                            Belum ada kategori.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top"
            style="font-size:13px; color:#64748b;">
            <span>
                {{ $categories->count() }} kategori terdaftar
            </span>
        </div>
    </div>
    <div class="modal fade" id="createCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius:16px;">
                <form action="{{ route('category.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0 pb-0">
                        <div>
                            <h5 class="modal-title fw-bold" style="color:var(--navy);">
                                Tambah Kategori
                            </h5>
                            <small class="text-muted">
                                Tambahkan kategori baru
                            </small>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body pt-3">
                        <div class="mb-3">
                            <label class="form-label fw-medium">
                                Nama Kategori
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                placeholder="Contoh: Ayam" required>
                        </div>
                        <div>
                            <label class="form-label fw-medium">
                                Deskripsi
                                <span class="text-muted">(opsional)</span>
                            </label>
                            <textarea name="description" rows="4" class="form-control" placeholder="Produk berbahan dasar ayam beku...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
