@extends('layouts.frontend.app')

@section('content')
    <section class="section">
        <div class="container">
            @if (Session('success'))
                <div class="mb-3">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-3">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-3">Riwayat Pengajuan Service</h3>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Alamat</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Jadwal</th>
                                <th>Pembatalan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (App\Models\Service::where('id_user', Auth::id())->get() as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>{{ $item->diterima == 1 ? 'Diterima' : 'Menunggu Persetujuan' }}</td>
                                    <td></td>
                                    <td><a href="#" class="btn btn-sm btn-danger">Batalkan</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
