@extends('backend.layouts.app')

@section('title', 'Manajemen Surat Masuk')
@section('title_page', 'Surat Masuk')

@section('breadcrumb')
    <li class="breadcrumb-item active">Surat Masuk</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">

            <!-- STATS & FILTER -->
            <div class="row mb-4">
                <div class="col-md-4 col-12 mb-3 mb-md-0">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-primary-light text-primary d-flex align-items-center justify-content-center mr-3"
                                style="width: 50px; height: 50px; font-size: 1.2rem;">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small text-uppercase font-weight-bold mb-1">Total Surat Masuk</h6>
                                <h3 class="font-weight-bold mb-0 text-dark">{{ $incomingMails->total() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-12">
                    <div class="card border-0 shadow-sm h-100 d-flex flex-column justify-content-center px-4 py-3"
                        style="border-radius: 16px;">
                        <form action="{{ route('incoming.index') }}" method="GET"
                            class="d-flex flex-wrap align-items-center w-100">
                            <div class="flex-grow-1 mr-2 mb-2 mb-md-0 position-relative">
                                <i class="fas fa-search position-absolute text-muted"
                                    style="left: 15px; top: 50%; transform: translateY(-50%);"></i>
                                <input type="text" name="search"
                                    class="form-control border-0 bg-light rounded-pill py-4 pl-5"
                                    placeholder="Cari nomor agenda, subjek..." value="{{ request('search') }}"
                                    style="font-size: 0.95rem;">
                            </div>
                            <a href="{{ route('incoming.create') }}"
                                class="btn btn-primary rounded-pill py-2 px-4 shadow-sm font-weight-bold">
                                <i class="fas fa-plus mr-2"></i> Tambah Baru
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
                                        Agenda</th>
                                    <th class="py-3 border-0 text-uppercase text-secondary text-xs font-weight-bold">
                                        Informasi Surat</th>
                                    <th
                                        class="py-3 border-0 text-uppercase text-secondary text-xs font-weight-bold text-center">
                                        Status</th>
                                    <th class="pr-4 py-3 border-0 text-uppercase text-secondary text-xs font-weight-bold text-right"
                                        style="min-width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($incomingMails as $mail)
                                                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                                                    <td class="pl-4 align-middle">
                                                                        <div class="d-flex align-items-center">
                                                                            <div
                                                                                class="bg-light-primary text-primary rounded px-2 py-1 font-weight-bold small mr-2">
                                                                                #{{ str_pad($mail->agenda_number, 4, '0', STR_PAD_LEFT) }}
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        <p class="mb-0 font-weight-bold text-dark text-truncate" style="max-width: 300px;">
                                                                            {{ $mail->subject }}
                                                                        </p>
                                                                        <small class="text-muted">
                                                                            Nomor: {{ $mail->mail_number }}
                                                                        </small>
                                                                    </td>
                                                                    <td class="align-middle text-center">
                                                                        @php 
                                                                                                                $badges = [
                                                                                'received' => 'badge-light-warning text-warning',
                                                                                'dispositioned' => 'badge-light-info text-info',
                                                                                'processed' => 'badge-light-success text-success'
                                                                            ];
                                                                            $labels = [
                                                                                'received' => 'Diterima',
                                                                                'dispositioned' => 'Disposisi',
                                                                                'processed' => 'Selesai'
                                                                            ];
                                                                            $statusClass = $badges[$mail->status] ?? 'badge-light-secondary text-secondary';
                                                                            $statusLabel = $labels[$mail->status] ?? ucfirst($mail->status);
                                                                        @endphp
                                                                        <span class="badge badge-pill {{ $statusClass }} px-3 py-1">{{ $statusLabel }}</span>
                                                                    </td>

                                                                                                           <td class="pr-4 align-middle text-right">
                                                                        <div class="btn-group btn-group-sm">
                                                                            <a href="{{ route('incoming.show', $mail->id) }}" class="btn btn-info text-white shadow-sm" data-toggle="tooltip" title="Lihat Rincian">
                                                                                <i class="fas fa-eye"></i>
                                                                            </a>
                                                                            <a href="{{ route('incoming.edit', $mail->id) }}" class="btn btn-warning text-white shadow-sm" data-toggle="tooltip" title="Edit Data">
                                                                                <i class="fas fa-edit"></i>
                                                                            </a>
                                                                            <button type="button" class="btn btn-danger shadow-sm" onclick="confirmDelete('{{ $mail->id }}')" 
                                    d                                           ata-toggle="tooltip" title="Hapus">
                                                                                <i class="fas fa-trash-alt"></i>
                                                                            </button>
                                                                        </div>
                                                                        <form action="{{ route('incoming.destroy', $mail->id) }}" method="POST" id="form-delete-{{ $mail->id }}" class="d-none">
                                                                            @csrf @method('DELETE')
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                @empty
                                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                                        <div class="empty-state">
                                                            <div class="bg-light rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                                                <i class="fas fa-inbox text-muted fa-2x"></i>
                                                            </div>
                                                            <h6 class="text-muted">Belum ada surat masuk</h6>
                                                        </div>
                                            </td>
                                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- PAGINATION -->
                    <div cl
           ass="p-4 d-flex justify-content-
       en
    d">

           {{ $incomingMails->links('pagination::bootstrap-4') }}
                    </div>



                </div>



               </div>






               </div>
    </div>




@endsection


       
       
   

   
       
       
@push('css')



         <style>
        /* Custom Colors */
        .bg-primary-light { background: #eff6ff !important; }
        .bg-light-info { background: #ecfeff !important; }
        .bg-light-warning { background: #fef3c7 !important; }
        .bg-light-success { backgr ound: #dcfce7 !important; }
        .bg-light-danger { background: #fee2e2 !important; }
        .bg-light-secondary { background: #f1f5f9 !important; }

        .badge-light-info { background: #ecfeff; color: #06b6d4; }
        .badge-light-warning { background: #fef3c7; color: #92400e; }
        .badge-light-success { background: #dcfce7; color: #166534; }
        .badge-light-secondary { background: #f1f5f9; color: #475569; }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Surat Masuk?',
                text: "Arsip surat ini akan dihapus permanen!",
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