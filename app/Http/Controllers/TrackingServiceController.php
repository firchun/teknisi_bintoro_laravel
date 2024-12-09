<?php

namespace App\Http\Controllers;

use App\Models\TrackingService;
use Illuminate\Http\Request;

class TrackingServiceController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Tracking Lokasi Teknisi'
        ];
        return view('admin.tracking.index', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_service' => 'required|exists:service,id',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ]);

        $trackingData = [
            'id_service' => $request->input('id_service'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
        ];

        TrackingService::create($trackingData);
        $message = 'berhasil disimpan';
        return response()->json(['message' => $message]);
    }
}
