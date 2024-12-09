@push('js')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        $(function() {
            $('#datatable-customers').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                ajax: '{{ url('service-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'fotoView',
                        name: 'fotoView'
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },

                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });

            $('.refresh').click(function() {
                $('#datatable-customers').DataTable().ajax.reload();
            });
            window.mapCustomer = function(id) {
                // Tampilkan modal terlebih dahulu
                $('#map').modal('show');

                // Tunggu hingga modal selesai ditampilkan sebelum merender peta
                $('#map').on('shown.bs.modal', function() {
                    $.ajax({
                        type: 'GET',
                        url: '/service/edit/' + id,
                        success: function(response) {
                            // Pastikan ada latitude dan longitude dalam respons
                            const latitude = response.latitude;
                            const longitude = response.longitude;
                            const user = response.user.name;

                            // Bersihkan peta lama jika ada
                            if (typeof window.currentMap !== 'undefined') {
                                window.currentMap.remove();
                            }

                            // Inisialisasi ulang kontainer peta
                            $('#mapContainer').html(
                                '<div id="mapContent" style="height: 400px;"></div>');

                            // Render peta baru setelah modal terbuka sepenuhnya
                            window.currentMap = L.map('mapContent').setView([latitude,
                                longitude
                            ], 13);

                            L.tileLayer(
                                'http://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                                    maxZoom: 20,
                                    subdomains: ['mt0', 'mt1', 'mt2',
                                        'mt3'
                                    ], // Subdomain Google
                                    attribution: 'Map data © Google'
                                }).addTo(window.currentMap);

                            // Tambahkan marker ke lokasi
                            L.marker([latitude, longitude]).addTo(window.currentMap)
                                .bindPopup('Lokasi ' + user)
                                .openPopup();
                        },
                        error: function(xhr) {
                            console.error('Terjadi kesalahan: ' + xhr.responseText);
                        }
                    });
                });

                // Pastikan event dihapus setelah peta dirender untuk menghindari duplikasi
                $('#map').on('hidden.bs.modal', function() {
                    if (typeof window.currentMap !== 'undefined') {
                        window.currentMap.remove();
                        delete window.currentMap; // Hapus referensi untuk menghemat memori
                    }
                    $('#map').off('shown.bs.modal');
                });
            };
            window.jadwalCustomer = function(id) {
                // Menampilkan modal
                $('#jadwal').modal('show');

                // AJAX untuk mengecek jadwal
                $.ajax({
                    type: 'GET',
                    url: '/schedule/service/' + id,
                    success: function(response) {
                        if (response) {
                            let jadwalHTML = `
                                <div class="card shadow-sm border-0">
                                   
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th scope="row" style="width: 30%;" class="bg-primary text-white">Teknisi</th>
                                                    <td>${response.teknisi.name}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"  class="bg-primary text-white">Tanggal</th>
                                                    <td>${response.tanggal}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"  class="bg-primary text-white">Waktu</th>
                                                    <td>${response.waktu}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"  class="bg-primary text-white">Estimasi Biaya</th>
                                                    <td>Rp ${response.estimasi_biaya.toLocaleString()}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"  class="bg-primary text-white">Estimasi Pengerjaan</th>
                                                    <td>${response.estimasi_pengerjaan} jam</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"  class="bg-primary text-white">Keterangan</th>
                                                    <td>${response.keterangan || '-'}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            `;
                            $('#viewSchedule').html(jadwalHTML).show(); // Isi konten dan tampilkan
                            $('#scheduleForm').hide(); // Sembunyikan form
                            $('#saveScheduleBtn').hide();
                        } else {
                            // Jika jadwal belum ada, panggil form untuk mengedit
                            $.ajax({
                                type: 'GET',
                                url: '/service/edit/' + id,
                                success: function(response) {
                                    $('#scheduleForm').show(); // Tampilkan form
                                    $('#viewSchedule').hide();
                                    $('#serviceId').val(response.id);

                                },
                                error: function(xhr) {
                                    console.error('Terjadi kesalahan: ' + xhr
                                        .responseText);
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        $.ajax({
                            type: 'GET',
                            url: '/service/edit/' + id,
                            success: function(response) {
                                $('#scheduleForm').show(); // Tampilkan form
                                $('#viewSchedule').hide();
                                $('#serviceId').val(response.id);
                            },
                            error: function(xhr) {
                                console.error('Terjadi kesalahan: ' + xhr
                                    .responseText);
                            }
                        });
                    }
                });
            };

            $('#saveScheduleBtn').click(function() {
                var formData = $('#scheduleForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/schedule/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#datatable-customers').DataTable().ajax.reload();
                        $('#jadwal').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });

        });
    </script>
@endpush
