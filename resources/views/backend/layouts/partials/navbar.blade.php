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
                    {{ date('Y') }}/{{ date('Y') + 1 }}
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
                @php
                    $totalNotif = $recentMails->count() + $pendingDispositions->count();
                @endphp
                @if($totalNotif > 0)
                    <span class="badge badge-danger navbar-badge">{{ $totalNotif }}</span>
                @endif
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow border-0" style="min-width: 300px;">

                <span class="dropdown-header font-weight-bold text-center">
                    {{ $totalNotif }} Notifikasi Baru
                </span>

                <div class="dropdown-divider"></div>

                @if($totalNotif == 0)
                    <a href="#" class="dropdown-item text-center text-muted">
                        Tidak ada notifikasi baru
                    </a>
                @else
                    <!-- Incoming Mails -->
                    @foreach($recentMails as $mail)
                        <a href="{{ route('incoming.show', $mail->id) }}" class="dropdown-item">
                            <div class="media">
                                <i class="fas fa-envelope mr-2 text-primary mt-1"></i>
                                <div class="media-body">
                                    <h3 class="dropdown-item-title font-weight-bold text-sm">
                                        Surat Masuk Baru
                                    </h3>
                                    <p class="text-sm text-truncate">{{ Str::limit($mail->subject, 30) }}</p>
                                    <p class="text-xs text-muted"><i class="far fa-clock mr-1"></i>
                                        {{ $mail->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                    @endforeach

                    <!-- Dispositions -->
                    @foreach($pendingDispositions as $disp)
                        <a href="{{ route('disposition.index') }}" class="dropdown-item">
                            <div class="media">
                                <i class="fas fa-random mr-2 text-warning mt-1"></i>
                                <div class="media-body">
                                    <h3 class="dropdown-item-title font-weight-bold text-sm">
                                        Disposisi Pending
                                    </h3>
                                    <p class="text-sm text-truncate">Surat No:
                                        {{ $disp->incomingMail->reference_number ?? '-' }}</p>
                                    <p class="text-xs text-muted"><i class="far fa-clock mr-1"></i>
                                        {{ $disp->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                    @endforeach
                @endif

                <a href="{{ route('incoming.index') }}" class="dropdown-item dropdown-footer text-center bg-light">
                    Lihat Semua Surat
                </a>
            </div>
        </li>


        <!-- USER -->
        <li class="nav-item dropdown ml-2">

            <a class="nav-link user-pill" data-toggle="dropdown" href="#">

                @if(Auth::user()->profile_photo_path)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="user-avatar" alt="Avatar"
                        style="object-fit: cover;">
                @else
                    <img src="{{ asset('adminlte3/dist/img/user2-160x160.jpg') }}" class="user-avatar" alt="Avatar">
                @endif

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

                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <i class="fas fa-user-cog mr-2 text-muted"></i> Edit Profil
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