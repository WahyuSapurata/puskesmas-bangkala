<?php

namespace App\Http\Controllers;

use App\Models\DataItem;
use App\Models\Jenis;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        $page = 'Alat';
        $data = DataItem::where('kategori', $page)->get();
        $jenis = Jenis::all();
        return view('bendahara.data_item.index', compact('data', 'jenis', 'page'));
    }

    public function store(Request $request)
    {
        DataItem::create($request->all());
        return redirect(route('alat.index'));
    }

    public function edit(DataItem $alat)
    {
        $jenis = Jenis::all();
        return view('bendahara.data_item.edit', compact('alat', 'jenis'));
    }

    public function update(Request $request, DataItem $alat)
    {
        $alat->update($request->all());
        return redirect(route('alat.index'))->with('success', 'Berhasil Update Data');
    }

    public function destroy(DataItem $alat)
    {
        $alat->delete();
        return redirect(route('alat.index'))->with('success', 'Berhasil Hapus Data');
    }
}
