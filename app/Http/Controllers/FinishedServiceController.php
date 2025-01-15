<?php

namespace App\Http\Controllers;

use App\Models\FinishedService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FinishedServiceController extends Controller
{
    public function getFinishedServiceDataTable()
    {
        $service = FinishedService::with(['service', 'service.user'])->orderByDesc('id');

        return DataTables::of($service)

            ->addColumn('laporan', function ($customer) {
                return '<a href="" target="__blank" class="btn btn-danger"><i class="bx bxs-file-pdf"></i> Download</a>';
            })
            ->rawColumns(['laporan'])
            ->make(true);
    }
}
