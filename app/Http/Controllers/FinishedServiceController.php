<?php

namespace App\Http\Controllers;

use App\Models\FinishedService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class FinishedServiceController extends Controller
{
    public function getFinishedServiceDataTable()
    {
        $service = FinishedService::with(['service', 'service.user'])->orderByDesc('id');

        return DataTables::of($service)

            ->addColumn('laporan', function ($customer) {
                return '<a href="' . route('report.pdf-finished', $customer->id) . '" target="__blank" class="btn btn-danger"><i class="bx bxs-file-pdf"></i> Download</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($service) {
                return $service->service->created_at->format('d F Y') ?? '-';
            })
            ->addColumn('tanggal_selesai', function ($service) {
                return $service->created_at->format('d F Y') ?? '-';
            })
            ->rawColumns(['laporan', 'tanggal_pengajuan', 'tanggal_selesai'])
            ->make(true);
    }
}