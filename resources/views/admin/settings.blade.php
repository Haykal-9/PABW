@extends('admin.layouts.app')

@section('admin_page_title', 'Pengaturan')

@section('admin_content')
<div class="container py-4">
    <h4 class="fw-bold mb-4">Pengaturan Target Pendapatan</h4>
    <form method="POST" action="{{ route('admin.settings.target') }}" class="card border-0 shadow-sm p-4 mb-4">
        @csrf
        <div class="mb-3">
            <label class="form-label">Target Pendapatan (Rp)</label>
            <input type="number" name="target" class="form-control" value="{{ old('target', $target?->target ?? '') }}" required min="1">
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $target?->start_date ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $target?->end_date ?? '') }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Target</button>
    </form>
    @if($target)
    <div class="alert alert-info">
        Target saat ini: <b>Rp {{ number_format($target->target,0,',','.') }}</b> dari {{ $target->start_date }} sampai {{ $target->end_date }}
    </div>
    @endif
</div>
@endsection
