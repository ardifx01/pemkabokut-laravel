<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // ...existing code...
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        
        return view('admin.user', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }

    public function deactivate(User $user)
    {
        try {
            $user->update(['is_verified' => false]);
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dinonaktifkan (verifikasi dicabut)'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menonaktifkan user'
            ], 500);
        }
    }

    public function activate(User $user)
    {
        try {
            $user->update(['is_active' => true]);
            
            return response()->json([
                'success' => true,
                'message' => 'User berhasil diaktifkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengaktifkan user'
            ], 500);
        }
    }
    public function verify(User $user)
    {
        if (auth()->id() !== 1) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya admin yang dapat memverifikasi user.'
            ], 403);
        }
        try {
            $user->update(['is_verified' => true]);
            return response()->json([
                'success' => true,
                'message' => 'User berhasil diverifikasi.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memverifikasi user.'
            ], 500);
        }
    }
}
