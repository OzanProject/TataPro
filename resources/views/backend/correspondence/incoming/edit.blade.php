@extends('backend.layouts.app')

@section('title', 'Perbarui Data Surat')
@section('title_page', 'Edit Surat Masuk')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('incoming.index') }}">Surat Masuk</a></li>
    <li class="breadcrumb-item active">Perbarui</li>
@endsection

@section('content')
<form action="{{ route('incoming.update', $incoming->id) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="row">
        <div class="col-12 col-lg-8 mb-4 mb-lg-0">
            <div class="card shadow-sm border-0 border-top border-warning h-100" style="border-width: 3px !important;">
                <div class="card-header bg-white py-3 border-bottom-0">
                     <h5 class="card-title font-weight-bold mb-0 text-dark">
                        <i class="fas fa-edit mr-2 text-warning"></i> Koreksi Data Surat
                     </h5>
                </div>
                <div class="card-body pt-0">
                    <div class="form-group">
                        <label class="font-weight-bold small text-muted text-uppercase">Perihal Surat</label>
                        <textarea name="subject" class="form-control @error('subject') is-invalid @enderror" rows="4" required>{{ old('subject', $incoming->subject) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold small text-muted text-uppercase">Nomor Surat Asli</label>
                                <input type="text" name="mail_number" class="form-control @error('mail_number') is-invalid @enderror" value="{{ old('mail_number', $incoming->mail_number) }}" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold small text-muted text-uppercase">Asal Instansi / Pengirim</label>
                                <input type="text" name="sender_origin" class="form-control @error('sender_origin') is-invalid @enderror" value="{{ old('sender_origin', $incoming->sender_origin) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded border-0">
                        <label class="font-weight-bold mb-2 small text-muted text-uppercase">Manajemen Berkas Digital</label>
                        @if($incoming->file_path)
                            <div class="d-flex align-items-center mb-3 p-2 bg-white rounded shadow-sm border">
                                <div class="bg-warning p-2 rounded mr-3"><i class="fas fa-file-pdf text-white"></i></div>
                                <div>
                                    <p class="mb-0 small font-weight-bold text-dark">File Tersedia</p>
                                    <a href="{{ asset('storage/' . $incoming->file_path) }}" target="_blank" class="small text-primary font-weight-bold">Lihat / Download</a>
                                </div>
                            </div>
                        @endif
                        <div class="custom-file">
                            <input type="file" name="file_path" class="custom-file-input" id="fileEdit">
                            <label class="custom-file-label border-light shadow-xs" for="fileEdit">Ganti file scan (Opsional)</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="card-title font-weight-bold mb-0 text-dark">
                        <i class="fas fa-cog mr-2"></i> Pengaturan
                    </h5>
                </div>
                <div class="card-body pt-0">
                    <div class="form-group">
                        <label class="small text-success font-weight-bold text-uppercase">Status Arsip</label>
                        <select name="status" class="form-control bg-light font-weight-bold border-0 text-success">
                            <option value="received" {{ $incoming->status == 'received' ? 'selected' : '' }}>Diterima (Baru)</option>
                            <option value="dispositioned" {{ $incoming->status == 'dispositioned' ? 'selected' : '' }}>Dalam Disposisi</option>
                            <option value="processed" {{ $incoming->status == 'processed' ? 'selected' : '' }}>Selesai / Diarsipkan</option>
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="small text-muted text-uppercase font-weight-bold">Nomor Agenda</label>
                         <div class="input-group shadow-xs">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light font-weight-bold border-0">#</span>
                            </div>
                            <input type="text" name="agenda_number" class="form-control font-weight-bold text-dark border-0 bg-light" value="{{ old('agenda_number', $incoming->agenda_number) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="small text-muted text-uppercase font-weight-bold">Klasifikasi</label>
                        <select name="category_id" class="form-control select2">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $cat->id == $incoming->category_id ? 'selected' : '' }}>{{ $cat->code }} - {{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="small text-muted text-uppercase font-weight-bold">Tanggal Surat</label>
                        <input type="date" name="mail_date" class="form-control shadow-xs border-light" value="{{ old('mail_date', $incoming->mail_date->format('Y-m-d')) }}">
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <button type="submit" class="btn btn-warning btn-block font-weight-bold shadow-sm py-2">
                        <i class="fas fa-sync-alt mr-2"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('incoming.index') }}" class="btn btn-block btn-light font-weight-bold shadow-xs py-2 mt-2">Batalkan</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection