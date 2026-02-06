@extends('backend.layouts.app')

@section('title', 'Detail Arsip Keluar')
@section('title_page', 'Log Detail Surat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('outgoing.index') }}">Surat Keluar</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@push('css')
<style>
    /* Styling khusus kontainer DOCX agar terlihat seperti kertas di atas meja */
    #docx-container {
        width: 100%;
        height: 750px;
        overflow-y: auto;
        background: #525659; /* Warna gelap ala PDF viewer */
        padding: 40px 15px;
        border-radius: 0 0 8px 8px;
    }
    .docx-wrapper {
        background-color: #525659 !important;
        padding: 0 !important;
    }
    section.docx {
        background: white !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.5) !important;
        margin-bottom: 30px !important;
        padding: 2cm !important; /* Standar margin kertas A4 */
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="font-weight-bold text-dark mb-0">Informasi Administrasi</h6>
                <span class="badge badge-light border text-primary px-2">Agenda Keluar #{{ $outgoing->agenda_number ?? 'N/A' }}</span>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <tr>
                        <th class="bg-light border-0 pl-4" width="180">Status</th>
                        <td class="border-0">
                            @php
                                $statusMap = [
                                    'draft' => ['class' => 'secondary', 'label' => 'Konsep (Draft)'],
                                    'pending_approval' => ['class' => 'warning', 'label' => 'Menunggu TTD'],
                                    'signed' => ['class' => 'info', 'label' => 'Sudah TTD'],
                                    'sent' => ['class' => 'success', 'label' => 'Terkirim'],
                                ];
                                $st = $statusMap[$outgoing->status] ?? ['class' => 'dark', 'label' => 'Unknown'];
                            @endphp
                            <span class="badge badge-{{ $st['class'] }} px-2 py-1 shadow-xs text-uppercase" style="font-size: 11px;">
                                {{ $st['label'] }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-light border-0 pl-4">Nomor Surat</th>
                        <td class="border-0 font-weight-bold text-primary">{{ $outgoing->mail_number ?? '(Belum Diterbitkan)' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light border-0 pl-4">Tujuan</th>
                        <td class="border-0">{{ $outgoing->recipient_destination }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light border-0 pl-4">Kategori</th>
                        <td class="border-0">{{ $outgoing->category->code }} - {{ $outgoing->category->name }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light border-0 pl-4">Tanggal Keluar</th>
                        <td class="border-0">{{ $outgoing->mail_date->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light border-0 pl-4">Perihal</th>
                        <td class="border-0 font-weight-500">{{ $outgoing->subject }}</td>
                    </tr>
                </table>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                <a href="{{ route('outgoing.edit', $outgoing->id) }}" class="btn btn-warning btn-sm px-3 shadow-sm">
                    <i class="fas fa-edit mr-1"></i> Perbarui Data
                </a>
                <a href="{{ route('outgoing.index') }}" class="btn btn-link btn-sm text-muted float-right">Kembali</a>
            </div>
        </div>

        <div class="alert alert-light border-left border-info shadow-sm small">
            <h6 class="font-weight-bold text-info"><i class="fas fa-info-circle"></i> Tips Preview</h6>
            Preview di sebelah kanan mendukung format <b>PDF, JPG, PNG</b>, dan <b>DOCX</b>. Jika dokumen tidak muncul, silakan gunakan tombol download di bawah file.
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm border-0 overflow-hidden">
            <div class="card-header bg-dark py-3 d-flex justify-content-between align-items-center">
                <h6 class="font-weight-bold text-white mb-0"><i class="fas fa-file-alt mr-2"></i> Preview Dokumen Digital</h6>
                @if($outgoing->file_path)
                    <a href="{{ asset('storage/' . $outgoing->file_path) }}" class="btn btn-xs btn-primary px-2" download>
                        <i class="fas fa-download"></i> Unduh Asli
                    </a>
                @endif
            </div>
            <div class="card-body p-0 bg-light">
                @if($outgoing->file_path)
                    @php $extension = strtolower(pathinfo($outgoing->file_path, PATHINFO_EXTENSION)); @endphp

                    @if($extension == 'pdf')
                        <iframe src="{{ asset('storage/' . $outgoing->file_path) }}" style="width: 100%; height: 750px; border: none;"></iframe>
                    
                    @elseif(in_array($extension, ['jpg', 'jpeg', 'png']))
                        <div class="text-center p-4">
                            <img src="{{ asset('storage/' . $outgoing->file_path) }}" class="img-fluid shadow-lg rounded" style="max-height: 700px;">
                        </div>

                    @elseif($extension == 'docx')
                        <div id="docx-container">
                            <div class="text-center text-white pt-5">
                                <div class="spinner-border text-light mb-2" role="status"></div>
                                <p class="small">Menyusun dokumen untuk dipratinjau...</p>
                            </div>
                        </div>
                    
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-download fa-4x text-muted mb-3"></i>
                            <p class="text-muted">Pratinjau tidak tersedia untuk format <b>.{{ $extension }}</b></p>
                            <a href="{{ asset('storage/' . $outgoing->file_path) }}" class="btn btn-outline-primary" download>Download File</a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <img src="https://illustrations.popsy.co/gray/document-not-found.svg" style="height: 180px;">
                        <p class="text-muted mt-3">Tidak ada file digital yang diunggah untuk surat ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://unpkg.com/jszip/dist/jszip.min.js"></script>
<script src="https://unpkg.com/docx-preview/dist/docx-preview.min.js"></script>

<script>
    @if(isset($outgoing->file_path) && strtolower(pathinfo($outgoing->file_path, PATHINFO_EXTENSION)) == 'docx')
    document.addEventListener("DOMContentLoaded", function() {
        const docUrl = "{{ asset('storage/' . $outgoing->file_path) }}";
        const container = document.getElementById("docx-container");

        fetch(docUrl)
            .then(res => res.blob())
            .then(blob => {
                docx.renderAsync(blob, container, null, {
                    className: "docx",
                    inWrapper: false,
                    breakPages: true,
                    trimXmlDeclaration: true
                }).catch(err => {
                    container.innerHTML = `<div class='p-5 text-center text-white'><i class='fas fa-exclamation-triangle fa-2x mb-2'></i><br>Gagal merender DOCX. File mungkin terproteksi.</div>`;
                });
            })
            .catch(() => {
                container.innerHTML = `<div class='p-5 text-center text-white'>Gagal mengambil file dari server.</div>`;
            });
    });
    @endif
</script>
@endpush