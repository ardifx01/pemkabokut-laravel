<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        
        return view('admin.user', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function deactivate(User $user)
    {
        try {
            $user->update(['is_active' => false]);
            
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dinonaktifkan'
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
}
