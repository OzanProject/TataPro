@extends('backend.layouts.app')

@section('title', 'Cari Arsip')
@section('title_page', 'Pencarian Arsip Digital')

@section('breadcrumb')
    <li class="breadcrumb-item active">Cari Arsip</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <!-- Search Form -->
        <div class="text-center mb-5 mt-4">
            <h2 class="display-4">Cari Surat</h2>
            <form action="{{ route('archive.index') }}" method="GET">
                <div class="input-group input-group-lg">
                    <input type="search" name="q" class="form-control form-control-lg form-control-border" placeholder="Ketik nomor surat, perihal, atau pengirim..." value="{{ $query }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-lg btn-default">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results -->
        @if($query)
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Hasil Pencarian: "{{ $query }}"</h3>
                    <div class="card-tools">
                        <span class="badge badge-primary">{{ $results->count() }} hasil ditemukan</span>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                            <th>No. Surat</th>
                            <th>Perihal</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($results as $item)
                        <tr>
                            <td>
                                @if($item->type == 'Surat Masuk')
                                    <span class="badge badge-info"><i class="fas fa-inbox"></i> Masuk</span>
                                @else
                                    <span class="badge badge-success"><i class="fas fa-paper-plane"></i> Keluar</span>
                                @endif
                            </td>
                            <td>{{ $item->date->format('d/m/Y') }}</td>
                            <td>{{ $item->mail_number }}</td>
                            <td>{{ $item->subject }}</td>
                            <td>
                                <a href="{{ route($item->route_name, $item->id) }}" class="text-muted">
                                    <i class="fas fa-search"></i> Lihat
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-folder-open fa-3x mb-3"></i><br>
                                Tidak ditemukan data yang cocok.
                            </td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
