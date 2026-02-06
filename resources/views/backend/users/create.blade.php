@extends('backend.layouts.app')

@section('title', 'Tambah User')
@section('title_page', 'Tambah Data Pengguna')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
  <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card card-primary card-outline shadow-sm border-0">
        <div class="card-header bg-white">
          <h5 class="font-weight-bold mb-0 text-primary"><i class="fas fa-user-plus mr-2"></i> Form Input User</h5>
        </div>

        <form action="{{ route('users.store') }}" method="POST">
          @csrf
          <div class="card-body">

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Nama Lengkap <span class="text-danger">*</span></label>
              <div class="col-sm-9">
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                  value="{{ old('name') }}" placeholder="Nama User" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Email <span class="text-danger">*</span></label>
              <div class="col-sm-9">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                  value="{{ old('email') }}" placeholder="Email Login" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Password <span class="text-danger">*</span></label>
              <div class="col-sm-9">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                  placeholder="Minimal 6 karakter" required>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Konfirmasi Password <span
                  class="text-danger">*</span></label>
              <div class="col-sm-9">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi Password"
                  required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Role / Hak Akses <span
                  class="text-danger">*</span></label>
              <div class="col-sm-9">
                <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                  <option value="">-- Pilih Role --</option>
                  @foreach($roles as $role)
                    <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                  @endforeach
                </select>
                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

          </div>
          <div class="card-footer bg-white text-right border-top-0 pb-4">
            <a href="{{ route('users.index') }}" class="btn btn-secondary rounded-pill px-4 mr-2">Batal</a>
            <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm font-weight-bold">
              <i class="fas fa-save mr-2"></i> Simpan User
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection