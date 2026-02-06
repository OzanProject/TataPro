@extends('backend.layouts.app')

@section('title', 'Tambah Template')
@section('title_page', 'Tambah Template')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('templates.index') }}">Template Dokumen</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Upload Template Baru (.docx)</h3>
            </div>
            
            <form action="{{ route('templates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info"></i> Petunjuk</h5>
                        <p>Pastikan file Word (.docx) Anda memiliki placeholder/variabel dengan format <code>${nama_variabel}</code>. 
                        Contoh: <code>${nama_siswa}</code>, <code>${tanggal_surat}</code>. Sistem akan otomatis mendeteksinya.</p>
                        <a href="{{ route('templates.sample') }}" class="btn btn-warning text-dark btn-sm mt-2">
                            <i class="fas fa-download"></i> Download Contoh Template
                        </a>
                    </div>

                    <div class="form-group">
                        <label>Nama Template</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Surat Keterangan Siswa" required>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>File Template (.docx)</label>
                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="customFile" accept=".docx" required>
                            <label class="custom-file-label" for="customFile">Pilih file</label>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan Template</button>
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
