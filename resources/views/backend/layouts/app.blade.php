<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Dashboard') | {{ $school_name ?? 'TataPro' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(isset($school_logo) && $school_logo)
        <link rel="icon" href="{{ asset('storage/' . $school_logo) }}" type="image/png">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @endif

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- ADMIN LTE -->
    <link rel="stylesheet" href="{{ asset('adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte3/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --primary: #2563eb;
            --sidebar: #0f172a;
            --bg: #f6f8fb;
            --card: #ffffff;
        }

        /* ================= GLOBAL ================= */

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            font-size: 14.5px;
            -webkit-font-smoothing: antialiased;
        }

        .wrapper {
            overflow-x: hidden;
        }

        /* 🔥 JANGAN kasih padding ke content-wrapper */
        .content-wrapper {
            background: var(--bg);
        }

        /* padding pindah ke sini */
        .content {
            padding: 20px;
        }

        /* prevent layout glitch */
        .main-header {
            z-index: 1040;
        }

        .main-sidebar {
            z-index: 1038;
        }

        /* ================= SIDEBAR ================= */

        .main-sidebar {
            background: linear-gradient(180deg, #0f172a, #020617) !important;
            border-right: 1px solid rgba(255, 255, 255, .05);
        }

        .brand-link {
            border-bottom: 1px solid rgba(255, 255, 255, .05) !important;
            padding: 20px 24px;
        }

        .brand-box {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo {
            width: 32px;
            height: 32px;
            background: var(--primary);
            color: #fff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .brand-text {
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .brand-text span {
            color: var(--primary);
        }

        /* User Card */
        /* User Card (Sidebar) */
        .user-card {
            background: rgba(255, 255, 255, .03);
            border: 1px solid rgba(255, 255, 255, .05);
            margin: 16px 10px;
            padding: 12px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-card img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, .1);
        }

        .user-card .user-name {
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            line-height: 1.2;
        }

        .user-card .user-role {
            color: #94a3b8;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 2px;
        }

        /* User Pill (Navbar) */
        .user-pill {
            display: flex;
            align-items: center;
            padding: 6px 12px !important;
            border-radius: 999px;
            transition: .2s;
            margin-right: 10px;
        }

        .user-pill:hover {
            background: #f1f5f9 !important;
        }

        .user-pill .user-name {
            color: #1e293b;
            font-weight: 600;
            font-size: 13.5px;
            line-height: 1.2;
        }

        .user-pill small {
            font-size: 11px;
            display: block;
        }

        .navbar-light .navbar-nav .nav-link {
            color: #64748b;
        }

        .nav-icon {
            font-size: 20px;
            padding: 0 12px;
        }

        .nav-sidebar .nav-link {
            color: #cbd5e1 !important;
            border-radius: 10px;
            margin: 4px 10px;
            padding: 10px 14px;
            font-weight: 500;
            transition: .2s;
        }

        .nav-sidebar .nav-link:hover {
            background: rgba(255, 255, 255, .06);
            color: #fff !important;
        }

        .nav-sidebar .nav-link.active {
            background: var(--primary) !important;
            color: #fff !important;
            box-shadow: 0 8px 20px rgba(37, 99, 235, .35);
        }

        .nav-header {
            color: #64748b !important;
            font-size: .68rem;
            letter-spacing: .12em;
            font-weight: 700;
            margin-top: 22px;
        }

        /* ================= NAVBAR ================= */

        .main-header {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, .85) !important;
            border-bottom: 1px solid #e2e8f0;
        }

        /* jangan paksa height navbar */
        /* adminlte sudah handle */

        .academic-pill {
            background: #eef2ff;
            color: var(--primary);
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* ================= CARD ================= */

        .card {
            border: none;
            border-radius: 16px;
            background: var(--card);
            box-shadow:
                0 1px 2px rgba(0, 0, 0, .04),
                0 8px 24px rgba(0, 0, 0, .04);
            transition: .2s;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        /* ================= TITLE ================= */

        .content-header h1 {
            font-weight: 800;
            letter-spacing: -.03em;
        }

        /* ================= BREADCRUMB ================= */

        .breadcrumb {
            background: none;
            font-size: 13px;
        }

        .breadcrumb a {
            color: var(--primary);
            font-weight: 500;
        }

        /* ================= ALERT ================= */

        .alert {
            border: none;
            border-radius: 12px;
        }

        /* ================= FOOTER ================= */

        .footer-modern {
            background: #fff;
            border-top: 1px solid #e5e7eb;
            padding: 14px 18px;
            font-size: 14px;
        }

        .version-pill {
            background: #eef2ff;
            color: var(--primary);
            padding: 4px 10px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 12px;
        }

        /* ================= SCROLL ================= */

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* ================= MOBILE ================= */

        @media(max-width:991px) {

            .content {
                padding: 16px;
            }

            .main-sidebar {
                box-shadow: 0 0 30px rgba(0, 0, 0, .35);
            }
        }

        @media(max-width:768px) {

            .content-header h1 {
                font-size: 21px;
            }

            .nav-sidebar .nav-link {
                padding: 12px 16px;
                font-size: 15px;
            }
        }
    </style>

    @stack('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

    <div class="wrapper">

        @include('backend.layouts.partials.navbar')
        @include('backend.layouts.partials.sidebar')

        <div class="content-wrapper">

            <!-- HEADER -->
            <section class="content-header">
                <div class="container-fluid">

                    <div class="row mb-3 align-items-center">

                        <div class="col-md-6 col-12 mb-2 mb-md-0">
                            <h1>@yield('title_page')</h1>
                            <small class="text-muted">
                                Manajemen administrasi sistem TataPro
                            </small>
                        </div>

                        <div class="col-md-6 col-12">
                            <ol class="breadcrumb float-md-right">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/admin/dashboard') }}">Home</a>
                                </li>
                                @yield('breadcrumb')
                            </ol>
                        </div>

                    </div>
                </div>
            </section>

            <!-- CONTENT -->
            <section class="content">
                <div class="container-fluid">

                    @if(session('success'))
                        <div class="alert alert-success shadow-sm">
                            <i class="fas fa-check-circle mr-1"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger shadow-sm">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger shadow-sm">
                            <ul class="mb-0 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')

                </div>
            </section>

        </div>

        @include('backend.layouts.partials.footer')

    </div>

    <!-- SCRIPTS -->
    <script src="{{ asset('adminlte3/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte3/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('adminlte3/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        $(function () {

            $('[data-toggle="tooltip"]').tooltip();

            setTimeout(() => {
                $(".alert").fadeOut('slow');
            }, 5000);

            $('.btn-delete').on('click', function (e) {

                e.preventDefault();

                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2563eb',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });

            });

        });

    </script>

    @stack('js')

</body>

</html>