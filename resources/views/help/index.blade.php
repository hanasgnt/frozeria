@extends('layouts.app')
@section('title', 'Bantuan')

@section('content')
<div class="page-header">
    <div class="page-title">Panduan Penggunaan Sistem</div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; align-items:start;">
    <div>
        <div class="card" style="margin-bottom:20px;">
            <div class="card-body">
                <div class="help-section">
                    <h3>📦 Cara Menambah Barang Baru</h3>
                    <div class="help-step">
                        <div class="num">1</div>
                        <p>Buka halaman <strong>Dashboard</strong>, klik tombol <strong>+ Tambah Barang</strong> di kanan atas.</p>
                    </div>
                    <div class="help-step">
                        <div class="num">2</div>
                        <p>Unggah foto barang (opsional), lalu isi formulir: nama, kategori, satuan, jumlah stok, harga, dan lainnya.</p>
                    </div>
                    <div class="help-step">
                        <div class="num">3</div>
                        <p>Klik <strong>Simpan Barang</strong>. Barang akan muncul di daftar dashboard.</p>
                    </div>
                </div>
                <div class="help-section">
                    <h3>🔄 Cara Menambahkan Transaksi Stok</h3>
                    <div class="help-step">
                        <div class="num">1</div>
                        <p>
                            Temukan barang melalui <strong>dashboard</strong> menggunakan pencarian atau filter kategori,
                            atau melalui menu <strong>Riwayat Stok</strong> dengan mengklik nama barang yang ingin diproses.
                        </p>
                    </div>
                    <div class="help-step">
                        <div class="num">2</div>
                        <p>
                            Klik tombol <strong>+ Stok</strong> pada dashboard, atau klik <strong>+ Input Transaksi</strong> pada halaman riwayat stok untuk membuka form transaksi.
                        </p>
                    </div>
                    <div class="help-step">
                        <div class="num">3</div>
                        <p>
                            Pilih jenis transaksi (<strong>Barang Masuk</strong>, <strong>Barang Keluar</strong>, dll), lalu masukkan jumlah barang sesuai kebutuhan.
                        </p>
                    </div>
                    <div class="help-step">
                        <div class="num">4</div>
                        <p>
                            Klik tombol <strong>Simpan Transaksi</strong> untuk mencatat perubahan stok.
                        </p>
                    </div>
                </div>
                <div class="help-section" style="margin-bottom:0;">
                    <h3>🗂 Cara Mengelola Kategori</h3>
                    <div class="help-step">
                        <div class="num">1</div>
                        <p>Buka halaman <strong>Kategori</strong> dari navigasi atas.</p>
                    </div>
                    <div class="help-step">
                        <div class="num">2</div>
                        <p>Tambah, edit, atau hapus kategori sesuai kebutuhan.</p>
                    </div>
                    <div class="help-step">
                        <div class="num">3</div>
                        <p>Menghapus kategori tidak akan menghapus barang, hanya mengosongkan kategorinya.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="help-note">
            ℹ️ Satuan barang dapat disesuaikan, seperti <strong>pcs</strong>, <strong>pack</strong>, 
            <strong>box</strong>, <strong>kg</strong>, <strong>liter</strong>, dan lainnya.
        </div>
    </div>
    <div>
        <div class="card">
            <div class="card-header">🌡 Indikator Stok</div>
            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>Indikator</th>
                            <th>Kondisi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="stok-ok">●</span> Hijau</td>
                            <td>Stok ≥ 20</td>
                            <td>Stok aman</td>
                        </tr>
                        <tr>
                            <td><span class="stok-menipis">●</span> Oranye</td>
                            <td>Stok 1–19</td>
                            <td>Stok menipis, perlu restock</td>
                        </tr>
                        <tr>
                            <td><span class="stok-habis">●</span> Merah</td>
                            <td>Stok = 0</td>
                            <td>Stok habis</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- FAQ -->
        <div class="card" style="margin-top:20px;">
            <div class="card-header">❓ FAQ</div>
            <div class="card-body" style="font-size:14px; line-height:1.8; color:var(--gray-600);">
                <p>
                    <strong>Apakah bisa upload foto barang?</strong><br>
                    Ya, format JPG dan PNG diperbolehkan, maksimal 2 MB per file.
                </p>
                <br>
                <p>
                    <strong>Bagaimana cara menghapus barang?</strong><br>
                    Klik tombol <strong>Hapus</strong>, lalu konfirmasi pada dialog yang muncul.
                </p>
                <br>
                <p>
                    <strong>Apakah menghapus kategori menghapus barang juga?</strong><br> 
                    Tidak. Barang tetap ada, hanya kategorinya menjadi kosong.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="profile-box" style="max-width:560px; margin-top:28px;">
    <h4>👤 Informasi </h4>
    <div class="profile-row">
        <span class="key">Nama</span><span class="val">Hana Sugianto</span>
        <span class="key">NIM</span><span class="val">2241720102</span>
        <span class="key">Kelas</span><span class="val">TI 4E</span>
    </div>
</div>
@endsection