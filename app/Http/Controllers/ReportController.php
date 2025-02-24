<?php

namespace App\Http\Controllers;

use App\Models\FinishedService;
use PDF;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reportFinished()
    {
        $data = [
            'title' => 'Laporan Pengerjaan',
        ];
        return view('admin.report.finished', $data);
    }

    public function reportSparepart()
    {
        $data = [
            'title' => 'Laporan Penggunaan Sparepart',
        ];
        return view('admin.report.sparepart', $data);
    }
    public function pdf_finished($id)
    {
        $service = FinishedService::with(['service', 'service.schedule', 'service.user', 'service.tool'])->findOrFail($id);
        $pdf = PDF::loadView('admin.report.pdf.finished', compact('service'));
        return $pdf->stream('laporan pengajuan service ' . $service->service->id . '' . date('y-m-d') . '.pdf');
    }
}