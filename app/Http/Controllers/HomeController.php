<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Notifikasi;
use App\Models\ScheduleService;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role == 'User') {
            return redirect()->to('/');
        }
        if (Auth::user()->role == 'Teknisi') {
            $service_selesai = Service::where('diterima', 1)
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('schedule_service')
                        ->whereColumn('schedule_service.id_service', 'service.id')
                        ->where('schedule_service.id_teknisi', Auth::id());
                })
                ->count();
        } else {
            $service_selesai = Service::where('diterima', 1)->count();
        }
        $data = [
            'title' => 'Dashboard',
            'users' => User::where('role', 'User')->count(),
            'teknisi' => User::where('role', 'Teknisi')->count(),
            'kepala_teknisi' => User::where('role', 'K_teknisi')->count(),
            'service_pending' => Service::where('diterima', 0)->count(),
            'service_ditolak' => Service::where('diterima', '>', 1)->count(),
            'service_diterima' => Service::where('diterima', 1)->count(),
            'service_selesai' => $service_selesai,
            'service_teknisi' => ScheduleService::where('id_teknisi', Auth::id())->count(),
        ];
        return view('admin.dashboard', $data);
    }
    public function akunUser()
    {
        $data = [
            'title' => 'Profile',
        ];
        return view('pages.akun', $data);
    }
    public function pengajuanService()
    {
        $data = [
            'title' => 'Pengajuan Service',
        ];
        return view('pages.pengajuan', $data);
    }
    public function riwayatService()
    {
        $data = [
            'title' => 'Riwayat Service',
        ];
        return view('pages.riwayat', $data);
    }
    public function serviceChart()
    {
        $services = Service::where('created_at', '>=', Carbon::now()->subMonth())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($services);
    }
    public function serviceStatusChart()
    {
        $data = [
            'diterima' => Service::where('diterima', 1)->count(),
            'selesai' => Service::where('selesai', 1)->count(),
        ];

        return response()->json($data);
    }
    public function notifikasiUser()
    {
        $updateNotifikasi = Notifikasi::where('id_user', Auth::id())->where('dibaca', 0);
        $updateNotifikasi->update(['dibaca' => 1]);

        $data = [
            'title' => 'Notifikasi',
            'notifikasi' => Notifikasi::where('id_user', Auth::id())->get()
        ];

        return view('pages.notifikasi', $data);
    }
}
