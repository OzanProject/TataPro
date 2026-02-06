@extends('backend.layouts.app')

@section('title', 'Database Siswa')
@section('title_page', 'Manajemen Siswa')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Siswa</li>
@endsection

@push('css')
    <style>
        /* 1. Tombol Aksi Bulat & Modern */
        .btn-action-trigger {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            color: #64748b;
            padding: 0;
        }

        .btn-action-trigger:hover {

            border-color: #3b82f6;
            color: #3b82f6;
            background: #eff6ff;
        }

        /* Responsive Table */
        @media (min-width: 992px) {
            .table-responsive {
                overflow: visible !important;
            }
        }

        .card-body.table-responsive {
            padding-bottom: 100px !important;
        }

        /* Fix Table Mobile Scroll */
        .table-nowrap {
            white-space: nowrap;
        }

        /* Avatar Inisial */
        .avatar-student {
            width: 40px;
            height: 40px;
            background: #eff6ff;
            color: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 800;
            border: 2px solid #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white py-3">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <h5 class="font-weight-bold mb-2 mb-md-0 text-dark">
                            <i class="fas fa-user-graduate mr-2 text-primary"></i> Database Siswa
                        </h5>

                        <div class="d-flex flex-wrap align-items-center">
                            <form action="{{ route('students.index') }}" method="GET"
                                class="mr-2 mb-2 mb-md-0 w-auto flex-grow-1">
                                <div class="input-group input-group-sm rounded-pill bg-light border px-2"
                                    style="min-width: 200px;">
                                    <input type="text" name="search" class="form-control border-0 bg-transparent"
                                        placeholder="Cari NIS/Nama..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-link text-muted p-0"><i
                                                class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>

                            <div class="d-flex flex-wrap mb-2 mb-md-0">
                                <button type="button" class="btn btn-danger btn-sm px-3 mr-2 mb-1 d-none shadow-sm"
                                    id="btn-bulk-delete">
                                    <i class="fas fa-trash-alt mr-1"></i> Hapus (<span id="count-selected">0</span>)
                                </button>
                                <button type="button" class="btn btn-dark btn-sm px-3 mr-2 mb-1 d-none shadow-sm"
                                    id="btn-bulk-print" onclick="submitBulkPrint()">
                                    <i class="fas fa-print mr-1"></i> Cetak (<span id="count-selected-print">0</span>)
                                </button>
                                <a href="{{ route('students.create') }}"
                                    class="btn btn-primary btn-sm px-3 mr-2 mb-1 shadow-sm rounded">
                                    <i class="fas fa-plus-circle mr-1"></i> Tambah
                                </a>
                                <a href="{{ route('students.export') }}"
                                    class="btn btn-success btn-sm px-3 mr-2 mb-1 shadow-sm rounded">
                                    <i class="fas fa-file-export mr-1"></i> Export
                                </a>
                                <button type="button" class="btn btn-info btn-sm px-3 mb-1 shadow-sm rounded"
                                    data-toggle="modal" data-target="#modal-import">
                                    <i class="fas fa-file-import mr-1"></i> Import
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover align-middle border-0 text-nowrap" style="min-width: 800px;">
                        <thead class="bg-light text-uppercase small font-weight-bold text-muted">
                            <tr>
                                <th class="pl-4 py-3" width="50">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkAll">
                                        <label class="custom-control-label" for="checkAll"></label>
                                    </div>
                                </th>
                                <th class="border-0">No</th>
                                <th class="border-0">ID / NIS</th>
                                <th class="border-0">Identitas Siswa</th>
                                <th class="border-0">Kontak</th>
                                <th class="border-0 text-center">Kelas</th>
                                <th class="border-0 text-center">Status</th>
                                <th class="border-0 text-right pr-4">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr>
                                    <td class="pl-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="ids[]" class="custom-control-input check-item"
                                                id="check{{ $student->id }}" value="{{ $student->id }}" form="form-bulk-delete">
                                            <label class="custom-control-label" for="check{{ $student->id }}"></label>
                                        </div>
                                    </td>
                                    <td class="font-weight-bold text-muted">{{ $students->firstItem() + $loop->index }}</td>
                                    <td>
                                        <span class="font-weight-bold text-dark">{{ $student->nis }}</span>
                                        <div class="small text-muted">NISN: {{ $student->nisn ?? '---' }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-student mr-3">
                                                {{ strtoupper(substr($student->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-dark mb-0">{{ $student->name }}</div>
                                                <small
                                                    class="text-muted text-capitalize">{{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($student->email || $student->phone)
                                            @if($student->email)
                                                <div class="small text-muted"><i class="fas fa-envelope mr-1 text-primary"></i>
                                                    {{ $student->email }}</div>
                                            @endif
                                            @if($student->phone)
                                                <div class="small text-muted"><i class="fab fa-whatsapp mr-1 text-success"></i>
                                                    {{ $student->phone }}</div>
                                            @endif
                                        @else
                                            <span class="small text-muted font-italic">- Tidak ada data -</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-light border px-3 py-2 rounded-pill">
                                            {{ $student->class }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $stConfig = [
                                                'active' => ['c' => 'success', 'l' => 'Aktif'],
                                                'graduated' => ['c' => 'info', 'l' => 'Lulus'],
                                                'moved' => ['c' => 'warning', 'l' => 'Pindah']
                                            ];
                                            $status = $stConfig[$student->status] ?? ['c' => 'secondary', 'l' => 'Non-Aktif'];
                                        @endphp
                                        <span
                                            class="badge badge-{{ $status['c'] }} px-3 py-2 rounded-pill text-uppercase shadow-xs"
                                            style="font-size: 10px;">
                                            {{ $status['l'] }}
                                        </span>
                                    </td>
                                    <td class="text-right pr-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('generator.student.select', $student->id) }}"
                                                class="btn btn-info text-white shadow-sm" data-toggle="tooltip"
                                                title="Buat Surat">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                            <a href="{{ route('students.buku_induk', $student->id) }}" target="_blank"
                                                class="btn btn-secondary text-white shadow-sm" data-toggle="tooltip"
                                                title="Cetak Buku Induk">
                                                <i class="fas fa-book"></i>
                                            </a>
                                            <a href="{{ route('students.edit', $student->id) }}"
                                                class="btn btn-warning text-white shadow-sm" data-toggle="tooltip"
                                                title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger shadow-sm btn-delete-single"
                                                data-id="{{ $student->id }}" data-toggle="tooltip" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                            id="form-delete-{{ $student->id }}" class="d-none">
                                            @csrf @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-5 text-center text-muted italic">Tidak ada data siswa ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Form Bulk Delete Terpisah (Invisible) -->
                <form action="{{ route('students.bulk_destroy') }}" method="POST" id="form-bulk-delete" class="d-none">
                    @csrf
                </form>

                <form action="{{ route('students.bulk_print') }}" method="POST" id="form-bulk-print" target="_blank"
                    class="d-none">
                    @csrf
                </form>

                <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <p class="small text-muted mb-0">Total: <b>{{ $students->total() }}</b> siswa.</p>
                    {{ $students->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-header border-bottom-0 pt-4 px-4">
                    <h5 class="modal-title font-weight-bold text-dark">
                        <i class="fas fa-file-import mr-2 text-success"></i> Import Database Siswa
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body px-4 pb-4">
                        <div class="p-3 mb-4 rounded bg-light-info border-left border-info shadow-xs">
                            <p class="small text-dark font-weight-bold mb-2"><i
                                    class="fas fa-info-circle mr-1 text-info"></i> Informasi Penting</p>
                            <p class="small text-muted mb-3">Harap gunakan template resmi agar sistem tidak error saat
                                membaca data.</p>
                            <a href="{{ route('students.template') }}"
                                class="btn btn-info btn-block btn-sm shadow-sm rounded-pill font-weight-bold">
                                <i class="fas fa-download mr-1"></i> Unduh Template Excel
                            </a>
                        </div>

                        <div class="form-group mb-0">
                            <label class="small font-weight-bold text-muted text-uppercase mb-2">Pilih Berkas</label>
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="customFile" required
                                    accept=".xlsx, .xls">
                                <label class="custom-file-label border-light shadow-xs py-2" for="customFile"
                                    style="height: auto;">Pilih file spreadsheet...</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 px-4 pb-4">
                        <button type="button" class="btn btn-light btn-sm px-4 rounded-pill mr-2"
                            data-dismiss="modal">Batal</button>
                        <button type="submit"
                            class="btn btn-primary btn-sm px-4 shadow-sm rounded-pill font-weight-bold">Mulai
                            Sinkronisasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Update label file saat dipilih
        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        // Check All Functionality
        $("#checkAll").click(function () {
            $(".check-item").prop('checked', $(this).prop('checked'));
            toggleBulkDeleteBtn();
        });

        // Individual Check Functionality
        $(".check-item").change(function () {
            if (!$(this).prop("checked")) {
                $("#checkAll").prop("checked", false);
            }
            toggleBulkDeleteBtn();
        });

        // Toggle Bulk Delete Button
        function toggleBulkDeleteBtn() {
            var count = $(".check-item:checked").length;
            $("#count-selected").text(count);
            $("#count-selected-print").text(count);
            if (count > 0) {
                $("#btn-bulk-delete").removeClass("d-none");
                $("#btn-bulk-print").removeClass("d-none");
            } else {
                $("#btn-bulk-delete").addClass("d-none");
                $("#btn-bulk-print").addClass("d-none");
            }
        }

        // Bulk Delete Confirmation
        $("#btn-bulk-delete").click(function () {
            var count = $(".check-item:checked").length;
            Swal.fire({
                title: 'Hapus ' + count + ' data siswa?',
                text: "Data yang dipilih akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus Semua!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#form-bulk-delete").submit();
                }
            });
        });

        // Submit Bulk Print
        function submitBulkPrint() {
            var form = $("#form-bulk-print");
            form.empty(); // Clear old inputs
            form.append('@csrf');

            $(".check-item:checked").each(function () {
                form.append('<input type="hidden" name="ids[]" value="' + $(this).val() + '">');
            });

            form.submit();
        }

        // Single Delete Confirmation
        $(document).on('click', '.btn-delete-single', function (e) {
            let id = $(this).data('id');
            let form = $('#form-delete-' + id);
            Swal.fire({
                title: 'Hapus data siswa?',
                text: "Seluruh riwayat administrasi siswa ini akan ikut terhapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) { form.submit(); }
            });
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
@endpush