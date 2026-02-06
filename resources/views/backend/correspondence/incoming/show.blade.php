@extends('backend.layouts.app')

@section('title', 'Analisis Dokumen')
@section('title_page', 'Rincian Surat Masuk')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('incoming.index') }}">Surat Masuk</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@push('css')
<style>
    /* Styling Timeline Disposisi agar lebih premium */
    .disposition-item:last-child .timeline-line { display: none; }
    .timeline-line { width: 2px; background: #e2e8f0; position: absolute; top: 35px; bottom: -25px; left: 17px; z-index: 1; }
    .card-info-table th { background-color: #f8fafc; color: #64748b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .bg-gradient-primary-soft { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
    
    /* Responsivitas PDF Preview */
    @media (max-width: 991px) {
        .sticky-top { position: relative !important; top: 0 !important; }
        .preview-container { height: 500px !important; }
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12 col-lg-7">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-bottom-0 d-flex justify-content-between align-items-center">
                <h6 class="font-weight-bold text-dark mb-0"><i class="fas fa-fingerprint text-primary mr-2"></i> Metadata Arsip</h6>
                <div class="badge badge-light border shadow-xs px-3 py-2 font-weight-bold text-primary" style="font-size: 0.9rem;">
                    Agenda #{{ str_pad($incoming->agenda_number, 4, '0', STR_PAD_LEFT) }}
                </div>
            </div>
            <div class="card-body p-0 card-info-table">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <th class="pl-4 align-middle" width="200">No. Surat Asli</th>
                                <td class="font-weight-bold text-dark">{{ $incoming->mail_number }}</td>
                            </tr>
                            <tr>
                                <th class="pl-4 align-middle">Asal Pengirim</th>
                                <td class="font-weight-bold text-dark">{{ $incoming->sender_origin }}</td>
                            </tr>
                            <tr>
                                <th class="pl-4 align-middle">Perihal</th>
                                <td class="text-dark">{{ $incoming->subject }}</td>
                            </tr>
                            <tr>
                                <th class="pl-4 align-middle">Klasifikasi</th>
                                <td>
                                    <span class="badge badge-info shadow-xs px-2 py-1">{{ $incoming->category->code }}</span> 
                                    <span class="ml-2 font-weight-500">{{ $incoming->category->name }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="pl-4 align-middle">Administrasi</th>
                                <td>
                                    <div class="small">
                                        <span class="mr-3 text-muted">Surat: <b class="text-dark">{{ $incoming->mail_date->format('d M Y') }}</b></span>
                                        <span class="text-muted">Terima: <b class="text-dark">{{ $incoming->received_date->format('d M Y') }}</b></span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-light-50 border-0 py-3 text-right">
                <a href="{{ route('incoming.edit', $incoming->id) }}" class="btn btn-white btn-sm border shadow-xs px-3 font-weight-bold text-warning">
                    <i class="fas fa-edit mr-1"></i> Koreksi Data
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-bottom-0 d-flex justify-content-between align-items-center">
                <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-project-diagram mr-2 text-info"></i> Jejak Disposisi</h6>
                <a href="{{ route('disposition.create', ['incoming' => $incoming->id]) }}" class="btn btn-primary btn-sm px-3 shadow-sm rounded-pill font-weight-bold">
                    <i class="fas fa-share mr-1"></i> Teruskan
                </a>
            </div>
            <div class="card-body p-4">
                @forelse($incoming->dispositions as $disp)
                    <div class="d-flex disposition-item mb-4 position-relative">
                        <div class="timeline-line"></div>
                        <div class="mr-3 position-relative" style="z-index: 2;">
                            <div class="bg-white border rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 36px; height: 36px;">
                                <i class="fas fa-user-check text-{{ $disp->status == 'completed' ? 'success' : 'muted' }} small"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 p-3 rounded-lg bg-white border shadow-xs">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="font-weight-bold text-dark mb-0">{{ $disp->receiver->name }}</h6>
                                    <small class="badge badge-light border py-0">{{ $disp->receiver->roles->first()->name ?? 'Staff' }}</small>
                                </div>
                                <span class="text-muted x-small font-weight-bold"><i class="far fa-clock mr-1"></i>{{ $disp->due_date->format('d/m') }}</span>
                            </div>
                            
                            <div class="p-2 rounded mb-2" style="background-color: #f1f5f9; border-left: 3px solid #3b82f6;">
                                <p class="small text-dark mb-0 italic">"{{ $disp->instruction }}"</p>
                            </div>
                            
                            @if($disp->note) 
                                <div class="small text-muted mb-2 px-1">
                                    <i class="fas fa-reply mr-1"></i> <b>Laporan:</b> {{ $disp->note }}
                                </div> 
                            @endif

                            <div class="d-flex align-items-center justify-content-between mt-2 pt-2 border-top">
                                <span class="badge badge-{{ $disp->status == 'completed' ? 'success' : 'warning' }} px-2 py-1 shadow-xs" style="font-size: 0.65rem; text-transform: uppercase;">
                                    {{ $disp->status == 'completed' ? 'Tuntas' : 'Berjalan' }}
                                </span>

                                @if(auth()->id() == $disp->to_user_id && $disp->status != 'completed')
                                    <button class="btn btn-xs btn-primary px-3 rounded-pill font-weight-bold" data-toggle="modal" data-target="#modalDispositionAction{{ $disp->id }}">
                                        Lapor Progres
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-stream fa-3x text-light mb-3"></i>
                        <p class="text-muted small italic font-weight-bold">Belum ada alur disposisi digital.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-5">
        <div class="card shadow-sm border-0 sticky-top overflow-hidden" style="top: 85px; border-radius: 12px;">
            <div class="card-header bg-dark py-3 border-0 d-flex justify-content-between align-items-center">
                <h6 class="font-weight-bold text-white mb-0"><i class="fas fa-file-pdf mr-2"></i> Digital Copy</h6>
                @if($incoming->file_path)
                    <a href="{{ asset('storage/' . $incoming->file_path) }}" target="_blank" class="btn btn-xs btn-outline-light px-2"><i class="fas fa-expand"></i></a>
                @endif
            </div>
            <div class="card-body p-0 bg-light preview-container" style="height: 70vh; min-height: 450px;">
                @if($incoming->file_path)
                    <iframe src="{{ asset('storage/' . $incoming->file_path) }}" width="100%" height="100%" style="border: none;"></iframe>
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center h-100 p-5 text-center">
                        <i class="far fa-file-pdf fa-4x text-gray-300 mb-3"></i>
                        <h6 class="text-muted font-weight-bold">Berkas Tidak Tersedia</h6>
                        <p class="small text-muted">Scan fisik belum diunggah ke sistem.</p>
                    </div>
                @endif
            </div>
            <div class="card-footer bg-white border-0 py-3">
                <a href="{{ route('disposition.print', $incoming->id) }}" target="_blank" class="btn btn-danger btn-block font-weight-bold shadow-sm rounded-lg py-2">
                    <i class="fas fa-print mr-2"></i> Cetak Lembar Disposisi
                </a>
            </div>
        </div>
    </div>
</div>

@endsection