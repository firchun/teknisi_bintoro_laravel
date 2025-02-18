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

        var currentEventId = null;
        var currentIdService = null;
        var currentIdUser = null;
        var currentEmail = 'firchun025@gmail.com';

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
            document.getElementById('modal-id-service').innerText = props.id_service || 'Tidak ada data';
            document.getElementById('latitudeConfirm').value = props.latitude || 'Tidak ada data';
            document.getElementById('longitudeConfirm').value = props.longitude || 'Tidak ada data';
            document.getElementById('idServiceConfirm').value = props.id_service || 'Tidak ada data';
            document.getElementById('modal-phone').href = props.phone || '#';
            document.getElementById('modal-rute').href = props.rute || '#';
            document.getElementById('modal-image').src = props.image || '';
            currentEventId = event.id ?? props.id;
            currentIdService = props.id_service ?? event.id_service;
            currentIdUser = props.id_user ?? event.id_user;
            currentEmail = props.email ?? event.email;
            console.log('Current Event ID:', currentIdUser); // Tambahkan log untuk memeriksa nilai currentEventId
            console.log('Current Event ID:', currentEventId); // Tambahkan log untuk memeriksa nilai currentEventId
            console.log('Current ID Service:', currentIdService); // Tambahkan log untuk memeriksa nilai currentIdService
        }

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
                console.log('Modal shown, checking arrive status...');
                checkArriveStatus();
            });

            function checkArriveStatus() {
                if (currentIdService) {
                    $.ajax({
                        url: '/schedule/check-arrive/' + currentIdService,
                        type: 'GET',
                        success: function(response) {
                            if (response) {
                                document.getElementById('start-pengerjaan').style.display = 'none';
                                document.getElementById('alat-pengerjaan').style.display = 'block';
                            } else if (response.finish === 1 && response) {
                                document.getElementById('start-pengerjaan').style.display = 'none';
                                document.getElementById('alat-pengerjaan').style.display = 'none';

                            } else {
                                document.getElementById('start-pengerjaan').style.display = 'block';
                                document.getElementById('alat-pengerjaan').style.display = 'none';
                            }


                            $('#alat-pengerjaan').off('click').on('click', function() {
                                $('#addAlatModal').modal('show');
                                $('#idServiceTool').val(currentIdService);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error check arrive:', xhr.responseText || error);
                            document.getElementById('start-pengerjaan').style.display = 'block';
                            document.getElementById('alat-pengerjaan').style.display = 'none';
                        }
                    });
                } else {
                    console.error('ID event tidak ditemukan.');
                }
            }

            document.getElementById('start-pengerjaan').addEventListener('click', function() {
                //post data
                //kirim email menuju lokasi
                var emailDummy = 'firchun025@gmail.com';
                $.ajax({
                    type: 'GET',
                    url: `/kirim-notifikasi/${encodeURIComponent('menuju_lokasi')}/${encodeURIComponent(currentEmail)}/${encodeURIComponent(currentIdUser)}`,
                    success: function(emailResponse) {
                        // alert(emailResponse.success);
                    },
                    error: function(xhr) {
                        alert('Gagal mengirim email: ' + xhr.responseText);
                    }
                });

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
                                        id_service: currentIdService,
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
                                switch (error.code) {
                                    case error.PERMISSION_DENIED:
                                        console.error("User denied the request for Geolocation.");
                                        break;
                                    case error.POSITION_UNAVAILABLE:
                                        console.error("Location information is unavailable.");
                                        break;
                                    case error.TIMEOUT:
                                        console.error("The request to get user location timed out.");
                                        break;
                                    case error.UNKNOWN_ERROR:
                                        console.error("An unknown error occurred.");
                                        break;
                                }
                            }, {
                                enableHighAccuracy: true,
                                timeout: 10000,
                                maximumAge: 0
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
                                    .style.display = 'block';
                            }
                        });
                        clearInterval(timerInterval);
                        timerModal.hide();
                        closeButton.removeAttribute('disabled');
                        stopButton.disabled = true;
                        document.getElementById('start-pengerjaan').disabled = false;
                    });
                });
            });

            $('#alatForm').submit(function(e) {
                e.preventDefault(); // Prevent form default submission

                //kirim email menuju lokasi
                var emailDummy = currentEmail ?? 'firchun025@gmail.com';
                $.ajax({
                    type: 'GET',
                    url: `/kirim-notifikasi/${encodeURIComponent('service_selesai')}/${encodeURIComponent(emailDummy)}/${encodeURIComponent(currentIdUser)}`,
                    success: function(emailResponse) {
                        // alert(emailResponse.success);
                    },
                    error: function(xhr) {
                        alert('Gagal mengirim email: ' + xhr.responseText);
                    }
                });

                var formData = $(this).serialize(); // Serialize the form inputs

                // Perform AJAX request
                $.ajax({
                    type: 'POST',
                    url: '/service/storeTool',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        alert(response.message); // Show success message
                        $('#alatForm')[0].reset(); // Reset form
                        $('#addAlatModal').modal('hide'); // Hide modal
                        checkArriveStatus();
                    },
                    error: function(xhr) {
                        var errors = JSON.parse(xhr.responseText); // Parse error response
                        alert('Terjadi kesalahan: ' + errors.message);
                    },
                });
            });

            calendar.render();
        });
    </script>
@endpush
