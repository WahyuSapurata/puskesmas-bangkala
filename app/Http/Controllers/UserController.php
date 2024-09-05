<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function bendahara()
    {
        return view('admin.bendahara.index', ['data' => User::where('role', 'bendahara')->get()]);
    }

    public function bendaharaApprove(User $user)
    {
        $user->is_aktif = 1;
        $user->save();
        return redirect()->route('bendahara.index')->with('success', 'Approve akun berhasil');
    }

    public function bendaharaDestroy(User $user)
    {
        $user->delete();
        return redirect(route('bendahara.index'))->with('success', 'Berhasil Hapus Data');
    }

    public function staf()
    {
        return view('bendahara.staf.index', ['data' => User::where('role', 'staf')->get()]);
    }

    public function stafApprove(User $user)
    {
        $user->is_aktif = 1;
        $user->save();
        return redirect()->route('staf.index')->with('success', 'Approve akun berhasil');
    }

    public function stafDestroy(User $user)
    {
        $user->delete();
        return redirect(route('staf.index'))->with('success', 'Berhasil Hapus Data');
    }

    public function apoteker()
    {
        return view('staf.apoteker.index', ['data' => User::where('role', 'apoteker')->get()]);
    }

    public function apotekerApprove(User $user)
    {
        $user->is_aktif = 1;
        $user->save();
        return redirect()->route('apoteker.index')->with('success', 'Approve akun berhasil');
    }

    public function apotekerDestroy(User $user)
    {
        $user->delete();
        return redirect(route('apoteker.index'))->with('success', 'Berhasil Hapus Data');
    }
}
