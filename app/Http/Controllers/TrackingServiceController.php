<?php

namespace App\Http\Controllers;

use App\Models\TrackingService;
use Illuminate\Http\Request;

class TrackingServiceController extends Controller
{
    public function index($id)
    {
        $service = TrackingService::where('id_service', $id)->get();
        $data = [
            'title' => 'Tracking Lokasi Teknisi',
            'service' => $service,
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
    public function getTrackingById($id)
    {
        $tracking = TrackingService::with(['service.user', 'scheduleService.teknisi'])->where('id_service', $id)->get();

        if ($tracking) {
            return response()->json([
                'latitude' => $tracking->latitude,
                'longitude' => $tracking->longitude,
                'customer' => $tracking->service->user->name ?? 'Customer tidak ditemukan',
                'teknisi' => $tracking->scheduleService->teknisi->name ?? 'Teknisi tidak ditemukan',
            ]);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }
}
