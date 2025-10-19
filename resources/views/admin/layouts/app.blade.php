@extends('customers.layouts.app')

{{-- FIX: Menggunakan @section block untuk menimpa title di browser --}}
@section('title')
    Admin - @yield('admin_page_title')
@endsection
{{-- End Fix --}}

{{-- PERBAIKAN: Menggunakan section 'admin_layout' agar konten tidak bentrok dengan layout induk --}}
@section('admin_layout') 
<div class="d-flex" id="wrapper">
    
    {{-- Sidebar Content --}}
    <div class="bg-dark border-right" id="sidebar-wrapper" style="min-height: 100vh; width: 250px;">
        <div class="sidebar-heading bg-dark text-white p-3 border-bottom border-secondary fw-bold">
             <i class="fas fa-cog me-2"></i> TapalKuda Admin
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary {{ request()->is('admin') ? 'active bg-secondary' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a href="{{ route('admin.menu') }}" class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary {{ request()->is('admin/menu') ? 'active bg-secondary' : '' }}">
                <i class="fas fa-coffee me-2"></i> Daftar Menu
            </a>
            <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary {{ request()->is('admin/users') ? 'active bg-secondary' : '' }}">
                <i class="fas fa-users me-2"></i> User
            </a>
            <a href="{{ route('admin.orders') }}" class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary {{ request()->is('admin/orders') ? 'active bg-secondary' : '' }}">
                <i class="fas fa-receipt me-2"></i> Riwayat Penjualan
            </a>
            <a href="{{ route('admin.reservations') }}" class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary {{ request()->is('admin/reservations') ? 'active bg-secondary' : '' }}">
                <i class="fas fa-calendar-alt me-2"></i> Reservasi
            </a>
            <a href="{{ route('admin.ratings') }}" class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary {{ request()->is('admin/ratings') ? 'active bg-secondary' : '' }}">
                <i class="fas fa-star me-2"></i> Rating & Ulasan
            </a>
        </div>
    </div>
    {{-- /Sidebar Content --}}

    {{-- Page Content Wrapper --}}
    <div id="page-content-wrapper" class="flex-grow-1 p-4">
        {{-- Menggunakan admin_page_title yang baru --}}
        <h1 class="mt-4 text-primary-dark">@yield('admin_page_title')</h1> 
        <hr>
        @yield('admin_content')
    </div>
    {{-- /Page Content Wrapper --}}

</div>
@endsection