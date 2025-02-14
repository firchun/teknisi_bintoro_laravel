@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="mb-3">
        <a href="{{ route('service') }}" class="btn btn-primary">
            <i class="bx bx-arrow-back me-1"></i>
            Kembali
        </a>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="map" style="height: 500px;"></div> <!-- Tambahkan ukuran agar peta tampil -->
        </div>
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h5>Riwayat Perjalanan</h5>
                    <table id="trackingTable" class="table table-striped table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Jam</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($service as $item)
                                <tr>
                                    <td>{{ $item->created_at->format('H:i:s') }}</td>
                                    <td>{{ $item->latitude }}</td>
                                    <td>{{ $item->longitude }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#trackingTable').DataTable({
                "order": [
                    [0, "desc"]
                ], // Urutkan berdasarkan tanggal terbaru


            });
        });
    </script>
@endpush
@push('js')
    <!-- Pastikan Leaflet CSS dan JS sudah dimuat -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Pastikan ada elemen #map
            if (!document.getElementById('map')) {
                console.error("Elemen #map tidak ditemukan.");
                return;
            }

            var map = L.map('map').setView([-6.200000, 106.816666], 12); // Default ke Jakarta
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var marker;

            function updateLocation() {
                $.ajax({
                    url: "/route-tracking/{{ $service[0]->id_service ?? 0 }}", // Gunakan Blade untuk menghindari error jika kosong
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        var lat = parseFloat(data.latitude);
                        var lng = parseFloat(data.longitude);
                        var teknisi = data.teknisi;
                        var customer = data.customer;
                        var popupContent = "Petugas Teknisi : " + teknisi + "<br> Menuju Customer : " +
                            customer;
                        if (!isNaN(lat) && !isNaN(lng)) {
                            if (marker) {
                                marker.setLatLng([lat, lng]).bindPopup(popupContent).openPopup();
                            } else {
                                marker = L.marker([lat, lng]).addTo(map)
                                    .bindPopup("Lokasi Terakhir Teknisi").openPopup();
                            }

                            map.setView([lat, lng], 14);
                        } else {
                            console.error("Data lokasi tidak valid:", data);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Gagal mengambil data:", error);
                    }
                });
            }

            updateLocation(); // Panggil saat halaman pertama kali dimuat
            setInterval(updateLocation, 5000); // Update setiap 5 detik
        });
    </script>
@endpush
