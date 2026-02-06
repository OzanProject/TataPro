@extends('backend.layouts.app')

@section('title', 'Buat Surat Keluar Baru')
@section('title_page', 'Draft Surat Keluar')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('outgoing.index') }}">Surat Keluar</a></li>
    <li class="breadcrumb-item active">Baru</li>
@endsection

@section('content')
<form action="{{ route('outgoing.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title font-weight-bold mb-0 text-primary">
                        <i class="fas fa-edit mr-2"></i> Detail Isi Surat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Perihal Surat <span class="text-danger">*</span></label>
                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Contoh: Permohonan Kerjasama Sosialisasi..." value="{{ old('subject') }}" required>
                        @error('subject') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Tujuan Surat / Penerima <span class="text-danger">*</span></label>
                        <input type="text" name="recipient_destination" class="form-control @error('recipient_destination') is-invalid @enderror" placeholder="Kepada Yth. Kepala Dinas Pendidikan..." value="{{ old('recipient_destination') }}" required>
                        @error('recipient_destination') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Unggah Berkas (PDF/DOCX)</label>
                        <div class="custom-file">
                            <input type="file" name="file_path" class="custom-file-input" id="fileOutgoing" accept=".pdf,.docx,.doc">
                            <label class="custom-file-label border-light" for="fileOutgoing">Pilih file final atau draft...</label>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Biarkan kosong jika file akan diunggah belakangan.</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title font-weight-bold mb-0 text-dark">
                        <i class="fas fa-cog mr-2"></i> Administrasi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="small text-uppercase text-muted font-weight-bold">Nomor Surat Resmi</label>
                        <input type="text" name="mail_number" class="form-control bg-light @error('mail_number') is-invalid @enderror" placeholder="Isi jika sudah ada nomor" value="{{ old('mail_number') }}">
                        <small class="text-xs text-info italic">Kosongkan jika status masih 'Konsep'.</small>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="small text-uppercase text-muted font-weight-bold">No. Agenda</label>
                                <input type="text" name="agenda_number" class="form-control font-weight-bold text-primary" value="{{ old('agenda_number', $agendaNumber) }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="small text-uppercase text-muted font-weight-bold">Tanggal</label>
                                <input type="date" name="mail_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small text-uppercase text-muted font-weight-bold">Klasifikasi</label>
                        <select name="category_id" class="form-control select2">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->code }} - {{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="small text-uppercase text-muted font-weight-bold">Status Alur</label>
                        <select name="status" class="form-control font-weight-bold text-dark border-primary">
                            <option value="draft">📁 Konsep (Draft)</option>
                            <option value="pending_approval">⏳ Ajukan TTD (Review)</option>
                            <option value="sent">✅ Langsung Terkirim</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer bg-light border-0">
                    <button type="submit" class="btn btn-primary btn-block shadow-sm font-weight-bold">
                        <i class="fas fa-save mr-1"></i> Simpan Data Surat
                    </button>
                    <a href="{{ route('outgoing.index') }}" class="btn btn-link btn-block btn-sm text-muted">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('js')
<script>
    // Visual feedback untuk input file
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
@endpush