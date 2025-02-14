<div class="row my-3 justify-content-center">
    <div class="col-8">
        <div class="card">
            <div class="card-body">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <canvas id="myChart2"></canvas>
            </div>
        </div>
    </div>
</div>
<hr>

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Grafik Line (Perbaikan Air Conditioner)
            $.ajax({
                url: '/service-chart',
                method: 'GET',
                success: function(response) {
                    let labels = response.map(item => item.date);
                    let data = response.map(item => item.total);

                    let ctx = document.getElementById('myChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jumlah Perbaikan Air Conditioner',
                                data: data,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderWidth: 2,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Tanggal'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Jumlah Perbaikan'
                                    },
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            });

            $.ajax({
                url: '/service-status-chart',
                method: 'GET',
                success: function(response) {
                    let ctx2 = document.getElementById('myChart2').getContext('2d');
                    new Chart(ctx2, {
                        type: 'pie',
                        data: {
                            labels: ['Diterima', 'Selesai'],
                            datasets: [{
                                data: [response.diterima, response.selesai],
                                backgroundColor: ['rgba(255, 205, 86, 0.8)',
                                    'rgba(54, 162, 235, 0.8)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
