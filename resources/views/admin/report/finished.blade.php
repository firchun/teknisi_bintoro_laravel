@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header flex-column flex-md-row">
                    <div class="head-label ">
                        <h5 class="card-title mb-0">{{ $title ?? 'Title' }}</h5>
                    </div>
                    <div class="dt-action-buttons text-end pt-3 pt-md-0">
                        <div class=" btn-group " role="group">
                            <button class="btn btn-secondary refresh btn-default" type="button">
                                <span>
                                    <i class="bx bx-sync me-sm-1"> </i>
                                    <span class="d-none d-sm-inline-block">Refresh Data</span>
                                </span>
                            </button>

                        </div>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table id="datatable-customers" class="table table-hover table-bordered display">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Alamat</th>
                                <th>Keterangan</th>
                                <th>laporan</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Alamat</th>
                                <th>Keterangan</th>
                                <th>Laporan</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            $('#datatable-customers').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                ajax: '{{ url('finished-service-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'service.user.name',
                        name: 'service.user.name'
                    },
                    {
                        data: 'service.alamat',
                        name: 'service.alamat'
                    },
                    {
                        data: 'service.keterangan',
                        name: 'service.keterangan'
                    },
                    {
                        data: 'laporan',
                        name: 'laporan'
                    },
                ]
            });

            $('.refresh').click(function() {
                $('#datatable-customers').DataTable().ajax.reload();
            });
        });
    </script>
@endpush
