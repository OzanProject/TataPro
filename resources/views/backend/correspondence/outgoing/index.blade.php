@extends('backend.layouts.app')

@section('title', 'Manajemen Surat Keluar')
@section('title_page', 'Surat Keluar')

@section('breadcrumb')
    <li class="breadcrumb-item active">Surat Keluar</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">

            <!-- STATS & FILTER -->
            <div class="row mb-4">
                <div class="col-md-4 col-12 mb-3 mb-md-0">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-success-light text-success d-flex align-items-center justify-content-center mr-3"
                                style="width: 50px; height: 50px; font-size: 1.2rem;">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small text-uppercase font-weight-bold mb-1">Total Surat Keluar</h6>
                                <h3 class="font-weight-bold mb-0 text-dark">{{ $outgoing->total() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-12">
                    <div class="card border-0 shadow-sm h-100 d-flex flex-column justify-content-center px-4 py-3"
                        style="border-radius: 16px;">
                        <form action="{{ route('outgoing.index') }}" method="GET"
                            class="d-flex flex-wrap align-items-center w-100">
                            <div class="flex-grow-1 mr-2 mb-2 mb-md-0 position-relative">
                                <i class="fas fa-search position-absolute text-muted"
                                    style="left: 15px; top: 50%; transform: translateY(-50%);"></i>
                                <input type="text" name="search"
                                    class="form-control border-0 bg-light rounded-pill py-4 pl-5"
                                    placeholder="Cari nomor, perihal, atau tujuan..." value="{{ request('search') }}"
                                    style="font-size: 0.95rem;">
                            </div>
                            <a href="{{ route('outgoing.create') }}"
                                class="btn btn-primary rounded-pill py-2 px-4 shadow-sm font-weight-bold">
                                <i class="fas fa-plus mr-2"></i> Buat Baru
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- TABLE CARD -->
            <div class="card border-0 shadow-lg mb-5" style="border-radius: 20px;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="pl-4 py-3 border-0 text-uppercase text-secondary text-xs font-weight-bold">
                                        Nomor Surat</th>
                                    <th class="py-3 border-0 text-uppercase text-secondary text-xs font-weight-bold">
                                        Informasi</th>
                                    <th class="py-3 border-0 text-uppercase text-secondary text-xs font-weight-bold">Tujuan
                                    </th>
                                    <th
                                        class="py-3 border-0 text-uppercase text-secondary text-xs font-weight-bold text-center">
                                        Tanggal</th>
                                    <th
                                        class="py-3 border-0 text-uppercase text-secondary text-xs font-weight-bold text-center">
                                        Status</th>
                                    <th class="pr-4 py-3 border-0 text-uppercase text-secondary text-xs font-weight-bold text-right"
                                        style="min-width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($outgoing as $mail)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td class="pl-4 align-middle">
                                            @if($mail->mail_number)
                                                <span class="font-weight-bold text-dark">{{ $mail->mail_number }}</span>
                                            @else
                                                <span class="badge badge-pill badge-warning text-white px-3">DRAFT</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <p class="mb-0 font-weight-bold text-dark text-truncate" style="max-width: 250px;">
                                                {{ $mail->mail_subject }}
                                            </p>
                                            <small class="text-muted">
                                                <i class="far fa-folder mr-1"></i> {{ $mail->category->name ?? '-' }}
                                            </small>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-light-primary text-primary rounded-circle mr-2 d-flex align-items-center justify-content-center"
                                                    style="width: 30px; height: 30px;">
                                                    <i class="fas fa-building text-xs"></i>
                                                </div>
                                                <span class="text-sm font-weight-500">{{ $mail->mail_to }}</span>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-muted small font-weight-500">
                                                {{ \Carbon\Carbon::parse($mail->mail_date)->isoFormat('D MMM Y') }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            @if($mail->status == 'sent')
                                                <span class="badge badge-pill badge-light-success text-success px-3 py-1">Terkirim</span>
                                            @elseif($mail->status == 'draft')
                                                <span class="badge badge-pill badge-light-secondary text-secondary px-3 py-1">Draft</span>
                                            @elseif($mail->status == 'pending_approval')
                                                <span class="badge badge-pill badge-light-warning text-warning px-3 py-1">Menunggu Persetujuan</span>
                                            @elseif($mail->status == 'approved')
                                                <span class="badge badge-pill badge-light-primary text-primary px-3 py-1">Disetujui</span>
                                            @elseif($mail->status == 'rejected')
                                                <span class="badge badge-pill badge-light-danger text-danger px-3 py-1">Ditolak</span>
                                            @else
                                                <span class="badge badge-pill badge-light-warning text-warning px-3 py-1">{{ ucfirst(str_replace('_', ' ', $mail->status)) }}</span>
                                            @endif
                                        </td>
                                        <td class="pr-4 align-middle text-right">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('outgoing.preview', $mail->id) }}" target="_blank"
                                                    class="btn btn-info text-white shadow-sm" data-toggle="tooltip"
                                                    title="Pratinjau PDF">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('outgoing.edit', $mail->id) }}"
                                                    class="btn btn-warning text-white shadow-sm" data-toggle="tooltip"
                                                    title="Edit Surat">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger shadow-sm"
                                                    onclick="confirmDelete('{{ $mail->id }}')" data-toggle="tooltip"
                                                    title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                            <form action="{{ route('outgoing.destroy', $mail->id) }}" method="POST"
                                                id="form-delete-{{ $mail->id }}" class="d-none">
                                                @csrf @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="empty-state">
                                                <img src="{{ asset('adminlte3/dist/img/empty.svg') }}"
                                                    style="width: 150px; opacity: 0.5;">
                                                <h6 class="text-muted mt-3">Belum ada surat keluar</h6>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- PAGINATION -->
                    <div class="p-4 d-flex justify-content-end">
                        {{ $outgoing->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('css')
    <style>
        /* Custom Colors */
        .bg-success-light {
            background: #dcfce7 !important;
        }

        .bg-light-primary {
            background: #eff6ff !important;
        }

        .bg-light-danger {
            background: #fee2e2 !important;
        }

        .bg-light-warning {
            background: #fef3c7 !important;
        }

        .bg-light-info {
            background: #ecfeff !important;
        }

        .bg-light-secondary {
            background: #f1f5f9 !important;
        }

        .badge-light-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-light-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-light-secondary {
            background: #f1f5f9;
            color: #475569;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Surat Keluar?',
                text: "Data surat dan filenya akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete-' + id).submit();
                }
            });
        }
    </script>
@endpush