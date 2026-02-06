@extends('backend.layouts.app')

@section('title', 'Buku Agenda')
@section('title_page', 'Buku Agenda')

@section('breadcrumb')
    <li class="breadcrumb-item active">Buku Agenda</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!-- FILTER CARD -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-filter"></i> Filter Data</h3>
            </div>
            <form method="GET" action="{{ route('agenda.index') }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Jenis Agenda</label>
                                <select name="type" class="form-control">
                                    <option value="incoming" {{ $type == 'incoming' ? 'selected' : '' }}>Surat Masuk</option>
                                    <option value="outgoing" {{ $type == 'outgoing' ? 'selected' : '' }}>Surat Keluar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Mulai Tanggal</label>
                                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sampai Tanggal</label>
                                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i> Tampilkan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- RESULT CARD -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Hasil: 
                    @if($type == 'incoming') Agenda Surat Masuk @else Agenda Surat Keluar @endif
                </h3>
                <div class="card-tools">
                     <a href="{{ route('agenda.print', ['type' => $type, 'start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="btn btn-secondary btn-sm">
                        <i class="fas fa-print"></i> Cetak Laporan
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered text-nowrap">
                    <thead>
                        @if($type == 'incoming')
                            <tr class="bg-light">
                                <th>No. Agenda</th>
                                <th>Diterima Tgl</th>
                                <th>No. Surat</th>
                                <th>Tgl Surat</th>
                                <th>Pengirim</th>
                                <th>Perihal</th>
                                <th>Keterangan</th>
                            </tr>
                        @else
                             <tr class="bg-light">
                                <th>No. Agenda</th>
                                <th>No. Surat</th>
                                <th>Tgl Surat</th>
                                <th>Tujuan</th>
                                <th>Perihal</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        @endif
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                            <tr>
                                <td>{{ $item->agenda_number }}</td>
                                @if($type == 'incoming')
                                    <td>{{ $item->received_date->format('d/m/Y') }}</td>
                                    <td>{{ $item->mail_number }}</td>
                                    <td>{{ $item->mail_date->format('d/m/Y') }}</td>
                                    <td>{{ $item->sender_origin }}</td>
                                    <td style="white-space: normal; max-width: 300px;">{{ $item->subject }}</td>
                                    <td>{{ $item->category->name }} ({{ $item->status }})</td>
                                @else
                                    <td>{{ $item->mail_number }}</td>
                                    <td>{{ $item->mail_date->format('d/m/Y') }}</td>
                                    <td>{{ $item->recipient_destination }}</td>
                                    <td style="white-space: normal; max-width: 300px;">{{ $item->subject }}</td>
                                    <td>
                                        @if($item->status == 'sent')
                                            <span class="badge badge-success">Terkirim</span>
                                        @elseif($item->status == 'draft')
                                            <span class="badge badge-secondary">Konsep</span>
                                        @elseif($item->status == 'pending_approval')
                                            <span class="badge badge-warning">Menunggu Persetujuan</span>
                                        @elseif($item->status == 'approved')
                                            <span class="badge badge-info">Disetujui</span>
                                        @elseif($item->status == 'rejected')
                                            <span class="badge badge-danger">Ditolak</span>
                                        @else
                                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                        @endif
                                    </td>
                                    <td>{{ $item->category->name }}</td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data untuk periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
