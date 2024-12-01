<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Pengajuan Service',
        ];
        return view('admin.service.index', $data);
    }
    public function getServiceDataTable()
    {
        $service = Service::orderByDesc('id');

        return DataTables::of($service)
            ->addColumn('action', function ($customer) {
                return view('admin.service.components.actions', compact('customer'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'alamat' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'latitude' => 'required|string|max:50',
            'longitude' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi|max:10240',
        ]);

        // Handle file upload for 'foto'
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('uploads/foto', 'public');
        }

        // Handle file upload for 'video'
        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('uploads/video', 'public');
        }

        $serviceData = [
            'id_user' => $request->input('id_user'),
            'alamat' => $request->input('alamat'),
            'keterangan' => $request->input('keterangan'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'foto' => $fotoPath,
            'video' => $videoPath,
        ];

        $service = Service::create($serviceData);

        return back()->with(['success' => 'Berhasil mengajukan service']);

        // return response()->json([
        //     'message' => 'Service created successfully',
        //     'data' => $service,
        // ]);
    }
}