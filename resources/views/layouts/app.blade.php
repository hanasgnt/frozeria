<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Frozeria Stok — @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy: #0f1b2d;
            --navy-light: #1a2d45;
            --ice: #e8f4fd;
            --ice-mid: #c5dff4;
            --cyan: #00b4d8;
            --cyan-dark: #0077a8;
            --white: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-400: #94a3b8;
            --gray-600: #475569;
            --gray-800: #1e293b;
            --red: #ef4444;
            --red-light: #fef2f2;
            --orange: #f97316;
            --orange-light: #fff7ed;
            --green: #22c55e;
            --green-light: #f0fdf4;
            --shadow-sm: 0 1px 3px rgba(0,0,0,.08);
            --shadow: 0 4px 16px rgba(0,0,0,.1);
            --shadow-lg: 0 8px 32px rgba(0,0,0,.15);
            --radius: 10px;
            --radius-sm: 6px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            min-height: 100vh;
        }

        th:nth-child(1), td:nth-child(1) { width: 5%; }
        th:nth-child(2), td:nth-child(2) { width: 25%; }
        th:nth-child(3), td:nth-child(3) { width: 15%; }
        th:nth-child(4), td:nth-child(4) { width: 10%; }
        th:nth-child(5), td:nth-child(5) { width: 10%; }
        th:nth-child(6), td:nth-child(6) { width: 15%; }
        th:nth-child(7), td:nth-child(7) { width: 20%; }

        table {
            table-layout: fixed;
            width: 100%;
        }

        /* NAV */
        nav {
            background: var(--navy);
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 24px;
            height: 52px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 12px rgba(0,0,0,.3);
        }
        .nav-brand {
            font-family: 'Space Mono', monospace;
            font-weight: 700;
            font-size: 15px;
            color: var(--white);
            letter-spacing: -0.5px;
            margin-right: 12px;
        }
        .nav-brand span { color: var(--cyan); }
        .nav-link {
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--gray-400);
            text-decoration: none;
            transition: all .15s;
        }
        .nav-link:hover { color: var(--white); background: rgba(255,255,255,.08); }
        .nav-link.active { color: var(--white); background: rgba(0,180,216,.2); }

        /* MAIN max-width: 1280px;*/
        main { margin: 0 auto; padding: 28px 24px; }

        /* CARDS */
        .card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-200);
        }
        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--gray-200);
            font-weight: 600;
            font-size: 15px;
        }
        .card-body { padding: 20px; }

        /* STAT CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }
        @media (max-width: 900px) { .stats-grid { grid-template-columns: repeat(2,1fr); } }
        .stat-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 18px 20px;
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
        }
        .stat-label { font-size: 12px; color: var(--gray-400); font-weight: 500; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px; }
        .stat-value { font-size: 32px; font-weight: 700; font-family: 'Space Mono', monospace; color: var(--navy); }
        .stat-card.warning .stat-value { color: var(--orange); }
        .stat-card.danger .stat-value { color: var(--red); }
        .stat-card.success .stat-value { color: var(--green); }

        /* TABLE */
        table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
        thead th {
            background: var(--gray-50);
            padding: 10px 14px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--gray-600);
            border-bottom: 2px solid var(--gray-200);
        }
        tbody tr { border-bottom: 1px solid var(--gray-100); transition: background .1s; }
        tbody tr:hover { background: var(--gray-50); }
        tbody td { padding: 12px 14px; vertical-align: middle; }

        /* BADGE */
        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            background: var(--ice);
            color: var(--cyan-dark);
        }

        /* BUTTONS */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all .15s;
            font-family: inherit;
        }
        .btn-primary { background: var(--cyan); color: var(--white); }
        .btn-primary:hover { background: var(--cyan-dark); }
        .btn-secondary { background: var(--gray-100); color: var(--gray-800); border: 1px solid var(--gray-200); }
        .btn-secondary:hover { background: var(--gray-200); }
        .btn-danger { background: var(--red); color: var(--white); }
        .btn-danger:hover { background: #dc2626; }
        .btn-outline { background: transparent; color: var(--cyan-dark); border: 1px solid var(--cyan); }
        .btn-outline:hover { background: var(--ice); }
        .btn-sm { padding: 5px 12px; font-size: 12.5px; }

        /* FORM */
        .form-group { margin-bottom: 18px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        label { display: block; font-size: 13px; font-weight: 500; color: var(--gray-600); margin-bottom: 6px; }
        input[type=text], input[type=number], select, textarea {
            width: 100%;
            padding: 9px 13px;
            border: 1.5px solid var(--gray-200);
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-family: inherit;
            color: var(--gray-800);
            background: var(--white);
            transition: border-color .15s;
            outline: none;
        }
        input:focus, select:focus, textarea:focus { border-color: var(--cyan); box-shadow: 0 0 0 3px rgba(0,180,216,.1); }
        textarea { resize: vertical; min-height: 90px; }
        .form-error { color: var(--red); font-size: 12px; margin-top: 4px; }

        /* SEARCH BAR */
        .toolbar {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }
        .search-wrap { position: relative; flex: 1; min-width: 220px; }
        .search-wrap input {
            padding-left: 38px;
        }
        .search-wrap .icon-search {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            color: var(--gray-400); font-size: 15px; pointer-events: none;
        }

        /* PAGE HEADER */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            gap: 12px;
        }
        .page-title { font-size: 20px; font-weight: 700; color: var(--navy); }
        .breadcrumb { font-size: 13px; color: var(--gray-400); margin-top: 2px; }
        .breadcrumb a { color: var(--cyan-dark); text-decoration: none; }

        /* ALERT */
        .alert {
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            margin-bottom: 18px;
        }
        .alert-success { background: var(--green-light); color: #166534; border-left: 4px solid var(--green); }
        .alert-danger { background: var(--red-light); color: #991b1b; border-left: 4px solid var(--red); }

        /* MODAL */
        .modal-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(15,27,45,.6);
            backdrop-filter: blur(3px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.show { display: flex; }
        .modal-box {
            background: var(--white);
            border-radius: 14px;
            padding: 32px 28px;
            max-width: 420px;
            width: 90%;
            box-shadow: var(--shadow-lg);
            animation: popIn .2s ease;
        }
        @keyframes popIn { from { transform: scale(.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        .modal-icon { font-size: 32px; margin-bottom: 12px; }
        .modal-title { font-size: 18px; font-weight: 700; margin-bottom: 8px; color: var(--navy); }
        .modal-body { font-size: 14px; color: var(--gray-600); line-height: 1.6; margin-bottom: 24px; }
        .modal-actions { display: flex; justify-content: flex-end; gap: 10px; }

        /* FOTO UPLOAD */
        .photo-upload-area {
            border: 2px dashed var(--gray-200);
            border-radius: var(--radius);
            padding: 32px;
            text-align: center;
            cursor: pointer;
            transition: all .15s;
            background: var(--gray-50);
        }
        .photo-upload-area:hover { border-color: var(--cyan); background: var(--ice); }
        .photo-upload-area .upload-icon { font-size: 36px; color: var(--gray-400); margin-bottom: 8px; }
        .photo-upload-area p { font-size: 13px; color: var(--gray-600); }
        .photo-upload-area .hint { font-size: 12px; color: var(--gray-400); margin-top: 4px; }
        #photo-preview { max-width: 200px; max-height: 180px; border-radius: 8px; object-fit: cover; margin: 12px auto 0; display: block; }

        /* DETAIL PAGE */
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .detail-field { }
        .detail-field label { font-size: 11.5px; color: var(--gray-400); text-transform: uppercase; letter-spacing: .5px; font-weight: 600; margin-bottom: 4px; }
        .detail-field .value { font-size: 15px; font-weight: 500; color: var(--navy); padding: 10px 14px; background: var(--gray-50); border-radius: var(--radius-sm); border: 1px solid var(--gray-200); }
        .detail-full { grid-column: 1 / -1; }

        /* PAGINATION */
        .pagination-wrap { display: flex; justify-content: space-between; align-items: center; padding: 14px 20px; border-top: 1px solid var(--gray-100); font-size: 13px; color: var(--gray-600); }

        /* HELP PAGE */
        .help-section { margin-bottom: 28px; }
        .help-section h3 { font-size: 14px; font-weight: 700; color: var(--navy); margin-bottom: 12px; padding-bottom: 8px; border-bottom: 2px solid var(--ice-mid); }
        .help-step { display: flex; gap: 12px; align-items: flex-start; margin-bottom: 10px; }
        .help-step .num { background: var(--cyan); color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0; margin-top: 1px; }
        .help-step p { font-size: 14px; color: var(--gray-600); line-height: 1.5; }
        .help-note { background: var(--ice); border-left: 4px solid var(--cyan); padding: 12px 16px; border-radius: var(--radius-sm); font-size: 13.5px; color: var(--cyan-dark); margin-top: 12px; }

        .stok-habis { color: var(--red); font-weight: 600; }
        .stok-menipis { color: var(--orange); font-weight: 600; }
        .stok-ok { color: var(--green); }

        .empty-state { text-align: center; padding: 48px; color: var(--gray-400); }
        .empty-state .icon { font-size: 48px; margin-bottom: 12px; }

        .photo-thumb { width: 40px; height: 40px; object-fit: cover; border-radius: 6px; }
        .no-photo { width: 40px; height: 40px; background: var(--gray-100); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: var(--gray-400); font-size: 18px; }

        select { cursor: pointer; }

        .profile-box { background: var(--navy); color: white; border-radius: var(--radius); padding: 20px; margin-top: 32px; }
        .profile-box h4 { font-size: 13px; text-transform: uppercase; letter-spacing: 1px; color: var(--cyan); margin-bottom: 16px; }
        .profile-row { display: grid; grid-template-columns: 140px 1fr; gap: 4px 8px; font-size: 14px; line-height: 1.8; }
        .profile-row .key { color: var(--gray-400); }
        .profile-row .val { color: white; font-weight: 500; }
    </style>
    @stack('styles')
</head>
<body>
<nav>
    <span class="nav-brand"><span>Frozeria</span> Stok</span>
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
    <a href="{{ route('category.index') }}" class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}">Kategori</a>
    <a href="{{ route('transaction.index') }}" class="nav-link {{ request()->routeIs('transaction.*') ? 'active' : '' }}">Riwayat Stok</a>
    <a href="{{ route('help') }}" class="nav-link {{ request()->routeIs('help') ? 'active' : '' }}">Bantuan</a>
</nav>

<main>
    @if(session('success'))
        <div class="alert alert-success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">⚠ {{ session('error') }}</div>
    @endif

    @yield('content')
</main>

<!-- DELETE MODAL -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-icon">⚠️</div>
        <div class="modal-title">Hapus barang?</div>
        <div class="modal-body" id="deleteModalBody">Data akan dihapus secara permanen dari sistem. Tindakan ini tidak dapat dibatalkan.</div>
        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="closeDeleteModal()">Batal</button>
            <form id="deleteForm" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteModal(url, nama, jenis = 'barang') {
    document.getElementById('deleteModalBody').innerHTML =
        `Data <strong>${nama}</strong> akan dihapus secara permanen dari sistem. Tindakan ini tidak dapat dibatalkan.`;
    document.querySelector('.modal-title').textContent = `Hapus ${jenis}?`;
    document.getElementById('deleteForm').action = url;
    document.getElementById('deleteModal').classList.add('show');
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('show');
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>

@stack('scripts')
</body>
</html>
