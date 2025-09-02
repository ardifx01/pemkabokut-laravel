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
    $businesses = Business::where('status', 1)->latest()->get();
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
            'owner' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'nib' => 'required|string|max:50',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle single image upload with original name
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $originalName = $foto->getClientOriginalName();
            $fotoPath = $foto->storeAs('umkm', $originalName, 'public');
        }

        Business::create([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'owner' => $request->owner,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
            'email' => $request->email,
            'nib' => $request->nib,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
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

}
