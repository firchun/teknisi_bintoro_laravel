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
                            @foreach (App\Models\Service::where('id_user', Auth::id())->latest('id')->get() as $item)
                                @php
                                    $jadwal = App\Models\ScheduleService::where('id_service', $item->id)->first();
                                    \Carbon\Carbon::setLocale('id');

                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>{{ $item->keterangan }}<br>
                                        @if ($jadwal)
                                            <small>Estimasi biaya :
                                                <span class="text-danger font-weight-bold">
                                                    Rp {{ number_format($jadwal->estimasi_biaya) }}</span></small>
                                        @endif
                                    </td>
                                    <td>{{ $item->diterima == 1 ? 'Diterima' : 'Menunggu Persetujuan' }}</td>
                                    <td>
                                        @if ($jadwal)
                                            <strong>{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d - F - Y') }}</strong><br>
                                            <small class="badge badge-secondary">Jam:
                                                {{ \Carbon\Carbon::parse($jadwal->waktu)->format('H:i') }}</small>
                                        @else
                                            <small class="text-mutted">Menunggu diterima</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->diterima == 0)
                                            <form action="{{ route('service.delete', $item->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Apakah Anda yakin ingin membatalkan?');">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge badge-success">Diterima</span>
                                            <br>
                                            @if ($jadwal)
                                                <small>{{ $jadwal->teknisi->name }}</small>
                                            @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
