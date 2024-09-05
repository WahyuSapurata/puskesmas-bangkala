<?php

namespace App\Http\Controllers;

use App\Models\PengajuanItem;
use App\Models\Visit;
use Illuminate\Http\Request;
use Shetabit\Visitor\Visitor;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role != 'staf') {
            $totalTolak = PengajuanItem::where('status_item', 'TOLAK')->count();
            $totalTerima = PengajuanItem::where('status_item', 'TERIMA')->count();
            return view('dashboard', compact('totalTolak', 'totalTerima'));
        } else {
            $totalTolak = PengajuanItem::join('pengajuan', 'pengajuan_item.pengajuan_id', 'pengajuan.id_pengajuan')
                ->where('pengajuan_item.status_item', 'TOLAK')
                ->where('pengajuan.user_id', auth()->user()->id_users)
                ->count();
            $totalTerima = PengajuanItem::join('pengajuan', 'pengajuan_item.pengajuan_id', 'pengajuan.id_pengajuan')
                ->where('pengajuan_item.status_item', 'TERIMA')
                ->where('pengajuan.user_id', auth()->user()->id_users)
                ->count();
            return view('dashboard', compact('totalTolak', 'totalTerima'));
        }
    }

    public function welcome()
    {
        visitor()->visit();
        $visitor = Visit::count();
        return view('welcome', compact('visitor'));
    }
}
