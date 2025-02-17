<?php

namespace App\Http\Controllers;

use App\Models\ScheduleService;
use App\Models\Service;
use App\Models\UpdateArrive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ScheduleServiceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_service' => 'required|exists:service,id',
            'id_teknisi' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'waktu' => 'required|date_format:H:i',
            'keterangan' => 'nullable|string',
            'estimasi_biaya' => 'nullable|string',
            'estimasi_pengerjaan' => 'nullable|string',
        ]);

        $scheduleData = [
            'id_service' => $request->input('id_service'),
            'id_teknisi' => $request->input('id_teknisi'),
            'tanggal' => $request->input('tanggal'),
            'waktu' => $request->input('waktu'),
            'keterangan' => $request->input('keterangan'),
            'estimasi_biaya' => $request->input('estimasi_biaya'),
            'estimasi_pengerjaan' => $request->input('estimasi_pengerjaan'),
        ];

        $service = Service::find($request->input('id_service'));

        if ($request->filled('id')) {
            $schedule = ScheduleService::find($request->input('id'));
            if (!$schedule) {
                return response()->json(['message' => 'Schedule not found'], 404);
            }

            $schedule->update($scheduleData);
            $message = 'Schedule updated successfully';
        } else {
            ScheduleService::create($scheduleData);
            $service->diterima = 1;
            $service->save();
            $message = 'Schedule created successfully';
        }

        return response()->json(['message' => $message, 'email' => $service->user->email]);
    }
    public function storeArrive(Request $request)
    {
        $request->validate([
            'id_service' => 'required|exists:service,id',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'waktu_perjalanan' => 'required|string',
        ]);

        $scheduleData = [
            'id_service' => $request->input('id_service'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'waktu_perjalanan' => $request->input('waktu_perjalanan'),
        ];

        if ($request->filled('id')) {
            $schedule = UpdateArrive::find($request->input('id'));
            if (!$schedule) {
                return response()->json(['message' => 'Update not found'], 404);
            }
            $schedule->update($scheduleData);
            $message = 'updated successfully';
        } else {
            $checkArrive = UpdateArrive::where('id_service', $request->input('id_service'))->count();
            if ($checkArrive <= 0) {
                UpdateArrive::create($scheduleData);
                $message = 'Waktu sampai berhasil simpan';
            } else {
                $message = 'Waktu telah tersimpan';
            }
        }

        return response()->json(['message' => $message]);
    }
    public function scheduleService($id)
    {
        $customer = ScheduleService::with(['teknisi'])->where('id_service', $id)->latest()->first();

        if (!$customer) {
            return response()->json(['message' => 'schedule not found'], 404);
        }

        return response()->json($customer);
    }
    public function checkArrive($id)
    {
        $customer = UpdateArrive::where('id_service', $id)->latest()->first();
        $checkFinish = Service::checkFinish($id);

        if (!$customer) {
            return response()->json([
                'message' => 'Arrive not found',
                'finish' => $checkFinish
            ], 404);
        }

        return response()->json([
            'customer' => $customer,
            'finish' => $checkFinish
        ], 200);
    }
    public function calendar()
    {
        return view('admin.calendar.index', ['title' => 'Kalender Service']);
    }

    // API untuk mengambil data event
    public function getEvents()
    {
        $query = ScheduleService::with(['teknisi', 'service']);
        if (Auth::user()->role == 'Teknisi') {
            $query->where('id_teknisi', Auth::id());
        }

        $events = $query->get()->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'id_service' => $schedule->id_service,
                'teknisi' => $schedule->teknisi->name,
                'title' => $schedule->service->user->name,
                'email' => $schedule->service->user->email,
                'start' => $schedule->tanggal,
                'tanggal' => $schedule->tanggal,
                'time' => $schedule->waktu,
                'alamat' => $schedule->service->alamat,
                'keluhan' => $schedule->service->keterangan,
                'description' => $schedule->keterangan,
                'latitude' => $schedule->service->latitude,
                'longitude' => $schedule->service->longitude,
                'rute' => "https://www.google.com/maps/dir/?api=1&origin=My+Location&destination={$schedule->service->latitude},{$schedule->service->longitude}",
                'phone' => 'https://wa.me/+62',
                'image' => Storage::url($schedule->service->foto),
            ];
        });

        return response()->json($events);
    }
}