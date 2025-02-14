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
        $tracking = TrackingService::with(['service.user', 'scheduleService.teknisi'])
            ->where('id_service', $id)
            ->get(); // Mengembalikan koleksi

        // Jika data kosong, kembalikan respons 404
        if ($tracking->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Ubah koleksi menjadi array JSON
        $trackingData = $tracking->map(function ($item) {
            return [
                'latitude' => $item->latitude,
                'longitude' => $item->longitude,
                'customer' => $item->service->user->name ?? 'Customer tidak ditemukan',
                'teknisi' => $item->scheduleService->teknisi->name ?? 'Teknisi tidak ditemukan',
            ];
        });

        return response()->json($trackingData);
    }
}
