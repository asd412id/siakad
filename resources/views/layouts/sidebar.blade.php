<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="{{ route('home') }}" class="brand-link">
    <img src="{{ asset('img') }}/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
      style="opacity: .8">
    <span class="brand-text">SIAKAD</span>
  </a>
  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img
          src="{{ asset('img').(auth()->user()->is_admin || (auth()->user()->dosen &&  auth()->user()->dosen->jenis_kelamin=='L') || (auth()->user()->mahasiswa && auth()->user()->mahasiswa->jenis_kelamin=='L')?'/avatar5.png':'/avatar3.png') }}"
          class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" data-url="{{ route('account') }}" class="open-modal" title="{{ auth()->user()->name }}">{{
          auth()->user()->name }}</a>
      </div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home')?'active':'' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Beranda</p>
          </a>
        </li>
        @if (auth()->user()->role == 0 || auth()->user()->role == 3)
        @if (auth()->user()->isAdmin)
        <li class="nav-item">
          <a href="{{ route('prodi.index') }}" class="nav-link {{ request()->routeIs('prodi*')?'active':'' }}">
            <i class="nav-icon fas fa-building"></i>
            <p>Program Studi</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('operator.index') }}" class="nav-link {{ request()->routeIs('operator*')?'active':'' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>Operator</p>
          </a>
        </li>
        @endif
        <li class="nav-item">
          <a href="{{ route('matakuliah.index') }}"
            class="nav-link {{ request()->routeIs('matakuliah*')?'active':'' }}">
            <i class="nav-icon fas fa-book"></i>
            <p>Mata Kuliah</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('dosen.index') }}" class="nav-link {{ request()->routeIs('dosen*')?'active':'' }}">
            <i class="nav-icon fas fa-user-graduate"></i>
            <p>Dosen</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('mahasiswa.index') }}" class="nav-link {{ request()->routeIs('mahasiswa*')?'active':'' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>Mahasiswa</p>
          </a>
        </li>
        @endif
        <li class="nav-item">
          <a href="{{ route('study.index') }}" class="nav-link {{ request()->routeIs('study*')?'active':'' }}">
            <i class="nav-icon fas fa-file-contract"></i>
            <p>Data Studi Mahasiswa</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>