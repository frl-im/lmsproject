<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    /**
     * Halaman sertifikat Premium
     */
    public function index()
    {
        $user = Auth::user();

        // Double safety (walau sudah middleware premium)
        if (!$user || !$user->isPremium()) {
            abort(403, 'Sertifikat hanya untuk pengguna Premium');
        }

        return view('certificate.index', compact('user'));
    }
}
