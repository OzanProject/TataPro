@extends('backend.layouts.app')

@section('title', 'Pilih Jenis Surat')
@section('title_page', 'Buat Surat untuk: ' . $student->name)

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Siswa</a></li>
  <li class="breadcrumb-item active">Pilih Surat</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <h3 class="card-title">Pilih Template Surat</h3>
        </div>
        <div class="card-body">
          <div class="row">
            @forelse($templates as $template)
              <div class="col-md-4 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm border-0 bg-light">
                  <div class="card-body text-center d-flex flex-column justify-content-center">
                    <div class="mb-3">
                      <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm"
                        style="width: 60px; height: 60px;">
                        <i class="fas fa-file-alt text-primary fa-2x"></i>
                      </div>
                    </div>
                    <h5 class="card-title font-weight-bold mb-2 w-100">{{ $template->name }}</h5>
                    <p class="card-text text-muted small mb-3">{{ Str::limit($template->description, 50) }}</p>
                    <a href="{{ route('generator.createForStudent', ['template' => $template->id, 'student' => $student->id]) }}"
                      class="btn btn-primary btn-sm rounded-pill px-4 mt-auto">
                      <i class="fas fa-magic mr-1"></i> Buat Surat
                    </a>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12 text-center py-5">
                <img src="{{ asset('adminlte3/dist/img/empty.svg') }}" style="width: 150px; opacity: 0.5;">
                <h6 class="text-muted mt-3">Belum ada template surat tersedia.</h6>
                <a href="{{ route('templates.create') }}" class="btn btn-primary btn-sm mt-2">
                  <i class="fas fa-plus mr-1"></i> Tambah Template
                </a>
              </div>
            @endforelse
          </div>
        </div>
        <div class="card-footer">
          <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection