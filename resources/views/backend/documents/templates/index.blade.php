@extends('backend.layouts.app')

@section('title', 'Template Dokumen')
@section('title_page', 'Template Dokumen')

@section('breadcrumb')
    <li class="breadcrumb-item active">Template Dokumen</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Template Surat</h3>
                <div class="card-tools">
                    <a href="{{ route('templates.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Template
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th style="width: 1%">#</th>
                            <th style="width: 30%">Nama Template</th>
                            <th style="width: 20%">Deskripsi</th>
                            <th style="width: 20%">Variabel Terdeteksi</th>
                            <th style="width: 20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($templates as $template)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a>{{ $template->name }}</a><br/>
                                <small>Created {{ $template->created_at->format('d.m.Y') }}</small>
                            </td>
                            <td>{{ $template->description }}</td>
                            <td>
                                @if(count($template->variables ?? []) > 0)
                                    @foreach($template->variables as $var)
                                        <span class="badge badge-info">{{ $var }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">Tidak ada variabel</span>
                                @endif
                            </td>
                            <td class="project-actions">
                                <a class="btn btn-info btn-sm" href="{{ route('templates.edit', $template->id) }}">
                                    <i class="fas fa-pencil-alt"></i> Edit
                                </a>
                                <form action="{{ route('templates.destroy', $template->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus template ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada template dokumen. Silakan upload file .docx</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
