@extends('backend.layouts.app')

@section('title', 'Edit Role')
@section('title_page', 'Edit Role & Akses')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Role</a></li>
  <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card card-warning card-outline shadow-sm border-0">
        <div class="card-header bg-white">
          <h5 class="font-weight-bold mb-0 text-warning"><i class="fas fa-shield-alt mr-2"></i> Edit Role:
            {{ $role->name }}</h5>
        </div>

        <form action="{{ route('roles.update', $role->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="card-body">

            <div class="form-group row">
              <label class="col-sm-2 col-form-label text-md-right">Nama Role <span class="text-danger">*</span></label>
              <div class="col-sm-6">
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                  value="{{ old('name', $role->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <hr>
            <h5 class="mb-3 pl-3 font-weight-bold">Atur Hak Akses (Permissions)</h5>

            <div class="row pl-3">
              @foreach($permissionGroups as $groupName => $permissions)
                <div class="col-md-3 mb-4">
                  <div class="card h-100 shadow-none border">
                    <div class="card-header bg-light py-2">
                      <h6 class="font-weight-bold mb-0 text-capitalize">{{ $groupName }}</h6>
                    </div>
                    <div class="card-body p-2">
                      @foreach($permissions as $permission)
                        <div class="custom-control custom-checkbox mb-1">
                          <input type="checkbox" class="custom-control-input" id="perm_{{ $permission->id }}"
                            name="permissions[]" value="{{ $permission->name }}" {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                          <label class="custom-control-label font-weight-normal" for="perm_{{ $permission->id }}">
                            {{ str_replace($groupName . '-', '', $permission->name) }}
                          </label>
                        </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              @endforeach
            </div>

          </div>
          <div class="card-footer bg-white text-right border-top-0 pb-4">
            <a href="{{ route('roles.index') }}" class="btn btn-secondary rounded-pill px-4 mr-2">Batal</a>
            <button type="submit" class="btn btn-warning text-white rounded-pill px-5 shadow-sm font-weight-bold">
              <i class="fas fa-save mr-2"></i> Update Role
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection