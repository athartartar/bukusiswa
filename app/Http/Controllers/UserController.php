<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // PENTING: Tambahkan ini

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $request->id . ',id_user',
            'namalengkap' => 'required',
            'usertype' => 'required',
            'status' => 'required',
        ]);

        try {
            $formattedName = ucwords(strtolower($request->namalengkap));

            $data = [
                'namalengkap' => $formattedName,
                'username' => $request->username,
                'usertype' => $request->usertype,
                'status' => $request->status,
            ];

            // Hash password jika diisi
            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $path = $file->store('users', 'public');
                $data['foto'] = $path;
            }

            $user = User::updateOrCreate(
                ['id_user' => $request->id],
                $data
            );

            // KEMBALIKAN DATA UTUH KE JAVASCRIPT
            return response()->json([
                'success' => 'User berhasil disimpan!',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menyimpan: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            User::destroy($id);
            return response()->json(['success' => 'User berhasil dihapus!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus: ' . $e->getMessage()], 500);
        }
    }

    public function saveToken(\Illuminate\Http\Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $user->update(['fcm_token' => $request->token]);

        return response()->json(['message' => 'Token berhasil disimpan ke database!']);
    }
}
