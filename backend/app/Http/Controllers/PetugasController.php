<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PetugasController extends Controller
{
    /**
     * Menampilkan semua petugas
     */
    public function index()
    {
        $petugas = User::where('role', 'petugas')
            ->orderBy('id', 'desc')
            ->get([
                'id',
                'name',
                'email',
                'no_hp',
                'shift',
                'created_at'
            ]);

        return response()->json([
            'success' => true,
            'data' => $petugas
        ]);
    }


    /**
     * Menambahkan petugas
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],

            'password' => [
                'required',
                'string',
                'min:6'
            ],

            'no_hp' => [
                'required',
                'string',
                'max:20',
                'unique:users,no_hp'
            ],

            'shift' => [
                'required',
                'string',
                'max:50'
            ],
        ], [
            'name.required' =>
                'Nama petugas wajib diisi.',

            'email.required' =>
                'Email petugas wajib diisi.',

            'email.email' =>
                'Format email tidak valid.',

            'email.unique' =>
                'Email tersebut sudah digunakan oleh akun lain.',

            'password.required' =>
                'Password wajib diisi.',

            'password.min' =>
                'Password minimal 6 karakter.',

            'no_hp.required' =>
                'Nomor HP wajib diisi.',

            'no_hp.max' =>
                'Nomor HP maksimal 20 karakter.',

            'no_hp.unique' =>
                'Nomor HP sudah digunakan oleh petugas lain.',

            'shift.required' =>
                'Shift wajib dipilih.',
        ]);


        $petugas = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'petugas',
            'no_hp' => $validated['no_hp'],
            'shift' => $validated['shift'],
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Petugas berhasil ditambahkan.',
            'data' => $petugas
        ], 201);
    }


    /**
     * Menampilkan satu petugas
     */
    public function show($id)
    {
        $petugas = User::where('role', 'petugas')
            ->find($id);

        if (!$petugas) {
            return response()->json([
                'success' => false,
                'message' => 'Petugas tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $petugas
        ]);
    }


    /**
     * Mengubah data petugas
     */
    public function update(Request $request, $id)
    {
        $petugas = User::where('role', 'petugas')
            ->find($id);

        if (!$petugas) {
            return response()->json([
                'success' => false,
                'message' => 'Petugas tidak ditemukan.'
            ], 404);
        }


        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
                    ->ignore($petugas->id)
            ],

            'password' => [
                'nullable',
                'string',
                'min:6'
            ],

            'no_hp' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'no_hp')
                    ->ignore($petugas->id)
            ],

            'shift' => [
                'required',
                'string',
                'max:50'
            ],
        ], [
            'name.required' =>
                'Nama petugas wajib diisi.',

            'email.required' =>
                'Email petugas wajib diisi.',

            'email.email' =>
                'Format email tidak valid.',

            'email.unique' =>
                'Email tersebut sudah digunakan oleh akun lain.',

            'password.min' =>
                'Password minimal 6 karakter.',

            'no_hp.required' =>
                'Nomor HP wajib diisi.',

            'no_hp.max' =>
                'Nomor HP maksimal 20 karakter.',

            'no_hp.unique' =>
                'Nomor HP sudah digunakan oleh petugas lain.',

            'shift.required' =>
                'Shift wajib dipilih.',
        ]);


        $petugas->name = $validated['name'];
        $petugas->email = $validated['email'];
        $petugas->no_hp = $validated['no_hp'];
        $petugas->shift = $validated['shift'];


        // Password hanya diubah jika diisi
        if (!empty($validated['password'])) {
            $petugas->password = Hash::make(
                $validated['password']
            );
        }


        $petugas->save();


        return response()->json([
            'success' => true,
            'message' => 'Data petugas berhasil diperbarui.',
            'data' => $petugas
        ]);
    }


    /**
     * Menghapus petugas
     */
    public function destroy($id)
    {
        $petugas = User::where('role', 'petugas')
            ->find($id);

        if (!$petugas) {
            return response()->json([
                'success' => false,
                'message' => 'Petugas tidak ditemukan.'
            ], 404);
        }


        $petugas->delete();


        return response()->json([
            'success' => true,
            'message' => 'Petugas berhasil dihapus.'
        ]);
    }
}