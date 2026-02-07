@extends('backend.layouts.app')

@section('title', 'Edit Profil')

@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Edit Profil Saya</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <!-- Left Column: Profile Card -->
        <div class="col-md-4">
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                @if($user->profile_photo_path)
                  <img class="profile-user-img img-fluid img-circle"
                    src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="User profile picture"
                    style="width: 100px; height: 100px; object-fit: cover;">
                @else
                  <img class="profile-user-img img-fluid img-circle"
                    src="{{ asset('adminlte3/dist/img/user2-160x160.jpg') }}" alt="User profile picture">
                @endif
              </div>

              <h3 class="profile-username text-center">{{ $user->name }}</h3>
              <p class="text-muted text-center">{{ $user->roles->pluck('name')->first() ?? 'User' }}</p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                </li>
                <li class="list-group-item">
                  <b>Bergabung</b> <a class="float-right">{{ $user->created_at->format('d M Y') }}</a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Right Column: Edit Form -->
        <div class="col-md-8">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Pengaturan Akun</a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="active tab-pane" id="activity">
                  <form class="form-horizontal" method="POST" action="{{ route('profile.update') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                      <label for="inputName" class="col-sm-2 col-form-label">Nama Lengkap</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="name"
                          value="{{ old('name', $user->name) }}" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" name="email"
                          value="{{ old('email', $user->email) }}" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="inputPhoto" class="col-sm-2 col-form-label">Foto Profil</label>
                      <div class="col-sm-10">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="customFile" name="photo">
                          <label class="custom-file-label" for="customFile">Pilih file...</label>
                        </div>
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto.</small>
                      </div>
                    </div>

                    <hr>
                    <h5 class="mb-3 text-muted"><i class="fas fa-lock mr-2"></i> Ganti Password</h5>

                    <div class="form-group row">
                      <label for="inputPassword" class="col-sm-2 col-form-label">Password Baru</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword" name="password"
                          placeholder="Minimal 8 karakter">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="inputPasswordConfirmation" class="col-sm-2 col-form-label">Konfirmasi</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPasswordConfirmation"
                          name="password_confirmation" placeholder="Ulangi password baru">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan
                          Perubahan</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('js')
  <script>
    $(function () {
      // Custom File Input Label
      $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);

        // Preview Image
        if (this.files && this.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('.profile-user-img').attr('src', e.target.result);
          }
          reader.readAsDataURL(this.files[0]);
        }
      });
    });
  </script>
@endpush