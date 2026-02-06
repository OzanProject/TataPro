@extends('backend.layouts.app')

@section('title', 'Isi Data Dokumen')
@section('title_page', 'Isi Data: ' . $template->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('generator.index') }}">Generator</a></li>
    <li class="breadcrumb-item active">Isi Data</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Input Variabel</h3>
                </div>

                <form action="{{ route('generator.store', $template->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <p class="text-muted">Silakan lengkapi data berikut untuk mengisi template otomatis.</p>

                        @forelse($template->variables ?? [] as $var)
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right font-weight-normal">
                                    {{ ucfirst(str_replace('_', ' ', $var)) }}
                                    @if(!isset($data[$var])) <span class="text-danger">*</span> @endif
                                </label>
                                <div class="col-sm-8">
                                    @php
                                        $label = strtolower($var);
                                        $isLongText = Str::contains($label, ['dasar', 'isi', 'alasan', 'keperluan', 'agenda']);
                                        // Fix: detect 'tanggal' but exclude 'tempat' so 'tempat_lahir' is not a date
                                        $isDate = Str::contains($label, ['tanggal', 'date']) && !Str::contains($label, 'tempat');
                                        $isTime = Str::contains($label, ['waktu', 'pukul']);
                                    @endphp

                                    @if($isLongText)
                                        <textarea name="{{ $var }}" class="form-control" rows="4" placeholder="Masukkan {{ str_replace('_', ' ', $var) }}..." required>{{ $data[$var] ?? '' }}</textarea>
                                    @elseif($isDate)
                                        <input type="date" name="{{ $var }}" class="form-control" value="{{ $data[$var] ?? '' }}" required>
                                    @elseif($isTime)
                                        <input type="time" name="{{ $var }}" class="form-control" value="{{ $data[$var] ?? '' }}" required>
                                    @else
                                        <input type="text" name="{{ $var }}" class="form-control"
                                            placeholder="Masukkan {{ str_replace('_', ' ', $var) }}..."
                                            value="{{ $data[$var] ?? '' }}" required>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">Template ini tidak memiliki variabel khusus. Langsung generate saja.</div>
                        @endforelse

                    </div>

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-success btn-lg px-5"><i class="fas fa-file-download"></i>
                            Generate & Download</button>
                        <br>
                        <a href="{{ route('generator.index') }}" class="btn btn-link mt-2 text-muted">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection