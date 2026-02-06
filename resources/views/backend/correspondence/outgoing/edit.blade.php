@extends('backend.layouts.app')

@section('title', 'Perbarui Surat Keluar')
@section('title_page', 'Edit Arsip Keluar')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('outgoing.index') }}">Surat Keluar</a></li>
    <li class="breadcrumb-item active">Perbarui</li>
@endsection

@section('content')
<form action="{{ route('outgoing.update', $outgoing->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 border-top border-warning" style="border-width: 3px !important;">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title font-weight-bold mb-0 text-dark">
                        <i class="fas fa-edit mr-2 text-warning"></i> Detail Isi Surat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Perihal Surat <span class="text-danger">*</span></label>
                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject', $outgoing->subject) }}" required>
                        @error('subject') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Tujuan Surat / Penerima <span class="text-danger">*</span></label>
                        <input type="text" name="recipient_destination" class="form-control @error('recipient_destination') is-invalid @enderror" value="{{ old('recipient_destination', $outgoing->recipient_destination) }}" required>
                        @error('recipient_destination') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="p-3 bg-light rounded border">
                        <label class="font-weight-bold mb-2">Manajemen Berkas Digital</label>
                        @if($outgoing->file_path)
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-warning p-2 rounded mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-file-pdf text-white"></i>
                                </div>
                                <div>
                                    <p class="mb-0 small font-weight-bold text-dark">Berkas saat ini tersedia</p>
                                    <a href="{{ asset('storage/' . $outgoing->file_path) }}" target="_blank" class="small text-primary font-weight-bold">
                                        <i class="fas fa-external-link-alt mr-1"></i> Lihat / Unduh File Asli
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="mb-3">
                                <span class="badge badge-light border text-muted px-2 py-1"><i class="fas fa-info-circle mr-1"></i> Belum ada file digital yang diunggah.</span>
                            </div>
                        @endif
                        
                        <div class="custom-file">
                            <input type="file" name="file_path" class="custom-file-input" id="fileEdit" accept=".pdf,.docx,.doc">
                            <label class="custom-file-label border-light shadow-xs" for="fileEdit">Ganti berkas (Opsional)</label>
                        </div>
                        <small class="text-muted mt-2 d-block">Biarkan kosong jika tidak ingin mengubah berkas digital.</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title font-weight-bold mb-0 text-dark">
                        <i class="fas fa-cog mr-2"></i> Pengaturan Arsip
                    </h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="small text-uppercase text-muted font-weight-bold">Nomor Surat Resmi</label>
                        <input type="text" name="mail_number" class="form-control font-weight-bold {{ $outgoing->mail_number ? 'text-primary' : 'text-muted italic' }}" placeholder="Belum ada nomor (Draft)" value="{{ old('mail_number', $outgoing->mail_number) }}">
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="small text-uppercase text-muted font-weight-bold">No. Agenda</label>
                                <input type="text" name="agenda_number" class="form-control font-weight-bold" value="{{ old('agenda_number', $outgoing->agenda_number) }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="small text-uppercase text-muted font-weight-bold">Tgl Keluar</label>
                                <input type="date" name="mail_date" class="form-control" value="{{ old('mail_date', $outgoing->mail_date->format('Y-m-d')) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small text-uppercase text-muted font-weight-bold">Klasifikasi</label>
                        <select name="category_id" class="form-control select2">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $cat->id == $outgoing->category_id ? 'selected' : '' }}>
                                    {{ $cat->code }} - {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="small text-uppercase text-muted font-weight-bold">Status Alur Surat</label>
                        <select name="status" class="form-control font-weight-bold border-warning">
                            <option value="draft" {{ $outgoing->status == 'draft' ? 'selected' : '' }}>📁 Konsep (Draft)</option>
                            <option value="pending_approval" {{ $outgoing->status == 'pending_approval' ? 'selected' : '' }}>⏳ Ajukan TTD (Review)</option>
                            <option value="signed" {{ $outgoing->status == 'signed' ? 'selected' : '' }}>✒️ Sudah Ditandatangani</option>
                            <option value="sent" {{ $outgoing->status == 'sent' ? 'selected' : '' }}>✅ Terkirim & Diarsipkan</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <button type="submit" class="btn btn-warning btn-block font-weight-bold shadow-sm py-2">
                        <i class="fas fa-save mr-1"></i> Perbarui Arsip
                    </button>
                    <a href="{{ route('outgoing.index') }}" class="btn btn-link btn-block btn-sm text-muted mt-2">Batal / Kembali</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('js')
<script>
    // Update label input file secara dinamis
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
@endpush