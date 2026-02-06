@extends('backend.layouts.app')

@section('title', 'Pilih Surat Guru')
@section('title_page', 'Buat Surat Guru')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">Data Guru</a></li>
  <li class="breadcrumb-item active">Pilih Template</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="alert alert-info shadow-sm">
        <i class="fas fa-info-circle mr-2"></i> Anda akan membuat surat untuk guru: <strong>{{ $teacher->name }}</strong>
        ({{ $teacher->nip ?? 'Tanpa NIP' }})
      </div>
    </div>

    @forelse($templates as $template)
      <div class="col-md-4">
        <div class="card shadow-sm h-100 border-0" style="transition: transform 0.2s;"
          onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
          <div class="card-body text-center">
            <div class="mb-3 text-primary">
              <i class="far fa-file-word fa-3x"></i>
            </div>
            <h5 class="card-title font-weight-bold d-block mb-2">{{ $template->name }}</h5>
            <p class="card-text text-muted small">
              {{ Str::limit($template->description, 80) }}
            </p>
            <a href="{{ route('generator.createForTeacher', ['template' => $template->id, 'teacher' => $teacher->id]) }}"
              class="btn btn-primary btn-block rounded-pill">
              <i class="fas fa-magic mr-2"></i> Buat Surat Ini
            </a>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12 text-center py-5">
        <img src="{{ asset('adminlte3/dist/img/empty.svg') }}" style="width: 150px; opacity: 0.5;">
        <h6 class="text-muted mt-3">Belum ada template surat tersedia.</h6>
        <a href="{{ route('generator.create') }}" class="btn btn-outline-primary mt-2">Upload Template Baru</a>
      </div>
    @endforelse
  </div>
@endsection