<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ─── CUSTOMER LOGIN ───────────────────────────────────────
    public function showCustomerLogin()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('katalog');
        }
        return view('auth.login-customer');
    }

    public function customerLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Cek apakah email terdaftar sebagai customer
        $user = User::where('email', $request->email)
                    ->where('role', 'customer')
                    ->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'Akun tidak ditemukan atau bukan akun customer.'])
                ->withInput($request->only('email'));
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('katalog')
                ->with('success', 'Selamat datang, ' . Auth::user()->nama_toko . '!');
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput($request->only('email'));
    }

    // ─── ADMIN LOGIN ──────────────────────────────────────────
    public function showAdminLogin()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        // Kalau sudah login tapi bukan admin, logout dulu
        if (Auth::check() && !Auth::user()->isAdmin()) {
            Auth::logout();
        }
        return view('auth.login-admin');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Cek apakah email terdaftar sebagai admin
        $user = User::where('email', $request->email)
                    ->where('role', 'admin')
                    ->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'Akun tidak ditemukan atau bukan akun admin.'])
                ->withInput($request->only('email'));
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang, Admin!');
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput($request->only('email'));
    }

    // ─── REGISTER (Customer only) ─────────────────────────────
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('katalog');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_toko'      => 'required|string|max:255',
            'nama_pemilik'   => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'nomor_telepon'  => 'required|string|max:20',
            'alamat'         => 'required|string',
            'password'       => 'required|min:6|confirmed',
        ], [
            'nama_toko.required'     => 'Nama toko wajib diisi.',
            'nama_pemilik.required'  => 'Nama pemilik wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.unique'           => 'Email sudah digunakan.',
            'nomor_telepon.required' => 'Nomor telepon wajib diisi.',
            'alamat.required'        => 'Alamat wajib diisi.',
            'password.min'           => 'Password minimal 6 karakter.',
            'password.confirmed'     => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'nama_toko'     => $request->nama_toko,
            'nama_pemilik'  => $request->nama_pemilik,
            'email'         => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat'        => $request->alamat,
            'password'      => Hash::make($request->password),
            'role'          => 'customer',
        ]);

        Auth::login($user);

        return redirect()->route('katalog')
            ->with('success', 'Akun berhasil dibuat! Selamat belanja.');
    }

    // ─── LOGOUT ───────────────────────────────────────────────
    public function logout(Request $request)
    {
        $isAdmin = Auth::user()?->isAdmin();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke login yang sesuai
        return $isAdmin
            ? redirect()->route('admin.login')->with('success', 'Anda telah keluar dari panel admin.')
            : redirect()->route('customer.login')->with('success', 'Anda telah berhasil keluar.');
    }
}
