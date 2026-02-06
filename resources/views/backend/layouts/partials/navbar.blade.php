<nav class="main-header navbar navbar-expand navbar-white navbar-light border-0">

    <!-- LEFT -->
    <ul class="navbar-nav align-items-center">

        <!-- Burger -->
        <li class="nav-item">
            <a class="nav-link text-dark" data-widget="pushmenu" href="#">
                <i class="fas fa-bars"></i>
            </a>
        </li>

        <!-- Academic Year (Hidden on small phones) -->
        <li class="nav-item d-none d-md-block ml-2">
            <div class="academic-pill">
                <i class="far fa-calendar-alt mr-1"></i>
                Tahun Ajaran:
                <span class="font-weight-bold">
                    {{ date('Y') }}/{{ date('Y')+1 }}
                </span>
            </div>
        </li>

    </ul>


    <!-- RIGHT -->
    <ul class="navbar-nav ml-auto align-items-center">

        <!-- SEARCH (desktop only) -->
        <li class="nav-item d-none d-lg-block">
            <a class="nav-link" data-widget="navbar-search" href="#">
                <i class="fas fa-search"></i>
            </a>
        </li>


        <!-- NOTIFICATION -->
        <li class="nav-item dropdown">
            <a class="nav-link nav-icon" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow border-0">

                <span class="dropdown-header font-weight-bold">
                    3 Notifikasi
                </span>

                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2 text-primary"></i>
                    Surat masuk baru
                    <span class="float-right text-muted text-xs">
                        5 menit
                    </span>
                </a>

                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-footer font-weight-bold text-primary">
                    Lihat Semua
                </a>
            </div>
        </li>


        <!-- USER -->
        <li class="nav-item dropdown ml-2">

            <a class="nav-link user-pill" data-toggle="dropdown" href="#">

                <img src="{{ asset('adminlte3/dist/img/user2-160x160.jpg') }}"
                     class="user-avatar"
                     alt="Avatar">

                <div class="d-none d-md-block text-left ml-2">
                    <div class="user-name">
                        {{ Auth::user()->name }}
                    </div>
                    <small class="text-muted">
                        {{ Auth::user()->roles->pluck('name')->first() }}
                    </small>
                </div>

            </a>

            <div class="dropdown-menu dropdown-menu-right shadow border-0">

                <a href="#" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> Profil
                </a>

                <a href="#" class="dropdown-item">
                    <i class="fas fa-shield-alt mr-2"></i> Keamanan
                </a>

                <div class="dropdown-divider"></div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="dropdown-item text-danger font-weight-bold">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </form>

            </div>
        </li>

    </ul>
</nav>