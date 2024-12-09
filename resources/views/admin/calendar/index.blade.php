@extends('layouts.backend.admin')
@push('css')
    !-- FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <style>
        .timer-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .circle-timer {
            transform: rotate(-90deg);
            /* Rotate circle to start from the top */
        }

        .timer-text {
            font-size: 24px;
            font-weight: bold;
            margin-top: 10px;
        }

        .background-circle {
            stroke: #e6e6e6;
            /* Light gray color for background circle */
        }

        .progress-circle {
            stroke: #4caf50;
            /* Green color for the progress circle */
            transition: stroke-dashoffset 1s linear;
            /* Smooth transition for stroke dash offset */
        }

        .icon-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            align-items: center;
            justify-content: center;
            animation: zoomInOut 3s infinite;
        }

        @keyframes zoomInOut {
            0% {
                transform: translate(-50%, -50%) scale(1);
                /* ukuran normal */
            }

            50% {
                transform: translate(-50%, -50%) scale(1.2);
                /* zoom in */
            }

            100% {
                transform: translate(-50%, -50%) scale(1);
                /* zoom out */
            }
        }
    </style>
@endpush

@section('content')
    @include('layouts.backend.alert')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <!-- List of Events -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jadwal Service {{ Auth::user()->role == 'Teknisi' ? 'Anda' : '' }}</h5>
                    <ul id="eventList" class="list-group">
                        <!-- Event items will be injected here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal untuk Detail Event -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Detail Jadwal Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2">
                                <center>
                                    <img id="modal-image" src=""
                                        style="width: 200px;height:200px; object-fit:cover;">
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td class="bg-primary text-white">Customer</td>
                            <td><span id="modal-title"></span></td>
                        </tr>
                        <tr>
                            <td class="bg-primary text-white">Alamat</td>
                            <td><span id="modal-alamat"></span></td>
                        </tr>
                        <tr>
                            <td class="bg-primary text-white">Keluhan</td>
                            <td><span id="modal-keluhan"></span></td>
                        </tr>
                        <tr>
                            <td class="bg-primary text-white">Tanggal</td>
                            <td><span id="modal-tanggal"></span></td>
                        </tr>
                        <tr>
                            <td class="bg-primary text-white">Waktu</td>
                            <td><span id="modal-waktu"></span></td>
                        </tr>
                        <tr>
                            <td class="bg-primary text-white">Teknisi</td>
                            <td><span id="modal-teknisi"></span></td>
                        </tr>
                        <!-- Add hidden fields for latitude and longitude -->
                        <tr>
                            <td class="bg-primary text-white">Latitude</td>
                            <td><span id="modal-latitude"></span></td>
                        </tr>
                        <tr>
                            <td class="bg-primary text-white">Longitude</td>
                            <td><span id="modal-longitude"></span></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" id="start-pengerjaan" class="btn btn-primary">Mulai Pengerjaan</button>
                    <button type="button" id="alat-pengerjaan" class="btn btn-primary" style="display: none;">Alat
                        Pengerjaan</button>
                    <a target="__blank" href="" id="modal-phone" class="btn btn-success">Hubungi Customer</a>
                    <a target="__blank" href="" id="modal-rute" class="btn btn-warning">Lihat Rute</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Timer -->
    <div class="modal fade" id="timerModal" tabindex="-1" aria-labelledby="timerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="timerModalLabel">Timer Menuju Lokasi</h5>
                </div>
                <div class="modal-body">
                    <div class="timer-container">
                        <!-- Circle timer -->
                        <div style="position: relative; display: inline-block;">
                            <svg class="circle-timer" width="120" height="120" viewBox="0 0 120 120">
                                <circle class="background-circle" cx="60" cy="60" r="50" stroke="#e6e6e6"
                                    stroke-width="10" fill="none" />
                                <circle id="progress-circle" class="progress-circle" cx="60" cy="60" r="50"
                                    stroke="#4caf50" stroke-width="10" fill="none" stroke-dasharray="314.159"
                                    stroke-dashoffset="0" />
                            </svg>
                            <!-- Icon motor -->
                            <div class="icon-center">
                                <i class="bx bx-run bx-lg"></i>
                            </div>
                        </div>

                        <!-- Timer text -->
                        <div class="timer-text">
                            <span id="timer-display">00:00</span>
                        </div>
                        <div class="mt-2 p-2 border" style="border-radius:10px;">
                            <strong>Menuju <span id="nama-customer" class="text-primary"></span> di <span
                                    id="alamat-dituju" class="text-primary"></span></strong>
                        </div>
                        <div class="mt-3 text-center">
                            <p class="text-danger">Jangan tutup halaman ini hingga sampai pada lokasi</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-success" id="stop-timer">
                        Sampai di lokasi
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmStopModal" tabindex="-1" aria-labelledby="confirmStopModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content bg-danger text-white">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="confirmStopModalLabel"><b>Konfirmasi</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin telah sampai di lokasi dan ingin menghentikan timer?
                    <form id="formConfirmStop">
                        <input type="hidden" name="id_service" id="idServiceConfirm">
                        <input type="hidden" name="latitude" id="latitudeConfirm">
                        <input type="hidden" name="longitude" id="longitudeConfirm">
                        <input type="hidden" name="waktu_perjalanan" id="timeArrifConfirm">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-light" id="confirmStopButton" data-bs-dismiss="modal">
                        Sampai di lokasi
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addAlatModal" tabindex="-1" aria-labelledby="addAlatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="alatForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAlatModalLabel">Tambah Data Alat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="alatInputs">
                            <!-- Input group template -->
                            <div class="row g-3 alat-group">
                                <div class="col-md-6">
                                    <label for="alat" class="form-label">Alat</label>
                                    <input type="text" class="form-control" name="alat[]" placeholder="Nama alat"
                                        required>
                                </div>
                                <div class="col-md-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" name="jumlah[]" min="1"
                                        value="1" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="jenis" class="form-label">Jenis</label>
                                    <select class="form-select" name="jenis[]" required>
                                        <option value="Penggantian" selected>Penggantian</option>
                                        <option value="Perbaikan">Perbaikan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-link mt-3" id="addMore">+ Tambah Alat</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('#addMore').on('click', function() {
            const newInput = `
                <div class="row g-3 alat-group mb-3">
                    <div class="col-md-6">
                        <label for="alat" class="form-label">Alat</label>
                        <input type="text" class="form-control" name="alat[]" placeholder="Nama alat" required>
                    </div>
                    <div class="col-md-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah[]" min="1" value="1" required>
                    </div>
                    <div class="col-md-3">
                        <label for="jenis" class="form-label">Jenis</label>
                        <div class="input-group">
                            <select class="form-select" name="jenis[]" required>
                                <option value="Penggantian" selected>Penggantian</option>
                                <option value="Perbaikan">Perbaikan</option>
                            </select>
                            <button type="button" class="btn btn-danger btn-sm remove-input" title="Hapus input">
                                &times;
                            </button>
                        </div>
                    </div>
                </div>
            `;
            $('#alatInputs').append(newInput);
        });

        // Hapus input field
        $(document).on('click', '.remove-input', function() {
            $(this).closest('.alat-group').remove();
        });
        // timer

        var currentEventId = null;
        // kalender
        function populateEventModal(event) {
            const props = event.extendedProps || {};
            document.getElementById('modal-title').innerText = event.title || 'Tidak ada data';
            document.getElementById('nama-customer').innerText = event.title || 'Tidak ada data';
            document.getElementById('modal-keluhan').innerText = props.keluhan || 'Tidak ada data';
            document.getElementById('modal-alamat').innerText = props.alamat || 'Tidak ada data';
            document.getElementById('modal-tanggal').innerText = props.tanggal || 'Tidak ada data';
            document.getElementById('modal-waktu').innerText = props.time || 'Tidak ada data';
            document.getElementById('modal-teknisi').innerText = props.teknisi || 'Tidak ada data';
            document.getElementById('modal-latitude').innerText = props.latitude || 'Tidak ada data';
            document.getElementById('modal-longitude').innerText = props.longitude || 'Tidak ada data';
            document.getElementById('latitudeConfirm').value = props.latitude || 'Tidak ada data';
            document.getElementById('longitudeConfirm').value = props.longitude || 'Tidak ada data';
            document.getElementById('idServiceConfirm').value = event.id || 'Tidak ada data';
            document.getElementById('modal-phone').href = props.phone || '#';
            document.getElementById('modal-rute').href = props.rute || '#';
            document.getElementById('modal-image').src = props.image || '';
            currentEventId = event.id;
            // console.log(currentEventId);
        }


        // Inisialisasi FullCalendar
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const eventListEl = document.getElementById('eventList');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                events: '{{ route('calendar.events') }}', // Load events from server
                eventClick: function(info) {
                    populateEventModal(info.event);

                    const modal = new bootstrap.Modal(document.getElementById('eventModal'), {
                        keyboard: true
                    });
                    modal.show();


                },
                eventDidMount: function(info) {
                    const props = info.event.extendedProps || {};
                    const eventItem = document.createElement('li');
                    eventItem.classList.add('list-group-item', 'd-flex', 'justify-content-between',
                        'align-items-center');
                    eventItem.innerHTML =
                        `<strong>${info.event.title}</strong><span>${props.tanggal || ''}</span>`;

                    // Klik pada event di sidebar
                    eventItem.addEventListener('click', function() {
                        populateEventModal(info.event);
                        const modal = new bootstrap.Modal(document.getElementById(
                            'eventModal'), {
                            keyboard: true
                        });
                        modal.show();
                    });

                    eventListEl.appendChild(eventItem);
                }
            });
            $('#eventModal').on('shown.bs.modal', function() {
                checkArriveStatus();
            });

            function checkArriveStatus() {
                if (currentEventId) {
                    $.ajax({
                        url: '/schedule/check-arrive/' + currentEventId,
                        type: 'GET',
                        success: function(response) {

                            document.getElementById('start-pengerjaan').style.display = response ?
                                'none' : 'block';
                            document.getElementById('alat-pengerjaan').style.display = response ?
                                'block' : 'none';
                            $('#alat-pengerjaan').on('click', function() {
                                $('#addAlatModal').modal('show');
                            });

                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', xhr.responseText || error);
                            document.getElementById('start-pengerjaan').style.display =
                                'block';
                        }
                    });
                } else {
                    console.error('ID event tidak ditemukan.');
                }
            }
            document.getElementById('start-pengerjaan').addEventListener('click', function() {
                //post data


                function sendTrackingData() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            function(position) {

                                let latitude = position.coords.latitude;
                                let longitude = position.coords.longitude;

                                $.ajax({
                                    url: "/tracking/store",
                                    type: "POST",
                                    data: {
                                        id_service: currentEventId,
                                        latitude: latitude,
                                        longitude: longitude
                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    dataType: "json",
                                    success: function(response) {
                                        console.log("Tracking submitted successfully: ",
                                            response);
                                    },
                                    error: function(xhr, status, error) {
                                        console.error("Error submitting tracking: ", error);
                                    }
                                });
                            },
                            function(error) {
                                console.error("Error getting location: ", error.message);
                            }
                        );
                    } else {
                        console.error("Geolocation is not supported by this browser.");
                    }
                }

                setInterval(sendTrackingData, 10000);

                this.disabled = true;
                var timerModal = new bootstrap.Modal(document.getElementById('timerModal'), {
                    keyboard: false,
                    backdrop: 'static'
                });
                timerModal.show();

                var timerDisplay = document.getElementById('timer-display');
                var progressCircle = document.getElementById('progress-circle');


                var totalTime = 120;
                var elapsedTime = 0;
                var lastTimerTime = "00:00";

                // Function to update the timer every second
                function updateTimer() {
                    elapsedTime++;

                    var minutes = Math.floor(elapsedTime / 60);
                    var seconds = elapsedTime % 60;
                    // Format waktu menjadi mm:ss
                    lastTimerTime = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') +
                        seconds;
                    timerDisplay.innerText = lastTimerTime;

                    // Update progress circle (jika digunakan)
                    var progress = elapsedTime / totalTime;
                    if (progress > 1) {
                        progress = progress % 1;
                    }

                    var offset = 314.159 * (1 - progress);
                    progressCircle.style.strokeDashoffset = offset;
                }

                var timerInterval = setInterval(updateTimer, 1000);


                var closeButton = document.querySelector('#eventModal .btn-close');
                closeButton.setAttribute('disabled', true);

                var stopButton = document.getElementById('stop-timer');
                stopButton.disabled = false;


                stopButton.addEventListener('click', function() {
                    document.getElementById('timeArrifConfirm').value = lastTimerTime;

                    $('#confirmStopModal').modal('show');
                    $('#confirmStopButton').click(function() {

                        var formDataConfirm = $('#formConfirmStop').serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/schedule/store-arrive',
                            data: formDataConfirm,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            success: function(response) {
                                alert(response.message);
                                checkArriveStatus();
                                $('#eventModal').modal('hide');

                            },
                            error: function(xhr) {
                                alert('Terjadi kesalahan: ' + xhr.responseText);
                                document.getElementById('start-pengerjaan')
                                    .style.display =
                                    'block';
                            }
                        });
                        clearInterval(timerInterval);
                        timerModal.hide();
                        closeButton.removeAttribute(
                            'disabled');
                        stopButton.disabled = true;
                        document.getElementById('start-pengerjaan').disabled =
                            false;
                    });

                });
            });

            calendar.render();
        });
    </script>
@endpush
