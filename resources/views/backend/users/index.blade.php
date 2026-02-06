@extends('backend.layouts.app')

@section('title', 'Manajemen User')
@section('title_page', 'Kelola Pengguna Sistem')

@section('breadcrumb')
  <li class="breadcrumb-item active">Manajemen User</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card card-outline card-primary shadow-sm">
        <div class="card-header border-0">
          <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold">Daftar Pengguna</h3>
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm rounded">
              <i class="fas fa-plus-circle mr-1"></i> Tambah User
            </a>
          </div>
        </div>

        <div class="card-body table-responsive p-0">
          <table class="table table-hover align-middle border-0 text-nowrap">
            <thead class="bg-light">
              <tr>
                <th class="pl-4" style="width: 5%;">No</th>
                <th style="width: 25%;">Nama</th>
                <th style="width: 25%;">Email</th>
                <th style="width: 15%;">Role</th>
                <th style="width: 15%;">Tanggal Dibuat</th>
                <th class="text-right pr-4" style="width: 15%;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $user)
                <tr>
                  <td class="pl-4 font-weight-bold text-muted">{{ $users->firstItem() + $loop->index }}</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div
                        class="avatar-sm mr-3 bg-light text-primary rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 35px; height: 35px; font-weight: bold;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                      </div>
                      <span class="font-weight-bold text-dark">{{ $user->name }}</span>
                    </div>
                  </td>
                  <td>{{ $user->email }}</td>
                  <td>
                    @foreach($user->roles as $role)
                      <span class="badge badge-info px-2 rounded-pill">{{ $role->name }}</span>
                    @endforeach
                  </td>
                  <td class="text-muted">{{ $user->created_at->format('d M Y') }}</td>
                  <td class="text-right pr-4">
                    <div class="btn-group btn-group-sm">
                      <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning text-white shadow-sm"
                        data-toggle="tooltip" title="Edit">
                        <i class="fas fa-edit"></i>
                      </a>
                      @if(auth()->id() !== $user->id)
                        <button type="button" class="btn btn-danger shadow-sm btn-delete" data-id="{{ $user->id }}"
                          data-toggle="tooltip" title="Hapus">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      @endif
                    </div>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" id="form-delete-{{ $user->id }}"
                      class="d-none">
                      @csrf @method('DELETE')
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center py-5">
                    <img src="{{ asset('adminlte3/dist/img/empty.svg') }}" style="width: 100px; opacity: 0.5;">
                    <h6 class="text-muted mt-3">Belum ada user.</h6>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="card-footer bg-white border-0">
          {{ $users->links() }}
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
        title: 'Hapus User?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
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