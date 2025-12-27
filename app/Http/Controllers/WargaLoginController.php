<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Warga;

class WargaLoginController extends Controller
{
    public function showLogin()
    {
        return view('livewire.auth.login-member');
    }

    public function login(Request $request)
    {
        $request->validate([
            'NIK' => 'required',
            'Password' => 'required'
        ]);

        // cari warga berdasarkan NIK
        $warga = Warga::where('NIK', $request->NIK)->first();

        if (!$warga) {
            return back()->withErrors([
                'NIK' => 'NIK atau password salah'
            ]);
        }

        // simpan session warga
        Session::put('warga_login', true);
        Session::put('warga_id', $warga->id);

        return redirect()->route('warga.dashboard');
    }

    public function logout()
    {
        Session::forget(['warga_login', 'warga_id']);
        Session::flush();

        return redirect()->route('warga.login');
    }
}
