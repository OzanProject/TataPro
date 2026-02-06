@extends('backend.layouts.app')

@section('title', 'Edit Data Guru')
@section('title_page', 'Edit Data Guru')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">Data Guru</a></li>
  <li class="breadcrumb-item active">Edit Data</li>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card card-warning card-outline shadow-sm border-0">
        <div class="card-header bg-white">
          <h5 class="font-weight-bold mb-0 text-dark"><i class="fas fa-edit mr-2 text-warning"></i> Edit Guru:
            {{ $teacher->name }}</h5>
        </div>

        <form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
          @csrf @method('PUT')
          <div class="card-body">

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">NIP / NUPTK</label>
              <div class="col-sm-9">
                <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror"
                  value="{{ old('nip', $teacher->nip) }}">
                @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Nama Lengkap <span class="text-danger">*</span></label>
              <div class="col-sm-9">
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                  value="{{ old('name', $teacher->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Jenis Kelamin <span
                  class="text-danger">*</span></label>
              <div class="col-sm-9">
                <div class="d-flex mt-2">
                  <div class="custom-control custom-radio mr-4">
                    <input class="custom-control-input" type="radio" id="gender_l" name="gender" value="L" {{ old('gender', $teacher->gender) == 'L' ? 'checked' : '' }} required>
                    <label for="gender_l" class="custom-control-label">Laki-laki</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="gender_p" name="gender" value="P" {{ old('gender', $teacher->gender) == 'P' ? 'checked' : '' }}>
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
                  <option value="Guru Mata Pelajaran" {{ old('position', $teacher->position) == 'Guru Mata Pelajaran' ? 'selected' : '' }}>Guru Mata Pelajaran</option>
                  <option value="Wali Kelas" {{ old('position', $teacher->position) == 'Wali Kelas' ? 'selected' : '' }}>
                    Wali Kelas</option>
                  <option value="Kepala Sekolah" {{ old('position', $teacher->position) == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                  <option value="Tenaga Kependidikan" {{ old('position', $teacher->position) == 'Tenaga Kependidikan' ? 'selected' : '' }}>Tenaga Kependidikan</option>
                </select>
                @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Email</label>
              <div class="col-sm-9">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                  value="{{ old('email', $teacher->email) }}">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">No. HP</label>
              <div class="col-sm-9">
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                  value="{{ old('phone', $teacher->phone) }}">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Status</label>
              <div class="col-sm-9">
                <select name="status" class="form-control">
                  <option value="active" {{ old('status', $teacher->status) == 'active' ? 'selected' : '' }}>Aktif Mengajar
                  </option>
                  <option value="retired" {{ old('status', $teacher->status) == 'retired' ? 'selected' : '' }}>Pensiun
                  </option>
                  <option value="inactive" {{ old('status', $teacher->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif
                  </option>
                </select>
              </div>
            </div>

          </div>
          <div class="card-footer bg-white text-right border-top-0 pb-4">
            <a href="{{ route('teachers.index') }}" class="btn btn-secondary rounded-pill px-4 mr-2">Batal</a>
            <button type="submit" class="btn btn-warning rounded-pill px-5 shadow-sm font-weight-bold text-white">
              <i class="fas fa-save mr-2"></i> Update Data
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection