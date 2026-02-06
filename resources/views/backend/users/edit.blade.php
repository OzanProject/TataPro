@extends('backend.layouts.app')

@section('title', 'Edit User')
@section('title_page', 'Edit Data Pengguna')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
  <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card card-warning card-outline shadow-sm border-0">
        <div class="card-header bg-white">
          <h5 class="font-weight-bold mb-0 text-warning"><i class="fas fa-user-edit mr-2"></i> Form Edit User</h5>
        </div>

        <form action="{{ route('users.update', $user->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="card-body">

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Nama Lengkap <span class="text-danger">*</span></label>
              <div class="col-sm-9">
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                  value="{{ old('name', $user->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Email <span class="text-danger">*</span></label>
              <div class="col-sm-9">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                  value="{{ old('email', $user->email) }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Password Baru</label>
              <div class="col-sm-9">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                  placeholder="Biarkan kosong jika tidak merubah password">
                <small class="text-muted">Isi hanya jika ingin mengganti password.</small>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Konfirmasi Password</label>
              <div class="col-sm-9">
                <input type="password" name="password_confirmation" class="form-control"
                  placeholder="Ulangi Password Baru">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label text-md-right">Role / Hak Akses <span
                  class="text-danger">*</span></label>
              <div class="col-sm-9">
                <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                  <option value="">-- Pilih Role --</option>
                  @foreach($roles as $role)
                    <option value="{{ $role }}" {{ (old('role') ?? $user->roles->first()->name ?? '') == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                  @endforeach
                </select>
                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

          </div>
          <div class="card-footer bg-white text-right border-top-0 pb-4">
            <a href="{{ route('users.index') }}" class="btn btn-secondary rounded-pill px-4 mr-2">Batal</a>
            <button type="submit" class="btn btn-warning text-white rounded-pill px-5 shadow-sm font-weight-bold">
              <i class="fas fa-save mr-2"></i> Update User
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection