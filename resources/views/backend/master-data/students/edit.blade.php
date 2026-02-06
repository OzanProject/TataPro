@extends('backend.layouts.app')

@section('title', 'Perbarui Profil Siswa')
@section('title_page', 'Edit Data Siswa')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Database Siswa</a></li>
    <li class="breadcrumb-item active">Perbarui</li>
@endsection

@section('content')
<form action="{{ route('students.update', $student->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
                <div class="card-body p-0">
                    <div class="bg-warning py-4 text-center">
                        <div class="avatar-edit-container mx-auto mb-2">
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center mx-auto shadow-sm" style="width: 80px; height: 80px;">
                                <i class="fas fa-user-graduate fa-2x text-warning"></i>
                            </div>
                        </div>
                        <h5 class="text-white font-weight-bold mb-0">{{ $student->name }}</h5>
                        <p class="text-white-50 small mb-0">{{ $student->nis }}</p>
                    </div>

                    <div class="p-4">
                        <div class="form-group">
                            <label class="small text-uppercase font-weight-bold text-muted">Status Siswa Saat Ini</label>
                            <select name="status" class="form-control font-weight-bold text-dark border-warning">
                                <option value="active" {{ $student->status == 'active' ? 'selected' : '' }}>🟢 Aktif</option>
                                <option value="graduated" {{ $student->status == 'graduated' ? 'selected' : '' }}>🔵 Lulus</option>
                                <option value="moved" {{ $student->status == 'moved' ? 'selected' : '' }}>🟠 Pindah</option>
                                <option value="inactive" {{ $student->status == 'inactive' ? 'selected' : '' }}>🔴 Tidak Aktif</option>
                            </select>
                        </div>
                        <hr>
                        <div class="alert alert-light border mb-0 small">
                            <i class="fas fa-info-circle text-warning mr-1"></i> Perubahan status akan mempengaruhi validitas data pada laporan bulanan.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white py-3">
                    <h6 class="font-weight-bold text-dark mb-0">
                        <i class="fas fa-edit mr-2 text-warning"></i> Detail Informasi Profil
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Nomor Induk Siswa (NIS) <span class="text-danger">*</span></label>
                                <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis', $student->nis) }}" required>
                                @error('nis') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Kelas / Rombel <span class="text-danger">*</span></label>
                                <input type="text" name="class" class="form-control @error('class') is-invalid @enderror" value="{{ old('class', $student->class) }}" required>
                                @error('class') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Tempat Lahir</label>
                                <input type="text" name="place_of_birth" class="form-control" value="{{ old('place_of_birth', $student->place_of_birth) }}" placeholder="Kota Lahir">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal Lahir</label>
                                <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $student->date_of_birth) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Agama</label>
                                <select name="religion" class="form-control">
                                    <option value="">- Pilih -</option>
                                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $rel)
                                    <option value="{{ $rel }}" {{ old('religion', $student->religion) == $rel ? 'selected' : '' }}>{{ $rel }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Nama Lengkap Siswa <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $student->name) }}" required>
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Alamat Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}" placeholder="siswa@example.com">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">No. WhatsApp / Telepon</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}" placeholder="628xxxxxx">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Alamat Tinggal</label>
                        <textarea name="address" class="form-control" rows="3">{{ old('address', $student->address) }}</textarea>
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
                        <input type="text" name="father_name" class="form-control form-control-sm" value="{{ old('father_name', $student->father_name) }}" placeholder="Nama Ayah Kandung">
                    </div>
                     <div class="form-group">
                        <label>Pekerjaan Ayah</label>
                        <input type="text" name="father_job" class="form-control form-control-sm" value="{{ old('father_job', $student->father_job) }}" placeholder="Pekerjaan">
                    </div>
                    <div class="form-group">
                        <label>Nama Ibu</label>
                        <input type="text" name="mother_name" class="form-control form-control-sm" value="{{ old('mother_name', $student->mother_name) }}" placeholder="Nama Ibu Kandung">
                    </div>
                     <div class="form-group">
                        <label>Pekerjaan Ibu</label>
                        <input type="text" name="mother_job" class="form-control form-control-sm" value="{{ old('mother_job', $student->mother_job) }}" placeholder="Pekerjaan">
                    </div>
                     <div class="form-group">
                        <label>No. HP Orang Tua</label>
                        <input type="text" name="parent_phone" class="form-control form-control-sm" value="{{ old('parent_phone', $student->parent_phone) }}" placeholder="Kontak Ortu">
                    </div>
                     <div class="form-group">
                        <label>Alamat Orang Tua</label>
                        <textarea name="parent_address" class="form-control form-control-sm" rows="2">{{ old('parent_address', $student->parent_address) }}</textarea>
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
                        <input type="text" name="previous_school" class="form-control form-control-sm" value="{{ old('previous_school', $student->previous_school) }}" placeholder="SD/SMP Asal">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Diterima Tgl</label>
                                <input type="date" name="accepted_date" class="form-control form-control-sm" value="{{ old('accepted_date', $student->accepted_date) }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Di Kelas</label>
                                <input type="text" name="accepted_grade" class="form-control form-control-sm" value="{{ old('accepted_grade', $student->accepted_grade) }}" placeholder="X / VII">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light border-0 py-3 text-right">
                    <a href="{{ route('students.index') }}" class="btn btn-link text-muted font-weight-bold px-4">Batal</a>
                    <button type="submit" class="btn btn-warning px-5 shadow-sm font-weight-bold">
                        <i class="fas fa-sync-alt mr-1"></i> Perbarui Data Siswa
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    .avatar-edit-container { position: relative; width: fit-content; }
    .bg-warning { background-color: #f59e0b !important; } /* Warna Oranye Amber yang Mewah */
    .form-control { border-radius: 8px; border: 1px solid #e2e8f0; padding: 0.6rem 1rem; height: auto; }
    .form-control:focus { box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15); border-color: #f59e0b; }
    .card-footer { border-radius: 0 0 12px 12px !important; }
</style>
@endsection