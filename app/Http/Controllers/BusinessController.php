<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $businesses = Business::latest()->get();
        return view('umkm.data', compact('businesses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('umkm.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:Makanan dan Minuman,Pakaian dan Aksesoris,Jasa,Kerajinan Tangan,Elektronik,Kesehatan,Transportasi,Pendidikan,Teknologi',
            'alamat' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'nib' => 'required|string|max:50',
            'deskripsi' => 'required|string',
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle multiple image uploads
        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $foto) {
                $path = $foto->store('umkm', 'public');
                $fotoPaths[] = $path;
            }
        }

        Business::create([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
            'email' => $request->email,
            'nib' => $request->nib,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPaths,
            'status' => 0 // Default pending
        ]);

        return redirect()->route('umkm.index')->with('success', 'UMKM berhasil didaftarkan dan menunggu persetujuan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $business = Business::findOrFail($id);
        return view('umkm.show', compact('business'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $business = Business::findOrFail($id);
        return view('admin.umkm.edit', compact('business'));
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
            'alamat' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'nib' => 'nullable|string|max:50',
            'deskripsi' => 'required|string',
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle multiple image uploads
        $fotoPaths = $business->foto ?? [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $foto) {
                $path = $foto->store('umkm', 'public');
                $fotoPaths[] = $path;
            }
        }

        $business->update([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
            'email' => $request->email,
            'nib' => $request->nib,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPaths,
        ]);

        return redirect()->route('umkm.index')->with('success', 'UMKM berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $business = Business::findOrFail($id);
        
        // Delete images from storage
        if ($business->foto) {
            foreach ($business->foto as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }
        
        $business->delete();
        
        return redirect()->route('umkm.index')->with('success', 'UMKM berhasil dihapus.');
    }

    /**
     * Approve business
     */
    public function approve(string $id)
    {
        $business = Business::findOrFail($id);
        $business->update(['status' => 1]);
        
        return redirect()->back()->with('success', 'UMKM berhasil disetujui.');
    }

    /**
     * Reject business
     */
    public function reject(string $id)
    {
        $business = Business::findOrFail($id);
        $business->update(['status' => 0]);
        
        return redirect()->back()->with('success', 'UMKM ditolak.');
    }

    /**
     * Delete specific photo from business
     */
    public function deletePhoto(Request $request, string $id)
    {
        $business = Business::findOrFail($id);
        $photoIndex = $request->input('photo_index');
        
        if ($business->foto && isset($business->foto[$photoIndex])) {
            // Delete file from storage
            Storage::disk('public')->delete($business->foto[$photoIndex]);
            
            // Remove photo from array
            $photos = $business->foto;
            unset($photos[$photoIndex]);
            $photos = array_values($photos); // Reindex array
            
            // Update business
            $business->update(['foto' => $photos]);
            
            return response()->json(['success' => true, 'message' => 'Foto berhasil dihapus']);
        }
        
        return response()->json(['success' => false, 'message' => 'Foto tidak ditemukan']);
    }
}
