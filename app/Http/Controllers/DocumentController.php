<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::all();
        return view('index', compact('documents'));
    }

    public function data()
    {
        $documents = Document::all();
        return view('/document/data', compact('documents'));
    }

    public function create()
    {
        $data = Data::all();
        return view('document.create', compact('data'));
    }

    public function store(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Buat data baru
        Document::create([
            'title' => $request->title,
            'data_id' => $request->data_id,
        ]);

        // Redirect ke halaman yang diinginkan (misalnya halaman daftar kategori)
        return redirect()->route('document.data')->with('success', 'Data created successfully.');
    }

    public function destroy($id)
    {
        // Cari data berdasarkan ID
        $document = Document::find($id);

        // Jika data tidak ditemukan, kembalikan dengan pesan error
        if (!$document) {
            return redirect()->route('document.data')->with('error', 'Data not found.');
        }

        // Hapus data
        $document->delete();

        // Redirect kembali ke halaman daftar headline dengan pesan sukses
        return redirect()->route('document.data')->with('success', 'Document deleted successfully.');
    }
    public function show($id)
    {
        // Cari dokumen berdasarkan ID
        $document = Document::with('data', 'file')->findOrFail($id);

        // Jika dokumen ditemukan, kirim ke view
        return view('document.show', compact('document'));
    }
}
