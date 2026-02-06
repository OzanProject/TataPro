@extends('backend.layouts.app')

@section('title', $title)
@section('title_page', $title)

@section('breadcrumb')
    <li class="breadcrumb-item active">Generator</li>
@endsection

@section('content')
    <div class="row">
        @forelse($templates as $template)
            <div class="col-md-4">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $template->name }}</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">
                            {{ Str::limit($template->description, 100) ?: 'Tidak ada deskripsi.' }}
                        </p>
                        <p class="mb-2">
                            <span class="badge badge-info">{{ count($template->variables ?? []) }} Variabel</span>
                            <span class="badge badge-secondary">.docx</span>
                        </p>
                        <a href="{{ route('generator.create', $template->id) }}" class="btn btn-block btn-primary">
                            <i class="fas fa-magic"></i> Buat Dokumen
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="callout callout-warning">
                    <h5>Belum ada template!</h5>
                    <p>Silakan upload template dokumen terlebih dahulu di menu <a href="{{ route('templates.index') }}">Template
                            Dokumen</a>.</p>
                </div>
            </div>
        @endforelse
    </div>
@endsection