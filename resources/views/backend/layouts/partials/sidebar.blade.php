<aside class="main-sidebar elevation-0">

    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <div class="brand-box">
            <div class="brand-logo" style="{{ isset($school_logo) ? 'background:none; padding:0;' : '' }}">
                @if(isset($school_logo) && $school_logo)
                    <img src="{{ asset('storage/' . $school_logo) }}" alt="Logo"
                        style="width: 100%; height: 100%; object-fit: contain;">
                @else
                    <i class="fas fa-university"></i>
                @endif
            </div>

            <span class="brand-text font-weight-bold" style="font-size: 16px;">
                {{ Str::limit($school_name ?? 'TataPro', 20) }}
            </span>
        </div>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="overflow-x: hidden;">

        <!-- User Panel -->
        <div class="user-card mt-3 pb-3 mb-3 d-flex align-items-center border-bottom">
            <div class="image pr-2">
                @if(Auth::user()->profile_photo_path)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="img-circle elevation-1"
                        alt="User" style="width: 35px; height: 35px; object-fit: cover;">
                @else
                    <img src="{{ asset('adminlte3/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-1" alt="User"
                        style="width: 35px; height: 35px; object-fit: cover;">
                @endif
            </div>
            <div class="info" style="overflow: hidden; white-space: nowrap;">
                <a href="#" class="d-block font-weight-bold text-dark text-truncate"
                    style="max-width: 160px;">{{ Auth::user()->name }}</a>
                <span class="badge badge-primary px-2 text-truncate"
                    style="max-width: 160px; display: inline-block;">{{ Auth::user()->roles->pluck('name')->first() ?? 'Staff' }}</span>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent shadow-none" data-widget="treeview"
                role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th-large bg-primary-gradient text-white p-1 rounded shadow-sm"
                            style="font-size: 14px; width: 30px; text-align: center;"></i>
                        <p class="ml-1">Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('guide') }}" class="nav-link {{ Request::routeIs('guide') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book-reader bg-warning-gradient text-white p-1 rounded shadow-sm"
                            style="font-size: 14px; width: 30px; text-align: center;"></i>
                        <p class="ml-1">Panduan Sistem</p>
                    </a>
                </li>

                <!-- E-Correspondence -->
                @can('mail-list')
                    <li class="nav-header font-weight-bold text-muted text-uppercase mt-2"
                        style="font-size: 0.8rem; letter-spacing: 0.5px;">Surat Menyurat</li>

                    <li class="nav-item">
                        <a href="{{ route('mail-categories.index') }}"
                            class="nav-link {{ Request::is('correspondence/mail-categories*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tags text-indigo"></i>
                            <p>Klasifikasi Surat</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('incoming.index') }}"
                            class="nav-link {{ Request::is('correspondence/incoming*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-inbox text-success"></i>
                            <p>Surat Masuk</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('outgoing.index') }}"
                            class="nav-link {{ Request::is('correspondence/outgoing*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-paper-plane text-warning"></i>
                            <p>Surat Keluar</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('disposition.index') }}"
                            class="nav-link {{ Request::is('correspondence/disposition*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-random text-info"></i>
                            <p>Disposisi</p>
                        </a>
                    </li>

                    <li class="nav-item {{ Request::is('correspondence/generator*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('correspondence/generator*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-print text-purple"></i>
                            <p>
                                Layanan Cetak
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('generator.index', ['type' => 'student']) }}"
                                    class="nav-link {{ Request::fullUrlIs(route('generator.index', ['type' => 'student'])) ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Surat Ket. Siswa</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('generator.index', ['type' => 'teacher']) }}"
                                    class="nav-link {{ Request::fullUrlIs(route('generator.index', ['type' => 'teacher'])) ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Surat Tugas Guru</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                <!-- Data Management -->
                @if(auth()->user()->can('student-list') || auth()->user()->can('teacher-list'))
                    <li class="nav-header font-weight-bold text-muted text-uppercase mt-2"
                        style="font-size: 0.8rem; letter-spacing: 0.5px;">Data Induk</li>
                @endif

                @can('student-list')
                    <li class="nav-item">
                        <a href="{{ route('students.index') }}"
                            class="nav-link {{ Request::is('correspondence/students*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-graduate text-primary"></i>
                            <p>Data Siswa</p>
                        </a>
                    </li>
                @endcan

                @can('teacher-list')
                    <li class="nav-item">
                        <a href="{{ route('teachers.index') }}"
                            class="nav-link {{ Request::is('correspondence/teachers*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chalkboard-teacher text-danger"></i>
                            <p>Data Guru & Pegawai</p>
                        </a>
                    </li>
                @endcan

                <!-- System -->
                @role('admin')
                <li class="nav-header font-weight-bold text-muted text-uppercase mt-2"
                    style="font-size: 0.8rem; letter-spacing: 0.5px;">Pengaturan</li>

                <li
                    class="nav-item {{ Request::is('admin/settings*') || Request::is('admin/users*') || Request::is('admin/roles*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ Request::is('admin/settings*') || Request::is('admin/users*') || Request::is('admin/roles*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs text-secondary"></i>
                        <p>
                            Sistem & User
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('settings.school') }}"
                                class="nav-link {{ Request::is('admin/settings/school') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Identitas Sekolah</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}"
                                class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manajemen User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}"
                                class="nav-link {{ Request::is('admin/roles*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hak Akses</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole

                <!-- Logout -->
                <li class="nav-item mt-4 pb-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="nav-link btn-danger text-white text-center shadow-none"
                            style="background-color: #dc3545;">
                            <i class="nav-icon fas fa-power-off"></i>
                            <p>KELUAR</p>
                        </a>
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>