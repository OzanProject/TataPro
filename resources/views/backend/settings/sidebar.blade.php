<div class="card shadow-sm border-0 rounded-lg">
  <div class="list-group list-group-flush rounded-lg">
    <a href="{{ route('settings.school') }}"
      class="list-group-item list-group-item-action {{ Request::routeIs('settings.school') ? 'active font-weight-bold' : '' }}">
      <i class="fas fa-school mr-2"></i> Identitas Sekolah
    </a>
    <a href="#" class="list-group-item list-group-item-action disabled">
      <i class="fas fa-envelope mr-2"></i> Pengaturan Surat (SMTP)
    </a>
    <a href="#" class="list-group-item list-group-item-action disabled">
      <i class="fas fa-palette mr-2"></i> Tampilan Aplikasi
    </a>
    <a href="#" class="list-group-item list-group-item-action disabled">
      <i class="fas fa-database mr-2"></i> Backup & Restore
    </a>
  </div>
</div>