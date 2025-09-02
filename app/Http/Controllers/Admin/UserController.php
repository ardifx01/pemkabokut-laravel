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
    public function destroy(User $user)
    {
        if (auth()->id() !== 1 || $user->id == 1) {
            return redirect()->back()->with('error', 'Hanya admin dengan ID 1 yang dapat menghapus user lain.');
        }
        try {
            // Update related models' user_id to 1
            \App\Models\Post::where('user_id', $user->id)->update(['user_id' => 1]);
            \App\Models\Document::where('user_id', $user->id)->update(['user_id' => 1]);
            \App\Models\Icon::where('user_id', $user->id)->update(['user_id' => 1]);
            \App\Models\Business::where('user_id', $user->id)->update(['user_id' => 1]);
            // Hapus user
            $user->delete();
            return redirect()->back()->with('success', 'User berhasil dihapus. Semua data terkait dialihkan ke user ID 1.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus user.');
        }
    }
    /**
     * Reset password user (hanya admin id 1)
     */
    public function resetPassword(Request $request, User $user)
    {
        if (auth()->id() !== 1) {
            return redirect()->back()->with('error', 'Hanya admin dengan ID 1 yang dapat mereset password.');
        }
        $request->validate([
            'new_password' => 'required|string|min:6',
        ]);
        $user->password = bcrypt($request->new_password);
        $user->save();
        return redirect()->back()->with('success', 'Password berhasil direset.');
    }
}
