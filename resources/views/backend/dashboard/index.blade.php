@extends('backend.layouts.app')

@section('title', 'Dashboard Overview')
@section('title_page', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Ringkasan Sistem</li>
@endsection

@section('content')
    <!-- HERO SECTION -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white border-0 shadow-lg overflow-hidden position-relative"
                style="border-radius: 20px;">
                <div class="card-body p-4 p-md-5 position-relative" style="z-index: 2;">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <div>
                            <h2 class="font-weight-bold mb-1">Halo, {{ Auth::user()->name }}! 👋</h2>
                            <p class="mb-0 opacity-8" style="font-size: 1.1rem;">Selamat datang kembali di TataPro. Berikut
                                adalah ringkasan aktivitas hari ini.</p>
                        </div>
                        <div class="mt-3 mt-md-0 text-md-right bg-white-20 p-2 rounded-lg"
                            style="background: rgba(255,255,255,0.2); backdrop-filter: blur(5px);">
                            <i class="far fa-calendar-alt mr-2"></i>
                            {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                        </div>
                    </div>
                </div>
                <!-- Decorative Circles -->
                <div class="position-absolute"
                    style="top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;">
                </div>
                <div class="position-absolute"
                    style="bottom: -30px; left: 50px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;">
                </div>
            </div>
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <h6 class="text-uppercase text-muted font-weight-bold mb-3 small" style="letter-spacing: 1px;">Akses Cepat</h6>
    <div class="row mb-4">
        @can('mail-list')
        <div class="col-6 col-md-3 mb-3">
            <a href="{{ route('incoming.index') }}"
                class="btn btn-white btn-block shadow-sm py-3 border-0 d-flex flex-column align-items-center justify-content-center quick-action-card">
                <div class="icon-box bg-blue-10 text-primary mb-2">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                <span class="font-weight-bold text-dark">Surat Masuk</span>
            </a>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <a href="{{ route('outgoing.index') }}"
                class="btn btn-white btn-block shadow-sm py-3 border-0 d-flex flex-column align-items-center justify-content-center quick-action-card">
                <div class="icon-box bg-green-10 text-success mb-2">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <span class="font-weight-bold text-dark">Surat Keluar</span>
            </a>
        </div>
        @endcan

        @can('student-create')
        <div class="col-6 col-md-3 mb-3">
            <a href="{{ route('students.create') }}"
                class="btn btn-white btn-block shadow-sm py-3 border-0 d-flex flex-column align-items-center justify-content-center quick-action-card">
                <div class="icon-box bg-purple-10 text-purple mb-2">
                    <i class="fas fa-user-plus"></i>
                </div>
                <span class="font-weight-bold text-dark">Input Siswa</span>
            </a>
        </div>
        @endcan
        
        @can('teacher-list')
         <div class="col-6 col-md-3 mb-3">
            <a href="{{ route('teachers.index') }}"
                class="btn btn-white btn-block shadow-sm py-3 border-0 d-flex flex-column align-items-center justify-content-center quick-action-card">
                <div class="icon-box bg-orange-10 text-orange mb-2">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <span class="font-weight-bold text-dark">Data Guru</span>
            </a>
        </div>
        @endcan
    </div>

    <!-- STATS GRID -->
    <!-- STATS GRID -->
    <h6 class="text-uppercase text-muted font-weight-bold mb-3 small" style="letter-spacing: 1px;">Statistik Data</h6>

    <div class="row">
        <!-- Card 1: Surat Masuk -->
        @can('mail-list')
            <div class="col-lg-3 col-6 mb-4">
                <div class="card border-0 shadow-sm h-100 stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="icon-circle bg-primary-light text-primary">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <span class="badge badge-light-primary text-primary px-2">Total</span>
                        </div>
                        <h2 class="font-weight-bold text-dark mb-1">{{ $stats['incoming_mail'] }}</h2>
                        <p class="text-muted small mb-0">Surat Masuk</p>
                    </div>
                </div>
            </div>
        @endcan

        <!-- Card 2: Surat Keluar -->
        @can('mail-list')
            <div class="col-lg-3 col-6 mb-4">
                <div class="card border-0 shadow-sm h-100 stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="icon-circle bg-success-light text-success">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <span class="badge badge-light-success text-success px-2">Total</span>
                        </div>
                        <h2 class="font-weight-bold text-dark mb-1">{{ $stats['outgoing_mail'] }}</h2>
                        <p class="text-muted small mb-0">Surat Keluar</p>
                    </div>
                </div>
            </div>
        @endcan

        <!-- Card 3: Siswa -->
        @can('student-list')
            <div class="col-lg-3 col-6 mb-4">
                <div class="card border-0 shadow-sm h-100 stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="icon-circle bg-info-light text-info">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <span class="badge badge-light-info text-info px-2">Aktif</span>
                        </div>
                        <h2 class="font-weight-bold text-dark mb-1">{{ $stats['students'] }}</h2>
                        <p class="text-muted small mb-0">Total Siswa</p>
                    </div>
                </div>
            </div>
        @endcan

        <!-- Card 4: Guru -->
        @can('teacher-list')
            <div class="col-lg-3 col-6 mb-4">
                <div class="card border-0 shadow-sm h-100 stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="icon-circle bg-warning-light text-warning">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <span class="badge badge-light-warning text-warning px-2">Staf</span>
                        </div>
                        <h2 class="font-weight-bold text-dark mb-1">{{ $stats['teachers'] }}</h2>
                        <p class="text-muted small mb-0">Guru & Karyawan</p>
                    </div>
                </div>
            </div>
        @endcan
    </div>

@endsection

@push('css')
    <style>
        /* Custom Utilities */
        .bg-white-20 {
            background: rgba(255, 255, 255, 0.2);
        }

        .quick-action-card {
            border-radius: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .quick-action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05) !important;
        }

        .icon-box {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .bg-blue-10 {
            background: #eff6ff;
        }

        .bg-green-10 {
            background: #f0fdf4;
        }

        .bg-purple-10 {
            background: #faf5ff;
        }

        .bg-orange-10 {
            background: #fff7ed;
        }

        .text-purple {
            color: #9333ea;
        }

        .text-orange {
            color: #ea580c;
        }

        /* Stat Cards */
        .stat-card {
            border-radius: 16px;
            transition: all 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05) !important;
        }

        .icon-circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .bg-primary-light {
            background: #eff6ff;
        }

        .bg-success-light {
            background: #f0fdf4;
        }

        .bg-info-light {
            background: #ecfeff;
        }

        .bg-warning-light {
            background: #fffbeb;
        }

        .badge-light-primary {
            background: #eff6ff;
            color: #3b82f6;
        }

        .badge-light-success {
            background: #f0fdf4;
            color: #22c55e;
        }

        @media (max-width: 576px) {
            .icon-box {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }
        }
    </style>
@endpush