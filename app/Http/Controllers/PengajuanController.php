<?php

namespace App\Http\Controllers;

use App\Models\DataItem;
use App\Models\Pengajuan;
use App\Models\PengajuanItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PDF;

class PengajuanController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'staf') {
            $data = Pengajuan::where('user_id', auth()->user()->id)->get();
        } elseif (auth()->user()->role == 'apoteker') {
            $data = Pengajuan::where('status', 'TERIMA')->get();
        } else {
            $data = Pengajuan::all();
        }
        return view('staf.pengajuan.index', compact('data'));
    }

    public function create()
    {
        // $now = Carbon::now();
        // $oneMonthAgo = $now->subMonth();
        // $sekarang = Carbon::now();
        // $count = Pengajuan::where('created_at', '>=', $oneMonthAgo)
        //     ->where('created_at', '<=', $sekarang)
        //     ->where('user_id', auth()->user()->id)
        //     ->where('status', 'TERIMA')
        //     ->count();

        // if ($count >= 2) {
        //     $available = false;
        // } else {
        //     $available = true;
        // }

        $available = true;
        $pengajuan = Pengajuan::where('user_id', auth()->user()->id)->where('status', NULL)->first();
        if ($pengajuan) {
            return redirect(route('pengajuan-item.create'))->with('success', 'Silahkan menambahkan data alat/bahan');
        }
        return view('staf.pengajuan.create', compact('available'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $path = NULL;
            if ($request->hasFile('file_pengajuan')) {
                $upload_path = 'public/file_pengajuan';
                $filename = time() . '_' . $request->file('file_pengajuan')->getClientOriginalName();
                $path = $request->file('file_pengajuan')->storeAs(
                    $upload_path,
                    $filename
                );
            }
            $data['user_id'] = auth()->user()->id;
            $data['file_pengajuan'] = $path;
            Pengajuan::create($data);
        } catch (\Exception $e) {
            return redirect(route('pengajuan.create'))->with('error', 'Gagal : ' . $e->getMessage());
        }
        return redirect(route('pengajuan-item.create'))->with('success', 'Berhasil Tambah Data');
    }

    public function item()
    {
        $pengajuan = Pengajuan::where('user_id', auth()->user()->id)->where('status', NULL)->first();
        $pengajuanItem = PengajuanItem::where('pengajuan_id', $pengajuan->id)->get();

        $data = DataItem::orderBy('updated_at', 'ASC')->get();
        return view('staf.pengajuan.item', compact('pengajuan', 'pengajuanItem', 'data'));
    }

    public function storeItem(Request $request)
    {
        try {
            $data = $request->all();
            $path = NULL;
            if ($request->hasFile('gambar')) {
                $upload_path = 'public/gambar';
                $filename = time() . '_' . $request->file('gambar')->getClientOriginalName();
                $path = $request->file('gambar')->storeAs(
                    $upload_path,
                    $filename
                );
            }
            $data['gambar'] = $path;
            PengajuanItem::create($data);
        } catch (\Exception $e) {
            return redirect(route('pengajuan-item.create'))->with('error', 'Gagal : ' . $e->getMessage());
        }
        return redirect(route('pengajuan-item.create'))->with('success', 'Berhasil Tambah Data');
    }

    public function destroyItem(PengajuanItem $pengajuanItem)
    {
        $pengajuanItem->delete();
        return back()->with('success', 'Berhasil Hapus Data');
    }

    public function send(Pengajuan $pengajuan)
    {
        $pengajuan->status = 'DIPROSES';
        $pengajuan->save();
        return redirect(route('pengajuan.create'))->with('success', 'Pengajuan berhasil dikirim');
    }

    public function show(Pengajuan $pengajuan)
    {
        $data = PengajuanItem::where('pengajuan_id', $pengajuan->id)->get();
        return view('staf.pengajuan.show', compact('data', 'pengajuan'));
    }

    public function cetak()
    {
        if (auth()->user()->role == 'staf') {
            $data = Pengajuan::where('user_id', auth()->user()->id)->get();
        } elseif (auth()->user()->role == 'apoteker') {
            $data = Pengajuan::where('status', 'TERIMA')->get();
        } else {
            $data = Pengajuan::all();
        }

        $pdf = PDF::loadview('exports.pengajuan_pdf', ['data' => $data]);
        return $pdf->download('Data Pengajuan.pdf');
    }

    public function data()
    {
        $data = Pengajuan::where('status', 'DIPROSES')->get();
        return view('bendahara.pengajuan.index', compact('data'));
    }

    public function kelola(Pengajuan $pengajuan)
    {
        $data = PengajuanItem::where('pengajuan_id', $pengajuan->id)->get();
        return view('bendahara.pengajuan.show', compact('data', 'pengajuan'));
    }

    public function tolak(Pengajuan $pengajuan, PengajuanItem $pengajuanItem)
    {
        $pengajuanItem->status_item = 'TOLAK';
        $pengajuanItem->save();
        return redirect(route('pengajuan.kelola', $pengajuan->id))->with('success', 'Item telah ditolak');
    }

    public function terima(Pengajuan $pengajuan, PengajuanItem $pengajuanItem)
    {
        // $item = DataItem::find($pengajuanItem->data_item_id);

        // if ($item->stok >= $pengajuanItem->jumlah) {
        //     $item->stok = $item->stok - $pengajuanItem->jumlah;
        //     $item->save();

            $pengajuanItem->status_item = 'TERIMA';
            $pengajuanItem->save();
            return redirect(route('pengajuan.kelola', $pengajuan->id))->with('success', 'Item telah diterima');
        // } else {
        //     return redirect(route('pengajuan.kelola', $pengajuan->id))->with('error', 'Stok item tidak cukup');
        // }
    }

    public function tolakPengajuan(Pengajuan $pengajuan)
    {
        $pengajuan->status = 'TOLAK';
        $pengajuan->save();
        return redirect(route('pengajuan.kelola', $pengajuan->id))->with('success', 'Pengajuan telah ditolak');
    }

    public function terimaPengajuan(Pengajuan $pengajuan)
    {
        $pengajuan->status = 'TERIMA';
        $pengajuan->save();
        return redirect(route('pengajuan.kelola', $pengajuan->id))->with('success', 'Pengajuan telah diterima');
    }

    public function approveApoteker(Pengajuan $pengajuan)
    {
        // Kumpulkan semua data_item_id yang status_item-nya 'TERIMA'
        $acceptedItemIds = $pengajuan->itemPengajuan->filter(function ($item) {
            return $item->status_item == 'TERIMA';
        })->pluck('data_item_id')->all();

        // Ambil semua DataItem yang relevan sekaligus
        $dataItems = DataItem::whereIn('id_data_item', $acceptedItemIds)->get();

        // Lakukan iterasi dan update stok
        foreach ($dataItems as $dataItem) {
            // Temukan item pengajuan yang sesuai
            $pengajuanItem = $pengajuan->itemPengajuan->firstWhere('data_item_id', $dataItem->id_data_item);

            // Update stok jika ada item pengajuan yang sesuai
            if ($pengajuanItem) {
                $dataItem->stok += $pengajuanItem->jumlah;
                $dataItem->save(); // Simpan perubahan
            }
        }

        $pengajuan->status_apoteker = 'SELESAI';
        $pengajuan->save();
        return redirect()->back()->with('success', 'Verifikasi pengadaan berhasil');
    }
}
