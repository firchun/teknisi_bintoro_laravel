<?php

namespace App\Http\Controllers;

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
}
