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
    @include('admin.calendar.modal')
@endsection
@include('admin.calendar.script')
