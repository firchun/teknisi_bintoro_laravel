<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Service</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }

        /* Halaman baru */
    </style>
</head>

<body>

    <!-- Halaman 1: Detail Service & Jadwal dalam Tabel -->
    <h2>Laporan Service</h2>
    <h3>Keterangan Pengajuan</h3>
    <table>
        <tr>
            <th>Pemohon</th>
            <td>{{ $service->service->user->name }}</td>
        </tr>
        <tr>
            <th width="30%">Alamat</th>
            <td>{{ $service->service->alamat }}</td>
        </tr>
        <tr>
            <th>Keterangan</th>
            <td>{{ $service->service->keterangan }}</td>
        </tr>
        <tr>
            <th>Foto Kerusakan</th>
            <td>
                @if ($service->service->foto)
                    <img src="{{ public_path('storage/' . $service->service->foto) }}" width="200">
                @else
                    <p>Tidak ada foto tersedia</p>
                @endif
            </td>
        </tr>
    </table>

    <h3>Teknisi yang Bertugas</h3>
    <table>
        <tr>
            <th width="30%">Nama Teknisi</th>
            <td>{{ $service->service->schedule->teknisi->name }}</td>
        </tr>
        <tr>
            <th width="30%">Email Teknisi</th>
            <td>{{ $service->service->schedule->teknisi->email }}</td>
        </tr>
    </table>

    <h3>Jadwal Service</h3>
    <table>
        <tr>
            <th width="30%">Tanggal</th>
            <td>{{ $service->service->schedule->tanggal }}</td>
        </tr>
        <tr>
            <th>Waktu</th>
            <td>{{ $service->service->schedule->waktu }}</td>
        </tr>
        <tr>
            <th>Estimasi Biaya</th>
            <td>Rp {{ number_format($service->service->schedule->estimasi_biaya) ?? 0 }}</td>
        </tr>
        <tr>
            <th>Estimasi Pengerjaan</th>
            <td>{{ $service->service->schedule->estimasi_pengerjaan ?? '-' }} Jam</td>
        </tr>
    </table>

    <div class="page-break"></div> <!-- Halaman baru -->

    <!-- Halaman 2: Hasil Service, Keterangan, dan Tools dalam Tabel -->
    <h3>Hasil Service</h3>
    <table>
        <tr>
            <th width="30%">Jenis Kerusakan</th>
            <td>{{ $service->jenis_kerusakan }}</td>
        </tr>
        <tr>
            <th>Keterangan</th>
            <td>{{ $service->keterangan }}</td>
        </tr>
    </table>

    <h3>Waktu Penyelesaian</h3>
    <table>
        <tr>
            <th width="30%">Waktu</th>
            <td>{{ $service->waktu_penyelesaian ?? 'Belum tersedia' }} Jam</td>
        </tr>
    </table>

    <h3>Alat yang Digunakan</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Alat</th>
                <th>Jumlah</th>
                <th>Jenis</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($service->service->tool as $tool)
                <tr>
                    <td>{{ $tool->alat }}</td>
                    <td>{{ $tool->jumlah }}</td>
                    <td>{{ $tool->jenis }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Foto Hasil</h3>
    @if ($service->foto_hasil)
        <img src="{{ public_path('uploads/foto/' . $service->foto_hasil) }}" width="300">
    @else
        <p>Tidak ada foto hasil</p>
    @endif

</body>

</html>
