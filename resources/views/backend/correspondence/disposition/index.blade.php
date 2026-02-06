@extends('backend.layouts.app')

@section('title', 'Manajemen Disposisi')
@section('title_page', 'Kotak Disposisi')

@section('breadcrumb')
    <li class="breadcrumb-item active">Disposisi</li>
@endsection

@push('css')
<style>
    /* Styling Tab Modern */
    .nav-tabs-custom .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        color: #64748b;
        font-weight: 600;
        padding: 1rem 1.5rem;
        transition: all 0.3s ease;
    }
    .nav-tabs-custom .nav-link.active {
        background: transparent !important;
        border-bottom-color: #3b82f6;
        color: #3b82f6 !important;
    }
    .nav-tabs-custom .nav-link:hover:not(.active) {
        border-bottom-color: #e2e8f0;
    }

    /* Badges & Typography */
    .badge-pill { font-weight: 700; letter-spacing: 0.3px; }
    .mail-subject { color: #1e293b; font-weight: 700; font-size: 0.95rem; line-height: 1.4; }
    .instruction-highlight { background-color: #f8fafc; border-left: 3px solid #0ea5e9; padding: 5px 10px; }
    
    /* Hover Row Effect */
    .table-disposition tbody tr:hover { background-color: rgba(59, 130, 246, 0.02); }
    .table-responsive { overflow: visible !important; }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header p-0 bg-white border-bottom">
                <ul class="nav nav-tabs nav-tabs-custom" id="dispositionTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="inbox-tab" data-toggle="pill" href="#tab-inbox" role="tab">
                            <i class="fas fa-tray mr-2"></i> Disposisi Masuk 
                            <span class="badge badge-danger badge-pill ml-2 shadow-xs">
                                {{ $inbox->where('status', '!=', 'completed')->count() }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="outbox-tab" data-toggle="pill" href="#tab-outbox" role="tab">
                            <i class="fas fa-paper-plane-top mr-2 text-muted"></i> Riwayat Keluar
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body p-0">
                <div class="tab-content" id="dispositionTabContent">
                    
                    <div class="tab-pane fade show active" id="tab-inbox" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 table-disposition">
                                <thead class="bg-light text-uppercase small font-weight-bold text-muted">
                                    <tr>
                                        <th class="pl-4 border-0">Pemberi Instruksi</th>
                                        <th class="border-0">Rincian Surat</th>
                                        <th class="border-0">Instruksi Kerja</th>
                                        <th class="border-0 text-center">Batas Waktu</th>
                                        <th class="border-0 text-center">Status</th>
                                        <th class="border-0 text-right pr-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($inbox as $disp)
                                    <tr>
                                        <td class="pl-4">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light-primary rounded-circle mr-3 d-flex align-items-center justify-content-center shadow-xs" style="width:38px; height:38px;">
                                                    <i class="fas fa-user-tie text-primary"></i>
                                                </div>
                                                <div class="text-dark font-weight-bold">{{ $disp->sender->name }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mail-subject text-truncate" style="max-width: 280px;" title="{{ $disp->incoming_mail->subject }}">
                                                {{ $disp->incoming_mail->subject ?? '-' }}
                                            </div>
                                            <span class="text-primary font-weight-bold small">#{{ $disp->incoming_mail->mail_number ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <div class="instruction-highlight rounded">
                                                <span class="d-block font-weight-bold text-info small mb-1">{{ $disp->instruction }}</span>
                                                <div class="small text-muted italic">{{ Str::limit($disp->note, 60) }}</div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @php 
                                                $deadline = \Carbon\Carbon::parse($disp->due_date);
                                                $isOverdue = $deadline->isPast() && $disp->status != 'completed';
                                            @endphp
                                            <div class="{{ $isOverdue ? 'text-danger font-weight-bold' : 'text-dark' }}">
                                                {{ $deadline->format('d M Y') }}
                                            </div>
                                            @if($isOverdue)
                                                <span class="badge badge-danger px-2 py-0" style="font-size: 8px;">TERLAMBAT</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-{{ $disp->status == 'completed' ? 'success' : 'warning' }} badge-pill shadow-xs px-3">
                                                {{ $disp->status == 'completed' ? 'Selesai' : 'Pending' }}
                                            </span>
                                        </td>
                                        <td class="text-right pr-4">
                                            <a href="{{ route('incoming.show', $disp->incoming_mail_id) }}" class="btn btn-primary btn-sm rounded-pill shadow-sm px-3 font-weight-bold">
                                                <i class="fas fa-external-link-alt mr-1"></i> Kerjakan
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="py-5 text-center">
                                            <img src="https://illustrations.popsy.co/gray/success.svg" style="height: 140px; opacity: 0.8;">
                                            <p class="text-muted mt-3 font-italic">Semua tugas disposisi telah selesai dikerjakan.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-outbox" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 table-disposition">
                                <thead class="bg-light text-uppercase small font-weight-bold text-muted">
                                    <tr>
                                        <th class="pl-4 border-0">Penerima Tugas</th>
                                        <th class="border-0">Perihal Surat</th>
                                        <th class="border-0">Instruksi</th>
                                        <th class="border-0 text-center">Status</th>
                                        <th class="border-0 text-right pr-4">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($outbox as $disp)
                                    <tr>
                                        <td class="pl-4">
                                            <div class="text-dark font-weight-bold">{{ $disp->receiver->name }}</div>
                                            <small class="text-muted italic">Deadline: {{ \Carbon\Carbon::parse($disp->due_date)->format('d/m/Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="text-truncate text-muted font-weight-500" style="max-width: 250px;">{{ $disp->incoming_mail->subject ?? '-' }}</div>
                                        </td>
                                        <td class="font-weight-600 text-info">{{ $disp->instruction }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-{{ $disp->status == 'completed' ? 'success' : 'outline-warning' }} border px-2 py-1">
                                                {{ ucfirst($disp->status) }}
                                            </span>
                                        </td>
                                        <td class="text-right pr-4">
                                            <div class="btn-group shadow-xs border rounded bg-white">
                                                <a href="{{ route('incoming.show', $disp->incoming_mail_id) }}" class="btn btn-white btn-sm text-info border-right" title="Detail"><i class="fas fa-eye"></i></a>
                                                <form action="{{ route('disposition.destroy', $disp->id) }}" method="POST" class="d-inline form-delete">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="btn btn-white btn-sm text-danger btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="py-5 text-center text-muted small italic">Belum ada riwayat pengiriman instruksi disposisi.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        let form = $(this).closest('.form-delete');
        Swal.fire({
            title: 'Batalkan Disposisi?',
            text: "Instruksi yang sudah dikirim akan dihapus dari kotak masuk penerima!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Kembali',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) { form.submit(); }
        });
    });
</script>
@endpush