<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function halaman_user() {
        $user = User::query()
            ->select([
                'id',
                'nama_lengkap',
                'username',
                'role'
            ])->get();

        return view('halaman-user', ['user' => $user]);
    }

    public function tambah_user() {
        return view('form-user');
    }

    public function simpan_user(Request $request) {
        $validasi = $request->validate([
            'nama-lengkap' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        try {
           User::create([
                'nama_lengkap' => $validasi['nama-lengkap'],
                'username' => $validasi['username'],
                'password' => bcrypt($validasi['password']),
                'role' => $validasi['role']
           ]);

           return redirect('user');
        } catch (\Thowable) {
            return redirect()->back();
        }
    }

    public function edit_user(User $user) {
        $data = [
            'id' => $user->id,
            'nama_lengkap' => $user->nama_lengkap,
            'username' => $user->username,
            'role' => $user->role
        ];

        return view('form-user', ['data' => $data]);
    }

    public function update_user(Request $request, User $user) {
        $validasi = $request->validate([
            'nama-lengkap' => 'required',
            'username' => 'required',
            'password' => 'nullable',
            'role' => 'required'
        ]);

        try {
            $user->nama_lengkap = $validasi['nama-lengkap'];
            $user->username = $validasi['username'];
            if (!empty($validasi['password'])) {
                $user->password = bcrypt($validasi['password']);
            }
            $user->role = $validasi['role'];
            $user->save();

            return redirect('user');
        } catch (\Throwable) {
            return redirect()->back();
        }
    }

    public function hapus_user(User $user) {
        if (Auth::id() === $user->id) {
            return redirect()->back();
        }

        try {
            $user->delete();

            return redirect('user');
        } catch (\Throwable) {
            return redirect()->back();
        }
    }
}
