@extends('layouts.backend.admin')

@section('content')
    @if (Auth::user()->role == 'Admin')
        @include('admin.grafik')
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="text-center">Pengguna Terdaftar</h2>
            </div>
            @include('admin.dashboard_component.card1', [
                'count' => $users,
                'title' => 'Pengguna',
                'subtitle' => 'Total Pengguna',
                'color' => 'warning',
                'icon' => 'user',
            ])
            @include('admin.dashboard_component.card1', [
                'count' => $kepala_teknisi,
                'title' => 'Kepala Teknisi',
                'subtitle' => 'Total Kepala Teknisi',
                'color' => 'success',
                'icon' => 'user',
            ])
            @include('admin.dashboard_component.card1', [
                'count' => $teknisi,
                'title' => 'Teknisi',
                'subtitle' => 'Total Teknisi',
                'color' => 'primary',
                'icon' => 'user',
            ])
        </div>
        <hr>
    @elseif(Auth::user()->role == 'K_teknisi')
        @include('admin.grafik')
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="text-center">Pengguna Terdaftar</h2>
            </div>
            @include('admin.dashboard_component.card1', [
                'count' => $users,
                'title' => 'Pengguna',
                'subtitle' => 'Total Pengguna',
                'color' => 'warning',
                'icon' => 'user',
            ])
            @include('admin.dashboard_component.card1', [
                'count' => $teknisi,
                'title' => 'Teknisi',
                'subtitle' => 'Total Teknisi',
                'color' => 'primary',
                'icon' => 'user',
            ])
        </div>
        <hr>
    @endif
    @if (Auth::user()->role != 'Teknisi' && Auth::user()->role != 'User')
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="text-center">Perbaikan Air Conditioner</h2>
            </div>
            @include('admin.dashboard_component.card1', [
                'count' => $service_pending,
                'title' => 'Pengajuan pending',
                'subtitle' => 'Total pengajuan pending',
                'color' => 'warning',
                'icon' => 'cog',
            ])
            @include('admin.dashboard_component.card1', [
                'count' => $service_ditolak,
                'title' => 'Pengajuan ditolak',
                'subtitle' => 'Total pengajuan ditolak',
                'color' => 'danger',
                'icon' => 'cog',
            ])
            @include('admin.dashboard_component.card1', [
                'count' => $service_diterima,
                'title' => 'Pengajuan diterima',
                'subtitle' => 'Total pengajuan diterima',
                'color' => 'success',
                'icon' => 'cog',
            ])
            @include('admin.dashboard_component.card1', [
                'count' => $service_selesai,
                'title' => 'Pengajuan selesai',
                'subtitle' => 'Total Pengajuan selesai',
                'color' => 'primary',
                'icon' => 'cog',
            ])
        </div>
    @elseif(Auth::user()->role == 'Teknisi')
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="text-center">Perbaikan Air Conditioner</h2>
            </div>
            @include('admin.dashboard_component.card1', [
                'count' => $service_teknisi,
                'title' => 'Perbaikan terjadwal',
                'subtitle' => 'Total Perbaikan terjadwal',
                'color' => 'warning',
                'icon' => 'cog',
            ])
        </div>
    @endif
@endsection
