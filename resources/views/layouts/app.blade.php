<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Frozeria Stok — @yield('title', 'Dashboard')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Space+Mono:wght@400;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --navy: #0f1b2d;
            --navy-light: #1a2d45;
            --cyan: #00b4d8;
            --cyan-dark: #0077a8;
            --ice: #e8f4fd;
            --ice-mid: #c5dff4;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        /* ── NAVBAR ── */
        .navbar {
            background: var(--navy) !important;
            min-height: 52px;
        }

        .navbar-brand {
            font-family: 'Space Mono', monospace;
            font-weight: 700;
            font-size: 15px;
            color: #fff !important;
            letter-spacing: -.5px;
        }

        .navbar-brand span {
            color: var(--cyan);
        }

        .nav-link {
            font-size: 13.5px;
            font-weight: 500;
            color: #94a3b8 !important;
            border-radius: 6px;
            padding: 6px 14px !important;
            transition: all .15s;
        }

        .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, .08);
        }

        .nav-link.active {
            color: #fff !important;
            background: rgba(0, 180, 216, .2);
        }

        /* ── STAT CARDS ── */
        .stat-card .stat-label {
            font-size: 11px;
            color: #94a3b8;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .stat-card .stat-value {
            font-size: 32px;
            font-weight: 700;
            font-family: 'Space Mono', monospace;
            color: var(--navy);
        }

        .stat-card.warning .stat-value {
            color: #f97316;
        }

        .stat-card.danger .stat-value {
            color: #ef4444;
        }

        .stat-card.success .stat-value {
            color: #22c55e;
        }

        /* ── TABLE ── */
        .table thead th {
            font-size: 11.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #475569;
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        .table tbody td {
            vertical-align: middle;
            font-size: 13.5px;
        }

        /* ── BADGE kategori ── */
        .badge-kategori {
            background: var(--ice);
            color: var(--cyan-dark);
            font-size: 12px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 999px;
        }

        /* ── STOK STATUS ── */
        .stok-habis {
            color: #ef4444;
            font-weight: 600;
        }

        .stok-menipis {
            color: #f97316;
            font-weight: 600;
        }

        .stok-ok {
            color: #22c55e;
            font-weight: 500;
        }

        /* ── PHOTO THUMB ── */
        .photo-thumb {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 6px;
        }

        .no-photo {
            width: 40px;
            height: 40px;
            background: #f1f5f9;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 18px;
        }

        /* ── UPLOAD AREA ── */
        .photo-upload-area {
            border: 2px dashed #e2e8f0;
            border-radius: 10px;
            padding: 32px;
            text-align: center;
            cursor: pointer;
            background: #f8fafc;
            transition: all .15s;
        }

        .photo-upload-area:hover {
            border-color: var(--cyan);
            background: var(--ice);
        }

        #photo-preview {
            max-width: 200px;
            max-height: 180px;
            border-radius: 8px;
            object-fit: cover;
            margin: 12px auto 0;
            display: block;
        }

        /* ── DETAIL PAGE ── */
        .detail-value {
            font-size: 15px;
            font-weight: 500;
            color: var(--navy);
            padding: 10px 14px;
            background: #f8fafc;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        /* ── HELP PAGE ── */
        .help-section h3 {
            font-size: 14px;
            font-weight: 700;
            color: var(--navy);
            padding-bottom: 8px;
            border-bottom: 2px solid var(--ice-mid);
        }

        .help-num {
            background: var(--cyan);
            color: #fff;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .help-note {
            background: var(--ice);
            border-left: 4px solid var(--cyan);
            border-radius: 6px;
            padding: 12px 16px;
            font-size: 13.5px;
            color: var(--cyan-dark);
        }

        /* ── PROFILE BOX ── */
        .profile-box {
            background: var(--navy);
            color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-top: 32px;
        }

        .profile-box h4 {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--cyan);
            margin-bottom: 16px;
        }

        /* ── MODAL DELETE ── */
        #deleteModal .modal-header {
            border-bottom: none;
        }

        #deleteModal .modal-footer {
            border-top: none;
        }

        /* ── PAGINATION ── */
        .page-link {
            font-size: 13px;
        }

        .page-item.active .page-link {
            background-color: var(--cyan);
            border-color: var(--cyan);
        }

        .page-link:focus {
            box-shadow: 0 0 0 3px rgba(0, 180, 216, .2);
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg sticky-top shadow-sm px-3">
        <div class="container-fluid">

            <!-- Brand -->
            <a class="navbar-brand me-0 me-lg-3" href="{{ route('dashboard') }}">
                <span>Frozeria</span> Stok
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list text-white fs-3"></i>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse mt-3 mt-lg-0" id="mainNav">

                <ul class="navbar-nav ms-auto gap-lg-1">

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="bi bi-grid me-1"></i>
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}"
                            href="{{ route('category.index') }}">
                            <i class="bi bi-tags me-1"></i>
                            Kategori
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('transaction.*') ? 'active' : '' }}"
                            href="{{ route('transaction.index') }}">
                            <i class="bi bi-clock-history me-1"></i>
                            Riwayat Stok
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('help') ? 'active' : '' }}" href="{{ route('help') }}">
                            <i class="bi bi-question-circle me-1"></i>
                            Bantuan
                        </a>
                    </li>

                </ul>

            </div>

        </div>
    </nav>
    <!-- MAIN CONTENT -->
    <main class="container-fluid px-4 py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 border-start border-success border-4"
                role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 border-start border-danger border-4"
                role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- DELETE MODAL -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 shadow-lg"
                style="
                border-radius:18px;
                overflow:hidden;
             ">

                <div class="modal-body p-4">

                    <div class="d-flex align-items-start gap-4">

                        <!-- ICON -->
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0"
                            style="
                            width:78px;
                            height:78px;
                            border-radius:50%;
                            background:#fef2f2;
                         ">

                            <i class="bi bi-trash3-fill"
                                style="
                                font-size:34px;
                                color:#ef4444;
                           "></i>

                        </div>

                        <!-- CONTENT -->
                        <div class="flex-grow-1">

                            <h5 class="fw-bold mb-2" id="deleteModalTitle"
                                style="
                                color:var(--navy);
                                font-size:20px;
                            ">

                                Hapus Barang?

                            </h5>

                            <p class="text-secondary mb-4" id="deleteModalBody"
                                style="
                                font-size:14px;
                                line-height:1.7;
                           ">

                                Data akan dihapus secara permanen dari sistem dan tidak dapat dikembalikan lagi.

                            </p>

                            <!-- ACTION -->
                            <div class="d-flex justify-content-end gap-2">

                                <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">

                                    Batal

                                </button>

                                <form id="deleteForm" method="POST">

                                    @method('DELETE')
                                    @csrf

                                    <button type="submit" class="btn btn-danger px-4 fw-semibold">

                                        <i class="bi bi-trash3 me-1"></i>
                                        Ya, Hapus

                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function openDeleteModal(url, nama, jenis = 'barang') {
            document.getElementById('deleteModalTitle').textContent = `Hapus ${jenis}?`;
            document.getElementById('deleteModalBody').innerHTML =
                `Data <strong>${nama}</strong> akan dihapus secara permanen dari sistem. Tindakan ini tidak dapat dibatalkan.`;
            document.getElementById('deleteForm').action = url;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    </script>

    @stack('scripts')
</body>

</html>
