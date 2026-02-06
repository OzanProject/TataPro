@extends('backend.layouts.app')

@section('title', 'Kirim Disposisi')
@section('title_page', 'Buat Instruksi Disposisi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('incoming.index') }}">Surat Masuk</a></li>
    <li class="breadcrumb-item"><a href="{{ route('incoming.show', $incoming->id) }}">Detail</a></li>
    <li class="breadcrumb-item active">Disposisi</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="font-weight-bold text-dark mb-0"><i class="fas fa-file-alt mr-2 text-primary"></i> Rujukan Surat</h6>
            </div>
            <div class="card-body p-0">
                <div class="p-3 bg-light-primary border-bottom">
                    <label class="small text-uppercase text-muted mb-1 d-block">Perihal</label>
                    <p class="font-weight-bold mb-0 text-dark leading-snug">{{ $incoming->subject }}</p>
                </div>
                <div class="p-3 border-bottom">
                    <label class="small text-uppercase text-muted mb-1 d-block">Identitas</label>
                    <div class="text-sm">
                        No: <span class="font-weight-bold">{{ $incoming->mail_number }}</span><br>
                        Asal: <span class="font-weight-bold">{{ $incoming->sender_origin }}</span>
                    </div>
                </div>
                <div class="p-3">
                    <label class="small text-uppercase text-muted mb-1 d-block">Tanggal Surat</label>
                    <span class="badge badge-outline-secondary px-2 py-1">
                        <i class="far fa-calendar-alt mr-1"></i> {{ $incoming->mail_date->format('d F Y') }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="alert alert-info border-0 shadow-sm mt-3">
            <p class="small mb-0">
                <i class="fas fa-lightbulb mr-1"></i> <strong>Tips:</strong> Disposisi akan langsung muncul di kotak masuk user yang dituju.
            </p>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0 border-top border-info" style="border-width: 3px !important;">
            <div class="card-header bg-white py-3">
                <h6 class="font-weight-bold text-dark mb-0"><i class="fas fa-paper-plane mr-2 text-info"></i> Form Instruksi Kerja</h6>
            </div>
            
            <form action="{{ route('disposition.store', $incoming->id) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Teruskan Kepada (Staf/User) <span class="text-danger">*</span></label>
                        <select name="to_user_id" class="form-control select2 @error('to_user_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Penerima Tugas --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('to_user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} — ({{ $user->roles->pluck('name')->first() }})
                                </option>
                            @endforeach
                        </select>
                        @error('to_user_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Instruksi Utama <span class="text-danger">*</span></label>
                                <select name="instruction" class="form-control font-weight-bold border-info">
                                    @php
                                        $options = ['Tindak Lanjuti', 'Untuk Diketahui', 'Edarkan', 'Jawab', 'Simpan/Arsip', 'Siapkan Bahan'];
                                    @endphp
                                    @foreach($options as $opt)
                                        <option value="{{ $opt }}" {{ $opt == 'Untuk Diketahui' ? 'selected' : '' }}>{{ $opt }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Batas Waktu Pelaksanaan <span class="text-danger">*</span></label>
                                <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror" value="{{ old('due_date', date('Y-m-d', strtotime('+3 days'))) }}" required>
                                @error('due_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Pesan Tambahan (Opsional)</label>
                        <textarea name="note" class="form-control @error('note') is-invalid @enderror" rows="4" placeholder="Tuliskan detail pekerjaan atau catatan khusus di sini...">{{ old('note') }}</textarea>
                        @error('note') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Prioritas Kerja</label>
                        <div class="d-flex align-items-center">
                            <div class="custom-control custom-radio mr-4">
                                <input class="custom-control-input" type="radio" id="prio1" name="status" value="todo" checked>
                                <label for="prio1" class="custom-control-label font-weight-normal">Segera (To Do)</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="prio2" name="status" value="completed">
                                <label for="prio2" class="custom-control-label font-weight-normal">Hanya Arsip Selesai</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light border-0 py-3">
                    <button type="submit" class="btn btn-info px-4 shadow-sm font-weight-bold">
                        <i class="fas fa-paper-plane mr-1"></i> Kirim Disposisi
                    </button>
                    <a href="{{ route('incoming.show', $incoming->id) }}" class="btn btn-link text-muted float-right">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection