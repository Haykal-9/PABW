{{-- resources/views/components/sidebar.blade.php --}}
@php
  $active = $activePage ?? '';
@endphp

<aside class="sidebar" aria-label="Sidebar navigation">
  <a class="btn-icon {{ $active==='kasir' ? 'active':'' }}"  href="{{ route('kasir.index') }}"       title="Kasir">
    <i class="fas fa-utensils"></i>
  </a>

  <a class="btn-icon {{ $active==='reservasi' ? 'active':'' }}" href="{{ route('kasir.reservasi') }}"  title="Reservasi">
    <i class="fas fa-calendar-check"></i>
  </a>

  <a class="btn-icon {{ $active==='notifikasi' ? 'active':'' }}" href="{{ route('kasir.notif') }}"     title="Notifikasi">
    <i class="fas fa-bell"></i>
  </a>

  <a class="btn-icon {{ $active==='profile' ? 'active':'' }}"    href="{{ route('kasir.profile') }}"   title="Profil">
    <i class="fas fa-user"></i>
  </a>

  <a class="btn-icon {{ $active==='history' ? 'active':'' }}"    href="{{ route('kasir.riwayat') }}"   title="Riwayat">
    <i class="fas fa-history"></i>
  </a>

  <div style="flex:1"></div>

  <a class="btn-icon" href="{{ url('/logout') }}" title="Logout" style="position:absolute;bottom:24px;left:0;width:100%;">
    <i class="fas fa-sign-out-alt"></i>
  </a>
</aside>
