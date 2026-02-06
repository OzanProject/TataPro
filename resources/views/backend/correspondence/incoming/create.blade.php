@extends('backend.layouts.app')

@section('title', 'Catat Surat Masuk Baru')
@section('title_page', 'Registrasi Surat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('incoming.index') }}">Surat Masuk</a></li>
    <li class="breadcrumb-item active">Baru</li>
@endsection

@section('content')
<form action="{{ route('incoming.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12 col-lg-8 mb-4 mb-lg-0">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="card-title font-weight-bold mb-0 text-primary">
                        <i class="fas fa-edit mr-2"></i> Detail Konten Surat
                    </h5>
                </div>
                <div class="card-body pt-0">
                    <div class="form-group">
                        <label class="font-weight-bold small text-muted text-uppercase">Perihal Surat <span class="text-danger">*</span></label>
                        <textarea name="subject" class="form-control @error('subject') is-invalid @enderror" rows="3" placeholder="Contoh: Undangan Rapat Koordinasi Kurikulum..." required>{{ old('subject') }}</textarea>
                        @error('subject') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold small text-muted text-uppercase">Nomor Surat Asli <span class="text-danger">*</span></label>
                                <input type="text" name="mail_number" class="form-control @error('mail_number') is-invalid @enderror" placeholder="421/001/Disdik/2026" value="{{ old('mail_number') }}" required>
                                @error('mail_number') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold small text-muted text-uppercase">Asal Instansi / Pengirim <span class="text-danger">*</span></label>
                                <input type="text" name="sender_origin" class="form-control @error('sender_origin') is-invalid @enderror" placeholder="Dinas Pendidikan Provinsi..." value="{{ old('sender_origin') }}" required>
                                @error('sender_origin') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold small text-muted text-uppercase">Unggah Scan Surat (PDF/JPG)</label>
                        <div class="custom-file">
                            <input type="file" name="file_path" class="custom-file-input" id="fileUpload" accept=".pdf,.jpg,.jpeg,.png">
                            <label class="custom-file-label border-light shadow-xs" for="fileUpload">Pilih file scan...</label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Format PDF direkomendasikan. Maksimal 2MB.</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="card-title font-weight-bold mb-0 text-dark">
                        <i class="fas fa-archive mr-2"></i> Metadata Arsip
                    </h5>
                </div>
                <div class="card-body pt-0">
                    <div class="form-group">
                        <label class="small text-uppercase text-muted font-weight-bold">Nomor Agenda</label>
                        <div class="input-group shadow-xs">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light font-weight-bold border-0">#</span>
                            </div>
                            <input type="text" name="agenda_number" class="form-control font-weight-bold text-primary border-0 bg-light @error('agenda_number') is-invalid @enderror" value="{{ old('agenda_number', $agendaNumber) }}">
                        </div>
                        @error('agenda_number') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="small text-uppercase text-muted font-weight-bold">Klasifikasi Surat</label>
                        <select name="category_id" class="form-control select2 @error('category_id') is-invalid @enderror" style="width: 100%;">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->code }} - {{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <hr class="my-4">

                    <div class="form-group">
                        <label class="small text-uppercase text-muted font-weight-bold">Tanggal Surat Asli</label>
                        <input type="date" name="mail_date" class="form-control shadow-xs border-light @error('mail_date') is-invalid @enderror" value="{{ old('mail_date') }}" required>
                    </div>

                    <div class="form-group mb-0">
                        <label class="small text-uppercase text-muted font-weight-bold">Tanggal Diterima</label>
                        <input type="date" name="received_date" class="form-control shadow-xs border-light @error('received_date') is-invalid @enderror" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <button type="submit" class="btn btn-primary btn-block shadow-sm font-weight-bold py-2">
                        <i class="fas fa-save mr-2"></i> Simpan Catatan
                    </button>
                    <a href="{{ route('incoming.index') }}" class="btn btn-light btn-block shadow-xs font-weight-bold py-2 mt-2">
                        <i class="fas fa-arrow-left mr-2"></i> Batalkan
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('js')
<script>
    // Menampilkan nama file saat dipilih
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
@endpush