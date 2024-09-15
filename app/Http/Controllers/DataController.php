<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Category;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index()
    {
        $data = Data::all();
        return view('/data/index', compact('data'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('data.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Buat data baru
        Data::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
        ]);

        // Redirect ke halaman yang diinginkan (misalnya halaman daftar kategori)
        return redirect()->route('data.index')->with('success', 'Data created successfully.');
    }

    public function destroy($id)
    {
        // Cari data berdasarkan ID
        $data = Data::find($id);

        // Jika data tidak ditemukan, kembalikan dengan pesan error
        if (!$data) {
            return redirect()->back()->with('error', 'Data not found.');
        }

        // Hapus data
        $data->delete();

        // Redirect kembali ke halaman daftar data dengan pesan sukses
        return redirect('data/index')->with('success', 'Data deleted successfully.');
    }
    public function show($id)
    {
        // Cari data berdasarkan ID
        $data = Data::with(['category', 'document.file'])->findOrFail($id);

        // Jika data ditemukan, kirim ke view
        return view('data.show', compact('data'));
    }
}
