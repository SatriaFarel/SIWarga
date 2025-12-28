<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Warga;

class WargaLoginController extends Controller
{
    /**
     * Show login page for warga
     *
     * Display custom login view (member login)
     */
    public function showLogin()
    {
        return view('livewire.auth.login-member');
    }

    /**
     * Handle warga login process
     *
     * Flow:
     * 1. Validate input (NIK & Password)
     * 2. Find warga by NIK
     * 3. If found, set session login
     * 4. Redirect to warga dashboard
     */
    public function login(Request $request)
    {
        $request->validate([
            'NIK'      => 'required',
            'Password' => 'required',
        ]);

        /**
         * Find warga by NIK
         */
        $warga = Warga::where('NIK', $request->NIK)->first();

        /**
         * If warga not found
         */
        if (!$warga) {
            return back()->withErrors([
                'NIK' => 'NIK atau password salah'
            ]);
        }

        /**
         * Set custom session for warga login
         * (separate from Laravel default auth)
         */
        Session::put('warga_login', true);
        Session::put('warga_id', $warga->id);

        return redirect()->route('warga.dashboard');
    }

    /**
     * Handle warga logout
     *
     * Clear all warga session data
     */
    public function logout()
    {
        Session::forget(['warga_login', 'warga_id']);
        Session::flush();

        return redirect()->route('warga.login');
    }
}
