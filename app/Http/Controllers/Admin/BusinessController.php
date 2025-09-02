<?php

namespace App\Http\Controllers\Admin;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BusinessController extends Controller
{
    /**
     * Display a listing of the businesses.
     */
    public function index(Request $request)
    {
        $query = Business::with('user')->latest();
        
        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('owner', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('nomor_telepon', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('jenis', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('alamat', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('nib', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'LIKE', '%' . $searchTerm . '%');
                  });
            });
        }
        
        // Filter by status if requested
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        $businesses = $query->paginate(10);
        
        return view('admin.businesses.index', compact('businesses'));
    }

    /**
     * Display the specified business.
     */
    public function show(Business $business)
    {
        $business->load('user');
        return view('admin.businesses.show', compact('business'));
    }

    /**
     * Approve a business.
     */
    public function approve(Business $business)
    {
        $business->update([
            'status' => 1,
            'user_id' => Auth::id()
        ]);
        return redirect()->route('admin.businesses.index')
            ->with('success', 'Business approved successfully.');
    }

    /**
     * Reject/unapprove a business.
     */
    public function reject(Business $business)
    {
        $business->update([
            'status' => 0,
            'user_id' => Auth::id()
        ]);
        return redirect()->route('admin.businesses.index')
            ->with('success', 'Business status changed to pending.');
    }

    /**
     * Remove the specified business from storage.
     */
    public function destroy(Business $business)
    {
        // Delete associated photos if they exist
        if ($business->foto && is_array($business->foto)) {
            foreach ($business->foto as $photo) {
                if (file_exists(public_path('storage/' . $photo))) {
                    unlink(public_path('storage/' . $photo));
                }
            }
        }
        
        $business->delete();

        return redirect()->route('admin.businesses.index')->with('success', 'Business deleted successfully.');
    }

    /**
     * Get pending businesses for notification popup.
     */
    public function getPendingBusinesses()
    {
        $pendingBusinesses = Business::where('status', 0)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get(['id', 'nama', 'email', 'foto', 'created_at']);
        
        return response()->json([
            'success' => true,
            'count' => Business::where('status', 0)->count(),
            'businesses' => $pendingBusinesses
        ]);
    }

    
public function edit(string $id)
    {
        $business = Business::findOrFail($id);
        return view('admin.businesses.edit', compact('business'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $business = Business::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:Makanan dan Minuman,Pakaian dan Aksesoris,Jasa,Kerajinan Tangan,Elektronik,Kesehatan,Transportasi,Pendidikan,Teknologi',
            'owner' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'nib' => 'nullable|string|max:50',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'owner' => $request->owner,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
            'email' => $request->email,
            'nib' => $request->nib,
            'deskripsi' => $request->deskripsi,
        ];

        // Handle single image upload with original name
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($business->foto && Storage::disk('public')->exists($business->foto)) {
                Storage::disk('public')->delete($business->foto);
            }
            $file = $request->file('foto');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $path = $file->storeAs('umkm', $filename, 'public');
            $data['foto'] = $path;
        }

        $business->update($data);

        return redirect()->route('admin.businesses.index')->with('success', 'UMKM berhasil diupdate.');
    }

}
