@extends('backend.layouts.app')

@section('title', 'Pratinjau Surat Keluar')
@section('title_page', 'Pratinjau Surat')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('outgoing.index') }}">Surat Keluar</a></li>
  <li class="breadcrumb-item active">Pratinjau</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-lg" style="border-radius: 20px;">
        <div class="card-header bg-white py-3 border-0">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h5 class="font-weight-bold mb-1 text-dark">{{ $outgoing->mail_subject }}</h5>
              <p class="text-muted small mb-0">
                Nomor: <span class="font-weight-bold text-dark">{{ $outgoing->mail_number ?? 'DRAFT' }}</span> |
                Tanggal: {{ \Carbon\Carbon::parse($outgoing->mail_date)->isoFormat('D MMMM Y') }}
              </p>
            </div>
            <div>
              <a href="{{ asset('storage/' . $outgoing->file_path) }}" target="_blank"
                class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-download mr-2"></i> Download PDF
              </a>
              <a href="{{ route('outgoing.index') }}" class="btn btn-light rounded-pill px-4 ml-2">
                Kembali
              </a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          @if($outgoing->file_path && Storage::disk('public')->exists($outgoing->file_path))
            <div class="embed-responsive embed-responsive-16by9" style="height: 80vh;">
              <iframe class="embed-responsive-item" src="{{ asset('storage/' . $outgoing->file_path) }}"
                allowfullscreen></iframe>
            </div>
          @else
            <div class="text-center py-5">
              <div class="bg-light rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3"
                style="width: 80px; height: 80px;">
                <i class="fas fa-file-pdf text-muted fa-3x"></i>
              </div>
              <h5 class="text-muted">File surat tidak ditemukan atau belum diunggah.</h5>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection