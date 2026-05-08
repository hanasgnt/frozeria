@extends('layouts.app')
@section('title', 'Kategori')

@section('content')
<div class="page-header">
    <div class="page-title">Daftar Kategori</div>
    <a href="{{ route('category.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
</div>

<div class="card">
    <div class="card-body" style="padding-bottom:0">
        <form method="GET" style="margin-bottom:16px;">
            <input type="text" name="search" placeholder="Cari kategori..." value="{{ request('search') }}" style="max-width:320px;">
        </form>

        <table>
            <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th>Jumlah Barang</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td style="font-weight:500;">{{ $cat->name }}</td>
                    <td>
                        <span class="badge">{{ $cat->items_count }} barang</span>
                    </td>
                    <td style="color:var(--gray-400); font-size:13px;">{{ $cat->created_at->format('j M Y') }}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('category.edit', $cat) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm" onclick="openDeleteModal('{{ route('category.destroy', $cat) }}', '{{ addslashes($cat->name) }}', 'category')">Hapus</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <div class="icon">🗂</div>
                            <p>Belum ada kategori.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:14px 20px; border-top:1px solid var(--gray-100); font-size:13px; color:var(--gray-400);">
        {{ $categories->count() }} kategori terdaftar
    </div>
</div>
@endsection
