@extends('admin.layout')

@section('title', 'Dashboard Admin')

@section('content')
    <h1 class="mb-4">Dashboard Admin Desa Medalsari</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Manajemen UMKM</h5>
                    <p class="card-text">Kelola data UMKM yang terdaftar di Desa Medalsari.</p>
                    <a href="{{ route('admin.umkms.index') }}" class="btn btn-primary">Lihat UMKM</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Manajemen Wisata Desa</h5> {{-- Mengubah dari Info Desa --}}
                    <p class="card-text">Kelola informasi tempat wisata di Desa Medalsari.</p>
                    <a href="{{ route('admin.wisata_desas.index') }}" class="btn btn-primary">Lihat Wisata Desa</a> {{-- Mengubah dari info_desas --}}
                </div>
            </div>
        </div>
    </div>
@endsection
