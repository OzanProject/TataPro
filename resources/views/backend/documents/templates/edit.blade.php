@extends('backend.layouts.app')

@section('title', 'Edit Template')
@section('title_page', 'Edit Template')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('templates.index') }}">Template Dokumen</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Edit Template: {{ $template->name }}</h3>
            </div>
            
            <form action="{{ route('templates.update', $template->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Template</label>
                        <input type="text" name="name" class="form-control" value="{{ $template->name }}" required>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3">{{ $template->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>File Template (Biarkan kosong jika tidak ingin mengganti file)</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="customFile" accept=".docx">
                                <label class="custom-file-label" for="customFile">Pilih file baru...</label>
                            </div>
                        </div>
                        @if($template->file_path)
                            <small class="text-muted">File saat ini: <a href="{{ asset('storage/' . $template->file_path) }}" target="_blank">Download File</a></small>
                            <br>
                            <small class="text-info">Variabel saat ini: {{ implode(', ', $template->variables ?? []) }}</small>
                        @endif
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Update Template</button>
                    <a href="{{ route('templates.index') }}" class="btn btn-default float-right">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
@endpush
@endsection
