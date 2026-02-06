@extends('backend.layouts.app')

@section('title', 'Tambah Siswa Baru')
@section('title_page', 'Registrasi Siswa')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Database Siswa</a></li>
    <li class="breadcrumb-item active">Tambah Baru</li>
@endsection

@section('content')
    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-7">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white py-3">
                        <h6 class="font-weight-bold text-primary mb-0">
                            <i class="fas fa-user-tag mr-2"></i> Identitas Akademik & Dasar
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Nomor Induk Siswa (NIS) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror"
                                        placeholder="Contoh: 2026001" value="{{ old('nis') }}" required>
                                    @error('nis') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">NISN (Nasional)</label>
                                    <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror"
                                        placeholder="10 Digit Nomor Nasional" value="{{ old('nisn') }}">
                                    @error('nisn') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Nama Lengkap Siswa <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Masukkan nama sesuai ijazah..." value="{{ old('name') }}" required>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="gender" class="form-control" required>
                                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Kelas / Rombel <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="class"
                                        class="form-control @error('class') is-invalid @enderror"
                                        placeholder="Contoh: X RPL 1" value="{{ old('class') }}" required>
                                    @error('class') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">Tempat Lahir</label>
                                    <input type="text" name="place_of_birth" class="form-control" placeholder="Kota Lahir"
                                        value="{{ old('place_of_birth') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">Tanggal Lahir</label>
                                    <input type="date" name="date_of_birth" class="form-control"
                                        value="{{ old('date_of_birth') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">Agama</label>
                                    <select name="religion" class="form-control">
                                        <option value="">- Pilih -</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white py-3">
                        <h6 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-address-book mr-2 text-muted"></i> Informasi Tambahan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="small text-uppercase font-weight-bold text-muted">Email Aktif</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i
                                            class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" name="email" class="form-control border-left-0"
                                    placeholder="siswa@example.com" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="small text-uppercase font-weight-bold text-muted">No. WhatsApp / Telepon</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i
                                            class="fab fa-whatsapp"></i></span>
                                </div>
                                <input type="text" name="phone" class="form-control border-left-0" placeholder="628xxxxxx"
                                    value="{{ old('phone') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="small text-uppercase font-weight-bold text-muted">Alamat Tinggal</label>
                            <textarea name="address" class="form-control" rows="3"
                                placeholder="Jl. Contoh No. 123...">{{ old('address') }}</textarea>
                        </div>

                        <div class="form-group mb-0">
                            <label class="small text-uppercase font-weight-bold text-muted">Status Awal</label>
                            <div class="p-3 border rounded bg-light">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="statusActive" name="status" class="custom-control-input"
                                        value="active" checked>
                                    <label class="custom-control-label font-weight-normal" for="statusActive">Aktif</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="statusInactive" name="status" class="custom-control-input"
                                        value="inactive">
                                    <label class="custom-control-label font-weight-normal"
                                        for="statusInactive">Non-Aktif</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PARENTS DATA -->
            <div class="card shadow-sm border-0 rounded-lg mt-3">
                <div class="card-header bg-white py-3">
                    <h6 class="font-weight-bold text-dark mb-0">
                        <i class="fas fa-users mr-2 text-muted"></i> Data Orang Tua (Buku Induk)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Ayah</label>
                        <input type="text" name="father_name" class="form-control form-control-sm"
                            placeholder="Nama Ayah Kandung">
                    </div>
                    <div class="form-group">
                        <label>Pekerjaan Ayah</label>
                        <input type="text" name="father_job" class="form-control form-control-sm" placeholder="Pekerjaan">
                    </div>
                    <div class="form-group">
                        <label>Nama Ibu</label>
                        <input type="text" name="mother_name" class="form-control form-control-sm"
                            placeholder="Nama Ibu Kandung">
                    </div>
                    <div class="form-group">
                        <label>Pekerjaan Ibu</label>
                        <input type="text" name="mother_job" class="form-control form-control-sm" placeholder="Pekerjaan">
                    </div>
                    <div class="form-group">
                        <label>No. HP Orang Tua</label>
                        <input type="text" name="parent_phone" class="form-control form-control-sm"
                            placeholder="Kontak Ortu">
                    </div>
                    <div class="form-group">
                        <label>Alamat Orang Tua</label>
                        <textarea name="parent_address" class="form-control form-control-sm" rows="2"></textarea>
                    </div>
                </div>
            </div>

            <!-- HISTORY -->
            <div class="card shadow-sm border-0 rounded-lg mt-3">
                <div class="card-header bg-white py-3">
                    <h6 class="font-weight-bold text-dark mb-0">
                        <i class="fas fa-history mr-2 text-muted"></i> Riwayat Pendidikan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Asal Sekolah</label>
                        <input type="text" name="previous_school" class="form-control form-control-sm"
                            placeholder="SD/SMP Asal">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Diterima Tgl</label>
                                <input type="date" name="accepted_date" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Di Kelas</label>
                                <input type="text" name="accepted_grade" class="form-control form-control-sm"
                                    placeholder="X / VII">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light border-0 py-3">
                    <button type="submit" class="btn btn-primary btn-block shadow-sm font-weight-bold">
                        <i class="fas fa-save mr-1"></i> Daftarkan Siswa
                    </button>
                    <a href="{{ route('students.index') }}" class="btn btn-link btn-block btn-sm text-muted mt-2">Batalkan &
                        Kembali</a>
                </div>
            </div>
        </div>
        </div>
    </form>

    <style>
        .bg-light-primary {
            background-color: rgba(59, 130, 246, 0.05);
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            border-color: #3b82f6;
        }

        .input-group-text {
            border-radius: 8px 0 0 8px;
            border: 1px solid #e2e8f0;
            color: #64748b;
        }
    </style>
@endsection