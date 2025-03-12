<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ServiceNotification;
use App\Models\Notifikasi;
use App\Models\User;

class NotifikasiController extends Controller
{
    public function kirimNotifikasi($type, $email, $id_user)
    {
        $messages = [
            'pengajuan_baru' => [
                'subject' => null,
                'message' => "Terdapat 1 pengajuan service baru, check pada data pengajuan.",
                'messageTeknisi' => null,
                'messageKTeknisi' => null
            ],
            'pengajuan_diterima' => [
                'subject' => "Pengajuan Anda Telah Diterima",
                'message' => "Pengajuan layanan Anda telah kami terima dan sedang diproses.",
                'messageTeknisi' => "1 Pengajuan layanan telah disetujui oleh kepala teknisi, cek pada jadwal Anda.",
                'messageKTeknisi' => null
            ],
            'menuju_lokasi' => [
                'subject' => "Teknisi Menuju Lokasi",
                'message' => "Teknisi sedang dalam perjalanan menuju lokasi Anda.",
                'messageTeknisi' => null,
                'messageKTeknisi' => null
            ],
            'service_selesai' => [
                'subject' => "Layanan Telah Selesai",
                'message' => "Proses layanan telah selesai. Terima kasih telah menggunakan layanan kami!",
                'messageTeknisi' => null,
                'messageKTeknisi' => "1 Pengajuan layanan telah selesai dikerjakan, cek pada laporan."
            ]
        ];

        if (!isset($messages[$type])) {
            return response()->json(['error' => 'Jenis notifikasi tidak ditemukan'], 400);
        }

        $messageData = $messages[$type];

        // Kirim Notifikasi ke User 
        if (!empty($id_user)) {
            if ($type !== 'pengajuan_baru') {
                Notifikasi::create([
                    'id_user' => $id_user,
                    'isi_notifikasi' => $messageData['message'],
                    'type' => 'primary',
                ]);
            }

            collect(User::where('role', 'Teknisi')->get())->each(function ($teknisi) use ($messageData) {
                if ($messageData['messageTeknisi']) {
                    Notifikasi::create([
                        'id_user' => $teknisi->id,
                        'isi_notifikasi' => $messageData['messageTeknisi'],
                        'type' => 'primary',
                    ]);
                }
            });

            collect(User::where('role', 'K_teknisi')->get())->each(function ($kteknisi) use ($messageData) {
                Notifikasi::create([
                    'id_user' => $kteknisi->id,
                    'isi_notifikasi' => $messageData['messageKTeknisi'] ?? $messageData['message'],
                    'type' => 'primary',
                ]);
            });
        }

        // Kirim Email
        // if (!empty($email) && !empty($messageData['subject'])) {
        //     Mail::to($email)->send(new ServiceNotification($messageData['subject'], $messageData['message']));
        // }
        if (!empty($email) && !empty($messageData['subject']) && $type !== 'pengajuan_baru') {
            Mail::to($email)->send(new ServiceNotification($messageData['subject'], $messageData['message']));
        }

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
    public function index()
    {
        foreach (Notifikasi::where('id_user', auth()->user()->id)->get() as $notifikasi) {
            $notifikasi->update(['dibaca' => 1]);
        }
        $data = [
            'title' => 'Notifikasi',
            'notifikasi' => Notifikasi::where('id_user', auth()->user()->id)->orderBy('created_at', 'desc')
                ->paginate(10)
        ];
        return view('admin.notifikasi.index', $data);
    }
}
