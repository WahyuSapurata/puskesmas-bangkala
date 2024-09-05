<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function index()
    {
        $data = Jenis::all();
        return view('bendahara.jenis.index', compact('data'));
    }

    public function store(Request $request)
    {
        Jenis::create($request->all());
        return redirect(route('jenis.index'));
    }

    public function edit(Jenis $jeni)
    {
        return view('bendahara.jenis.edit', compact('jeni'));
    }

    public function update(Request $request, Jenis $jeni)
    {
        $jeni->update($request->all());
        return redirect(route('jenis.index'))->with('success', 'Berhasil Update Data');
    }

    public function destroy(Jenis $jeni)
    {
        $jeni->delete();
        return redirect(route('jenis.index'))->with('success', 'Berhasil Hapus Data');
    }
}
