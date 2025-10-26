<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class PasswordResetLinkController extends Controller
{
    /**
     * Tampilkan halaman forgot password
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Proses kirim link reset password
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Pastikan email milik user dengan role 'user'
        $user = User::where('email', $request->email)
                    ->where('role', 'user')
                    ->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar sebagai user.'
            ]);
        }

        // Kirim link reset password
        $status = Password::sendResetLink(
            ['email' => $user->email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Link reset password sudah dikirim ke email Anda.');
        }

        // Jika gagal, tampilkan error default
        return back()->withErrors([
            'email' => 'Gagal mengirim link reset password. Silakan coba lagi.'
        ]);
    }
}
