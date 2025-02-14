<?php

namespace App\Http\Controllers;

use App\Models\ToolService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ToolServiceController extends Controller
{
    public function getToolServiceDataTable()
    {
        $service = ToolService::with(['service', 'service.user'])
            // ->selectRaw('id_service, COUNT(*) as total')
            // ->groupBy('id_service')
            // ->orderByDesc('id_service')
            ->get();

        return DataTables::of($service)
            ->addColumn('laporan', function ($service) {
                return '<a href="" target="__blank" class="btn btn-danger"><i class="bx bxs-file-pdf"></i> Download</a>';
            })
            ->addColumn('teknisi', function ($service) {
                return $service->scheduleService->teknisi->name ?? '-'; // Jika tidak ada, tampilkan '-'
            })
            ->addColumn('tanggal', function ($service) {
                return $service->created_at->format('d F Y') ?? '-';
            })
            ->rawColumns(['laporan', 'teknisi', 'tanggal'])
            ->make(true);
    }
}