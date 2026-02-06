@extends('backend.layouts.app')

@section('title', 'Identitas Sekolah')
@section('title_page', 'Pengaturan Sekolah')

@section('breadcrumb')
  <li class="breadcrumb-item active">Pengaturan Sekolah</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-3">
      @include('backend.settings.sidebar')
    </div>

    <div class="col-md-9">
      <form action="{{ route('settings.school.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="card shadow-sm border-0 rounded-lg mb-4">
          <div class="card-header bg-white py-3">
            <h5 class="font-weight-bold mb-0 text-dark"><i class="fas fa-university mr-2 text-primary"></i> Identitas
              Instansi</h5>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label>Nama Sekolah / Instansi <span class="text-danger">*</span></label>
              <input type="text" name="school_name" class="form-control" value="{{ $settings['school_name'] ?? '' }}"
                required>
            </div>
            <div class="form-group">
              <label>Alamat Lengkap</label>
              <textarea name="school_address" class="form-control"
                rows="3">{{ $settings['school_address'] ?? '' }}</textarea>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nomor Telepon</label>
                  <input type="text" name="school_phone" class="form-control"
                    value="{{ $settings['school_phone'] ?? '' }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Email Resmi</label>
                  <input type="email" name="school_email" class="form-control"
                    value="{{ $settings['school_email'] ?? '' }}">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Website</label>
              <input type="url" name="school_website" class="form-control"
                value="{{ $settings['school_website'] ?? '' }}">
            </div>
          </div>
        </div>

        <div class="card shadow-sm border-0 rounded-lg mb-4">
          <div class="card-header bg-white py-3">
            <h5 class="font-weight-bold mb-0 text-dark"><i class="fas fa-user-tie mr-2 text-info"></i> Kepala Sekolah</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nama Kepala Sekolah</label>
                  <input type="text" name="principal_name" class="form-control"
                    value="{{ $settings['principal_name'] ?? '' }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>NIP / NUPTK</label>
                  <input type="text" name="principal_nip" class="form-control"
                    value="{{ $settings['principal_nip'] ?? '' }}">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card shadow-sm border-0 rounded-lg mb-4">
          <div class="card-header bg-white py-3">
            <h5 class="font-weight-bold mb-0 text-dark"><i class="fas fa-images mr-2 text-warning"></i> Logo & Atribut
              Surat</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4 text-center">
                <label class="d-block mb-3">Logo Sekolah</label>
                @if(isset($settings['school_logo']))
                  <div class="mb-3">
                    <img src="{{ asset('storage/' . $settings['school_logo']) }}" class="img-thumbnail"
                      style="height: 100px;">
                  </div>
                @endif
                <div class="custom-file text-left">
                  <input type="file" name="school_logo" class="custom-file-input" id="logoSchool">
                  <label class="custom-file-label" for="logoSchool">Ganti Logo...</label>
                </div>
              </div>
              <div class="col-md-4 text-center">
                <label class="d-block mb-3">Logo Dinas / Yayasan</label>
                @if(isset($settings['dinas_logo']))
                  <div class="mb-3">
                    <img src="{{ asset('storage/' . $settings['dinas_logo']) }}" class="img-thumbnail"
                      style="height: 100px;">
                  </div>
                @endif
                <div class="custom-file text-left">
                  <input type="file" name="dinas_logo" class="custom-file-input" id="logoDinas">
                  <label class="custom-file-label" for="logoDinas">Ganti Logo...</label>
                </div>
              </div>
            </div> <!-- End Row Logo -->

            <hr class="my-4">

            <h6 class="font-weight-bold mb-3 text-info">Pengaturan Kop Surat (Teks)</h6>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Baris 1 (Pemerintah/Yayasan)</label>
                  <input type="text" name="kop_line1" class="form-control"
                    value="{{ $settings['kop_line1'] ?? 'PEMERINTAH KABUPATEN ...' }}"
                    placeholder="Contoh: PEMERINTAH KABUPATEN CIANJUR">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Baris 2 (Dinas/Lembaga)</label>
                  <input type="text" name="kop_line2" class="form-control"
                    value="{{ $settings['kop_line2'] ?? 'DINAS PENDIDIKAN ...' }}"
                    placeholder="Contoh: DINAS PENDIDIKAN PEMUDA DAN OLAH RAGA">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>Alamat Lengkap (Kop)</label>
                  <input type="text" name="kop_address" class="form-control" value="{{ $settings['kop_address'] ?? '' }}"
                    placeholder="Jalan... Desa... Kec...">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>Kontak (Email / NPSN)</label>
                  <input type="text" name="kop_contact" class="form-control" value="{{ $settings['kop_contact'] ?? '' }}"
                    placeholder="Email: ... NPSN: ...">
                </div>
              </div>
            </div>

                </div>
            </div>

            <!-- Removed Manual Kop Upload - Replaced by Dynamic Text Generation -->
            {{--
            <div class="row mt-3">
              <div class="col-md-4 text-center">
                <label class="d-block mb-3">Kop Surat (Gambar Full)</label>
                @if(isset($settings['letterhead']))
                  <div class="mb-3">
                    <img src="{{ asset('storage/' . $settings['letterhead']) }}" class="img-thumbnail"
                      style="height: 100px;">
                  </div>
                @endif
                <div class="custom-file text-left">
                  <input type="file" name="letterhead" class="custom-file-input" id="letterHead">
                  <label class="custom-file-label" for="letterHead">Upload Gambar Manual...</label>
                </div>
                <small class="text-muted">Upload jika ingin menggunakan gambar kop sendiri.</small>
              </div>
            </div>
            --}}
          </div>
          <div class="card-footer bg-white text-right">
            <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm font-weight-bold">
              <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
          </div>
        </div>

      </form>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(".custom-file-input").on("change", function () {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
  </script>
@endpush