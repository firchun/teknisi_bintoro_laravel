<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ServiceNotification;

class NotifikasiController extends Controller
{
    public function kirimNotifikasi($type, $email)
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

        Mail::to($email)->send(new ServiceNotification($subject, $message));

        return response()->json(['success' => 'Notifikasi telah dikirim']);
    }
}
