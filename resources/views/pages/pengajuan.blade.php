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
                    <h2>Formulir Layanan AC</h2>
                    <form action="{{ route('service.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_user" value="{{ Auth::id() }}">
                        <div class="mb-3">
                            <label for="complaint" class="form-label">Keluhan</label>
                            <textarea name="keterangan" class="form-control" rows="5" placeholder="Jelaskan keluhan Anda" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="complaint" class="form-label">Alamat lengkap</label>
                            <textarea name="alamat" class="form-control" rows="5" placeholder="Jelaskan keluhan Anda" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="complaint" class="form-label">No HP yang dapat dihubungi</label>
                            <input type="text" class="form-control" name="no_hp" value="+62">
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Unggah Foto</label>
                            <input type="file" name="foto" id="photo" class="form-control" accept="image/*"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Lokasi</label>
                            <div id="map" style="height: 400px; border: 1px solid #ddd;"></div>
                            <input type="hidden" name="latitude" id="latitude" required>
                            <input type="hidden" name="longitude" id="longitude" required>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            var currentIdUser = @json(Auth::user()->id);
            var currentEmail = @json(Auth::user()->email);
            $.ajax({
                type: 'GET',
                url: `/kirim-notifikasi/${encodeURIComponent('pengajuan_baru')}/${encodeURIComponent(currentEmail)}/${encodeURIComponent(currentIdUser)}`,
                success: function(response) {
                    console.log('Email notifikasi terkirim:', response);
                },
                error: function(xhr) {
                    console.error('Gagal mengirim email:', xhr.responseText);
                }
            });
            // Default coordinates (fallback in case geolocation fails)
            const defaultLatLng = [-8.510604, 140.4059535];

            // Initialize the map with default coordinates
            const map = L.map('map').setView(defaultLatLng, 13);

            // Add satellite tile layer
            L.tileLayer('http://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'], // Subdomain Google
                attribution: 'Map data © Google'
            }).addTo(map);

            // Add a draggable marker at default location
            const marker = L.marker(defaultLatLng, {
                draggable: true
            }).addTo(map);

            // Function to update hidden fields
            const updateCoordinates = (lat, lng) => {
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            };

            // Set initial position in hidden fields
            updateCoordinates(defaultLatLng[0], defaultLatLng[1]);

            // Try to get user's location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLatLng = [position.coords.latitude, position.coords.longitude];

                        // Update map view and marker position
                        map.setView(userLatLng, 13);
                        marker.setLatLng(userLatLng);

                        // Update hidden fields with user's location
                        updateCoordinates(position.coords.latitude, position.coords.longitude);
                    },
                    (error) => {
                        console.error('Geolocation error:', error.message);
                    }
                );
            } else {
                console.warn('Geolocation is not supported by this browser.');
            }

            // Update coordinates in hidden fields when marker is dragged
            marker.on('dragend', (event) => {
                const position = event.target.getLatLng();
                updateCoordinates(position.lat, position.lng);
            });
        });
    </script>
@endpush
