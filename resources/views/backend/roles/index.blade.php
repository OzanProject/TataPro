@extends('backend.layouts.app')

@section('title', 'Hak Akses & Role')
@section('title_page', 'Kelola Hak Akses Pengguna')

@section('breadcrumb')
  <li class="breadcrumb-item active">Hak Akses</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card card-outline card-primary shadow-sm">
        <div class="card-header border-0">
          <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold">Daftar Role</h3>
            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm rounded">
              <i class="fas fa-plus-circle mr-1"></i> Tambah Role
            </a>
          </div>
        </div>

        <div class="card-body table-responsive p-0">
          <table class="table table-hover align-middle border-0">
            <thead class="bg-light">
              <tr>
                <th class="pl-4" style="width: 5%;">No</th>
                <th style="width: 20%;">Role</th>
                <th style="width: 60%;">Permissions / Hak Akses</th>
                <th class="text-right pr-4" style="width: 15%;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($roles as $role)
                <tr>
                  <td class="pl-4 font-weight-bold text-muted">{{ $roles->firstItem() + $loop->index }}</td>
                  <td>
                    <span class="font-weight-bold text-dark text-capitalize">{{ $role->name }}</span>
                    <br>
                    <small class="text-muted">Guard: {{ $role->guard_name }}</small>
                  </td>
                  <td>
                    @foreach($role->permissions->take(8) as $permission)
                      <span class="badge badge-light border mr-1 mb-1">{{ $permission->name }}</span>
                    @endforeach
                    @if($role->permissions->count() > 8)
                      <span class="badge badge-secondary mr-1 mb-1">+{{ $role->permissions->count() - 8 }} more</span>
                    @endif
                  </td>
                  <td class="text-right pr-4">
                    <div class="btn-group btn-group-sm">
                      <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning text-white shadow-sm"
                        data-toggle="tooltip" title="Edit">
                        <i class="fas fa-edit"></i>
                      </a>
                      @if($role->name != 'admin')
                        <button type="button" class="btn btn-danger shadow-sm btn-delete text-white" data-id="{{ $role->id }}"
                          data-toggle="tooltip" title="Hapus">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" id="form-delete-{{ $role->id }}"
                          class="d-none">
                          @csrf @method('DELETE')
                        </form>
                      @endif
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center py-5">
                    <img src="{{ asset('adminlte3/dist/img/empty.svg') }}" style="width: 100px; opacity: 0.5;">
                    <h6 class="text-muted mt-3">Belum ada role.</h6>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="card-footer bg-white border-0">
          {{ $roles->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).on('click', '.btn-delete', function (e) {
      let id = $(this).data('id');
      let form = $('#form-delete-' + id);
      Swal.fire({
        title: 'Hapus Role?',
        text: "Role yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) { form.submit(); }
      });
    });
  </script>
@endpush