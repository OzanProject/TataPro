@extends('backend.layouts.app')

@section('title', 'Tambah Guru')
@section('title_page', 'Tambah Data Guru')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">Data Guru</a></li>
  <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card card-primary card-outline shadow-sm border-0">
        <div class="card-header bg-white">
          <h5 class="font-weight-bold mb-0 text-primary"><i class="fas fa-plus-circle mr-2"></i> Form Input Data Guru</h5>
        </div>

        <form action="{{ route('teachers.store') }}" method="POST">
          @csrf
          <div class="card-body">

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">NIP / NUPTK</label>
              <div class="col-sm-9">
                <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror"
                  value="{{ old('nip') }}" placeholder="Kosongkan jika belum ada">
                @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Nama Lengkap <span class="text-danger">*</span></label>
              <div class="col-sm-9">
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                  value="{{ old('name') }}" placeholder="Nama beserta gelar..." required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Jenis Kelamin <span
                  class="text-danger">*</span></label>
              <div class="col-sm-9">
                <div class="d-flex mt-2">
                  <div class="custom-control custom-radio mr-4">
                    <input class="custom-control-input" type="radio" id="gender_l" name="gender" value="L" {{ old('gender') == 'L' ? 'checked' : '' }} required>
                    <label for="gender_l" class="custom-control-label">Laki-laki</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="gender_p" name="gender" value="P" {{ old('gender') == 'P' ? 'checked' : '' }}>
                    <label for="gender_p" class="custom-control-label">Perempuan</label>
                  </div>
                </div>
                @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Jabatan <span class="text-danger">*</span></label>
              <div class="col-sm-9">
                <select name="position" class="form-control @error('position') is-invalid @enderror" required>
                  <option value="Guru Mata Pelajaran" {{ old('position') == 'Guru Mata Pelajaran' ? 'selected' : '' }}>Guru
                    Mata Pelajaran</option>
                  <option value="Wali Kelas" {{ old('position') == 'Wali Kelas' ? 'selected' : '' }}>Wali Kelas</option>
                  <option value="Kepala Sekolah" {{ old('position') == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah
                  </option>
                  <option value="Tenaga Kependidikan" {{ old('position') == 'Tenaga Kependidikan' ? 'selected' : '' }}>
                    Tenaga Kependidikan</option>
                </select>
                @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Email</label>
              <div class="col-sm-9">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                  value="{{ old('email') }}" placeholder="Email aktif...">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">No. HP</label>
              <div class="col-sm-9">
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                  value="{{ old('phone') }}" placeholder="No. HP / WhatsApp...">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Status</label>
              <div class="col-sm-9">
                <select name="status" class="form-control">
                  <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif Mengajar</option>
                  <option value="retired" {{ old('status') == 'retired' ? 'selected' : '' }}>Pensiun</option>
                  <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
              </div>
            </div>

          </div>
          <div class="card-footer bg-white text-right border-top-0 pb-4">
            <a href="{{ route('teachers.index') }}" class="btn btn-secondary rounded-pill px-4 mr-2">Batal</a>
            <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm font-weight-bold">
              <i class="fas fa-save mr-2"></i> Simpan Data
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection