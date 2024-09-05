<?php

namespace App\Http\Controllers;

use App\Models\DataItem;
use App\Models\Jenis;
use Illuminate\Http\Request;

class BahanController extends Controller
{
    public function index()
    {
        $page = 'Bahan';
        $data = DataItem::where('kategori', $page)->get();
        $jenis = Jenis::all();
        return view('bendahara.data_item.index', compact('data', 'jenis', 'page'));
    }

    public function store(Request $request)
    {
        $model = $request->all();
        $model['kategori'] = 'Bahan';
        DataItem::create($model);
        return redirect(route('bahan.index'));
    }

    public function edit(DataItem $bahan)
    {
        $jenis = Jenis::all();
        return view('bendahara.data_item.edit_bahan', compact('bahan', 'jenis'));
    }

    public function update(Request $request, DataItem $bahan)
    {
        $bahan->update($request->all());
        return redirect(route('bahan.index'))->with('success', 'Berhasil Update Data');
    }

    public function destroy(DataItem $bahan)
    {
        $bahan->delete();
        return redirect(route('bahan.index'))->with('success', 'Berhasil Hapus Data');
    }
}
