<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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

        $formattedName = ucwords(strtolower($request->namalengkap));

        $data = [
            'namalengkap' => $formattedName,
            'username' => $request->username,
            'usertype' => $request->usertype,
            'status' => $request->status,
        ];

        if ($request->password) {
            $data['password'] = $request->password; 
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = $file->store('users', 'public');
            $data['foto'] = $path;
        }

        User::updateOrCreate(
            ['id_user' => $request->id],
            $data
        );

        return response()->json([
            'success' => 'User berhasil disimpan!'
        ]);
    }

    public function destroy($id)
    {
        User::destroy($id);

        return response()->json([
            'success' => 'User berhasil dihapus!'
        ]);
    }
}
