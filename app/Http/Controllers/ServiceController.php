<?php

namespace App\Http\Controllers;

use App\Models\FinishedService;
use App\Models\Service;
use App\Models\ToolService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $service = Service::with(['user'])->orderByDesc('id');

        return DataTables::of($service)
            ->addColumn('fotoView', function ($customer) {
                return '<a target="__blank" href="' . Storage::url($customer->foto) . '"><img src="' . Storage::url($customer->foto) . '" style="width:100px; height:100px; object-fit:cover;" alt="foto"></a>';
            })
            ->addColumn('action', function ($customer) {
                return view('admin.service.components.actions', compact('customer'));
            })
            ->rawColumns(['action', 'fotoView'])
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
    public function edit($id)
    {
        $customer = Service::with(['user'])->find($id);

        if (!$customer) {
            return response()->json(['message' => 'service not found'], 404);
        }

        return response()->json($customer);
    }
    public function storeTool(Request $request)
    {
        // Validasi data dari form
        $validatedData = $request->validate([
            'id_service' => 'required',
            'jenis_kerusakan' => 'required',
            'keterangan' => 'required',
            'waktu_penyelesaian' => 'required',
            'alat' => 'required|array|min:1',
            'alat.*' => 'required|string|max:255', // Validasi untuk setiap nama alat
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1', // Validasi untuk jumlah
            'jenis' => 'required|array|min:1',
            'jenis.*' => 'required|string|in:Penggantian,Perbaikan', // Validasi jenis
        ]);

        // Simpan data ke database
        try {
            FinishedService::create([
                'id_service' => $validatedData['id_service'],
                'jenis_kerusakan' => $validatedData['jenis_kerusakan'],
                'keterangan' => $validatedData['keterangan'],
                'waktu_penyelesaian' => $validatedData['waktu_penyelesaian'],
            ]);
            foreach ($validatedData['alat'] as $index => $alat) {
                ToolService::create([
                    'id_service' => $validatedData['id_service'],
                    'alat' =>  $alat,
                    'jumlah' => $validatedData['jumlah'][$index],
                    'jenis' => $validatedData['jenis'][$index],
                ]);
            }

            return response()->json([
                'message' => 'Data alat berhasil disimpan.',
            ], 200);
        } catch (\Exception $e) {
            // Tangani error jika terjadi masalah saat menyimpan data
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }
}
