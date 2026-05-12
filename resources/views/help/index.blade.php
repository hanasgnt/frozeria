@extends('layouts.app')
@section('title', 'Bantuan')

@section('content')
    <div class="mb-4">
        <h3 class="fw-bold mb-1" style="color:var(--navy);">
            Panduan Penggunaan Sistem
        </h3>
        <p class="text-muted mb-0" style="font-size:14px;">
            Petunjuk penggunaan sistem stok Frozeria
        </p>
    </div>

    <div class="row g-4 align-items-start">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="help-section mb-5">
                        <h3 class="mb-4">
                            📦 Cara Menambah Barang Baru
                        </h3>
                        <div class="d-flex gap-3 mb-3">
                            <div class="help-num">1</div>
                            <p class="mb-0">Buka halaman <strong>Dashboard</strong>, lalu klik tombol <strong>+ Tambah
                                    Barang</strong> di kanan atas.</p>
                        </div>

                        <div class="d-flex gap-3 mb-3">
                            <div class="help-num">2</div>
                            <p class="mb-0"> Unggah foto barang (opsional), lalu isi formulir: nama, kategori, satuan,
                                jumlah stok, harga, dan informasi lainnya.</p>
                        </div>
                        <div class="d-flex gap-3">
                            <div class="help-num">3</div>
                            <p class="mb-0">Klik <strong>Simpan Barang</strong>. Barang akan otomatis muncul di dashboard.
                            </p>
                        </div>

                    </div>

                    <div class="help-section mb-5">
                        <h3 class="mb-4">
                            🔄 Cara Menambahkan Transaksi Stok
                        </h3>
                        <div class="d-flex gap-3 mb-3">
                            <div class="help-num">1</div>
                            <p class="mb-0">
                                Cari barang melalui dashboard atau menu
                                <strong>Riwayat Stok</strong>.
                            </p>
                        </div>
                        <div class="d-flex gap-3 mb-3">
                            <div class="help-num">2</div>
                            <p class="mb-0">
                                Klik tombol
                                <strong>+ Stok</strong>
                                atau
                                <strong>+ Input Transaksi</strong>.
                            </p>
                        </div>
                        <div class="d-flex gap-3 mb-3">
                            <div class="help-num">3</div>
                            <p class="mb-0">
                                Pilih jenis transaksi
                                (<strong>Barang Masuk</strong>,
                                <strong>Barang Keluar</strong>, dll),
                                lalu isi jumlah barang.
                            </p>
                        </div>
                        <div class="d-flex gap-3">
                            <div class="help-num">4</div>
                            <p class="mb-0">Klik <strong>Simpan Transaksi</strong> untuk memperbarui stok.</p>
                        </div>
                    </div>
                    <div class="help-section">
                        <h3 class="mb-4">
                            🗂 Cara Mengelola Kategori
                        </h3>
                        <div class="d-flex gap-3 mb-3">
                            <div class="help-num">1</div>
                            <p class="mb-0">Buka menu <strong>Kategori</strong> pada navigasi atas.</p>
                        </div>
                        <div class="d-flex gap-3 mb-3">
                            <div class="help-num">2</div>
                            <p class="mb-0">
                                Tambah, edit, atau hapus kategori sesuai kebutuhan.
                            </p>
                        </div>
                        <div class="d-flex gap-3">
                            <div class="help-num">3</div>
                            <p class="mb-0">
                                Menghapus kategori tidak akan menghapus barang,
                                hanya mengosongkan kategorinya.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="help-note">
                ℹ️ Satuan barang dapat disesuaikan seperti
                <strong>pcs</strong>,
                <strong>pack</strong>,
                <strong>box</strong>,
                <strong>kg</strong>,
                <strong>liter</strong>,
                dan lainnya.
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold py-3">
                    🌡 Indikator Stok
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Indikator</th>
                                    <th>Kondisi</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="stok-ok">●</span> Hijau
                                    </td>
                                    <td>Stok ≥ 20</td>
                                    <td>Stok aman</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="stok-menipis">●</span> Oranye
                                    </td>
                                    <td>Stok 1–19</td>
                                    <td>Perlu restock</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="stok-habis">●</span> Merah
                                    </td>
                                    <td>Stok = 0</td>
                                    <td>Stok habis</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- FAQ -->
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white fw-semibold py-3">
                    ❓ FAQ
                </div>

                <div class="card-body">

                    <div class="mb-4">
                        <h6 class="fw-bold mb-2">
                            Apakah bisa upload foto barang?
                        </h6>

                        <p class="text-muted mb-0 small">
                            Ya, format JPG dan PNG diperbolehkan
                            dengan ukuran maksimal 2 MB.
                        </p>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold mb-2">
                            Bagaimana cara menghapus barang?
                        </h6>

                        <p class="text-muted mb-0 small">
                            Klik tombol
                            <strong>Hapus</strong>,
                            lalu konfirmasi pada dialog yang muncul.
                        </p>
                    </div>

                    <div>
                        <h6 class="fw-bold mb-2">
                            Apakah menghapus kategori menghapus barang juga?
                        </h6>

                        <p class="text-muted mb-0 small">
                            Tidak. Barang tetap ada,
                            hanya kategorinya menjadi kosong.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- PROFILE -->
    <div class="profile-box shadow-sm" style="max-width:560px;">

        <h4>
            👤 Informasi
        </h4>

        <div class="row g-3">

            <div class="col-4">
                <div class="small text-light opacity-75">
                    Nama
                </div>
                <div class="fw-semibold">
                    Hana Sugianto
                </div>
            </div>

            <div class="col-4">
                <div class="small text-light opacity-75">
                    NIM
                </div>
                <div class="fw-semibold">
                    2241720102
                </div>
            </div>

            <div class="col-4">
                <div class="small text-light opacity-75">
                    Kelas
                </div>
                <div class="fw-semibold">
                    TI 4E
                </div>
            </div>

        </div>

    </div>

@endsection
