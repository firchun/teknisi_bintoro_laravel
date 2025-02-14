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
            if (!document.getElementById('map')) {
                console.error("Elemen #map tidak ditemukan.");
                return;
            }

            var map = L.map('map').setView([-6.200000, 106.816666], 12); // Default ke Jakarta
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var markers = []; // Array untuk menyimpan marker agar bisa dihapus saat update

            function updateLocation() {
                $.ajax({
                    url: "/route-tracking/{{ $service[0]->id_service ?? 0 }}", // Pastikan URL benar
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        // Hapus semua marker sebelumnya
                        markers.forEach(marker => map.removeLayer(marker));
                        markers = [];

                        // Pastikan data berupa array
                        if (!Array.isArray(data) || data.length === 0) {
                            console.error("Data lokasi tidak valid atau kosong.");
                            return;
                        }

                        var bounds = L
                    .latLngBounds(); // Untuk mengatur view agar menyesuaikan dengan data

                        // Looping semua titik lokasi dan tambahkan marker
                        data.forEach(function(item) {
                            var lat = parseFloat(item.latitude);
                            var lng = parseFloat(item.longitude);
                            var teknisi = item.teknisi || "Teknisi tidak ditemukan";
                            var customer = item.customer || "Customer tidak ditemukan";

                            if (!isNaN(lat) && !isNaN(lng)) {
                                var popupContent = "Teknisi: " + teknisi +
                                    "<br> Menuju Customer: " + customer;
                                var marker = L.marker([lat, lng]).addTo(map)
                                    .bindPopup(popupContent).openPopup();

                                markers.push(marker);
                                bounds.extend([lat, lng]);
                            }
                        });

                        // Jika ada data, sesuaikan tampilan peta dengan semua marker
                        if (markers.length > 0) {
                            map.fitBounds(bounds);
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
