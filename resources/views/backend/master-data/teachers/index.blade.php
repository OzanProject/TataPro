@extends('backend.layouts.app')

@section('title', 'Data Guru')
@section('title_page', 'Database Guru & Karyawan')

@section('breadcrumb')
  <li class="breadcrumb-item active">Data Guru</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card card-outline card-primary shadow-sm">
        <div class="card-header border-0">
          <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
            <form action="{{ route('teachers.index') }}" method="GET" class="mb-2 mb-md-0">
              <div class="input-group input-group-sm rounded-pill bg-light border px-2" style="min-width: 250px;">
                <input type="text" name="search" class="form-control border-0 bg-transparent"
                  placeholder="Cari NIP/Nama/Jabatan..." value="{{ request('search') }}">
                <div class="input-group-append">
                  <button type="submit" class="btn btn-link text-muted p-0"><i class="fas fa-search"></i></button>
                </div>
              </div>
            </form>

            <div>
              <a href="{{ route('teachers.export') }}" class="btn btn-success btn-sm px-3 shadow-sm rounded mr-2">
                <i class="fas fa-file-excel mr-1"></i> Export
              </a>
              <button type="button" class="btn btn-info btn-sm px-3 shadow-sm rounded mr-2" data-toggle="modal"
                data-target="#importTeacherModal">
                <i class="fas fa-file-upload mr-1"></i> Import
              </button>
              <a href="{{ route('teachers.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm rounded">
                <i class="fas fa-plus-circle mr-1"></i> Tambah
              </a>
            </div>
          </div>
        </div>

        <div class="card-body table-responsive p-0">
          <table class="table table-hover align-middle border-0 text-nowrap" style="min-width: 800px;">
            <thead class="bg-light">
              <tr>
                <th class="pl-4" style="width: 5%;">No</th>
                <th style="width: 15%;">NIP</th>
                <th style="width: 25%;">Nama Lengkap</th>
                <th style="width: 20%;">Jabatan</th>
                <th style="width: 15%;">Status</th>
                <th class="text-right pr-4" style="width: 20%;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($teachers as $teacher)
                <tr>
                  <td class="pl-4 font-weight-bold text-muted">{{ $teachers->firstItem() + $loop->index }}</td>
                  <td>
                    <span class="font-weight-bold text-dark">{{ $teacher->nip ?? '-' }}</span>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div
                        class="avatar-student mr-3 bg-light text-primary rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 35px; height: 35px; font-weight: bold;">
                        {{ strtoupper(substr($teacher->name, 0, 1)) }}
                      </div>
                      <div>
                        <div class="font-weight-bold text-dark mb-0">{{ $teacher->name }}</div>
                        <small
                          class="text-muted text-capitalize">{{ $teacher->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</small>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="badge badge-info px-2 rounded-pill font-weight-normal">{{ $teacher->position }}</span>
                  </td>
                  <td>
                    <span class="badge badge-success px-2 rounded-pill text-uppercase"
                      style="font-size: 10px;">{{ $teacher->status }}</span>
                  </td>
                  <td class="text-right pr-4">
                    <div class="btn-group btn-group-sm">
                      <!-- Generator Button Here -->
                      <a href="{{ route('generator.teacher.select', $teacher->id) }}"
                        class="btn btn-info text-white shadow-sm" data-toggle="tooltip" title="Buat Surat">
                        <i class="fas fa-file-alt"></i>
                      </a>

                      <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-warning text-white shadow-sm"
                        data-toggle="tooltip" title="Edit">
                        <i class="fas fa-edit"></i>
                      </a>
                      <button type="button" class="btn btn-danger shadow-sm btn-delete-single" data-id="{{ $teacher->id }}"
                        data-toggle="tooltip" title="Hapus">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </div>
                    <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST"
                      id="form-delete-{{ $teacher->id }}" class="d-none">
                      @csrf @method('DELETE')
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center py-5">
                    <img src="{{ asset('adminlte3/dist/img/empty.svg') }}" style="width: 100px; opacity: 0.5;">
                    <h6 class="text-muted mt-3">Belum ada data guru.</h6>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="card-footer bg-white border-0">
          {{ $teachers->links() }}
        </div>
      </div>
    </div>
  </div>

  <!-- Import Modal -->
  <div class="modal fade" id="importTeacherModal" tabindex="-1" role="dialog" aria-labelledby="importTeacherModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="{{ route('teachers.import') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="importTeacherModalLabel">Import Data Guru</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="file">Pilih File Excel (.xlsx, .xls, .csv)</label>
              <input type="file" name="file" class="form-control-file" required>
              <small class="form-text text-muted">Pastikan format kolom sesuai dengan template (NIP, Nama, dll).</small>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <a href="{{ route('teachers.template') }}" class="btn btn-success btn-sm">
              <i class="fas fa-download mr-1"></i> Download Template
            </a>
            <div>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Upload & Import</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).on('click', '.btn-delete-single', function (e) {
      let id = $(this).data('id');
      let form = $('#form-delete-' + id);
      Swal.fire({
        title: 'Hapus data guru?',
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