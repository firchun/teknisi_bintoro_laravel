<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ServiceNotification;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function kirimNotifikasi($type, $email, $id_user)
    {
        switch ($type) {
            case 'pengajuan_diterima':
                $subject = "Pengajuan Anda Telah Diterima";
                $message = "Pengajuan layanan Anda telah kami terima dan sedang diproses.";
                break;

            case 'menuju_lokasi':
                $subject = "Teknisi Menuju Lokasi";
                $message = "Teknisi sedang dalam perjalanan menuju lokasi Anda.";
                break;

            case 'service_selesai':
                $subject = "Layanan Telah Selesai";
                $message = "Proses layanan telah selesai. Terima kasih telah menggunakan layanan kami!";
                break;

            default:
                return response()->json(['error' => 'Jenis notifikasi tidak ditemukan'], 400);
        }
        
        if (!empty($id_user)) {
            Notifikasi::create([
                'id_user' => $id_user,
                'isi_notifikasi' => $message,
                'type' => 'primary', 
            ]);
        }

        Mail::to($email)->send(new ServiceNotification($subject, $message));

        return response()->json(['success' => 'Notifikasi telah dikirim']);
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'isi_notifikasi' => 'required|string',
            'type' => 'required|in:danger,warning,success,primary',
        ]);

        $notifikasi = Notifikasi::create([
            'id_user' => $request->id_user,
            'isi_notifikasi' => $request->isi_notifikasi,
            'type' => $request->type ?? 'primary',
        ]);

        return response()->json([
            'message' => 'Notifikasi berhasil dibuat!',
            'data' => $notifikasi
        ], 201);
    }
}