<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\File;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        // Mengambil semua dokumen tanpa pengurutan
        $documents = Document::all();

        // Mengirimkan variabel $documents ke view index.blade.php
        return view('index', compact('documents'));
    }

    public function data()
    {
        $documents = Document::all();
        $datas = Data::all();
        return view('admin.document.data', compact('documents', 'datas'));
    }

    public function create()
    {
        $data = Data::all();
        return view('admin.document.create', compact('data'));
    }

    public function store(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'title' => 'required|string|max:255',
            'file_path.*' => 'required|file|mimes:pdf,doc,docx,jpg,png,zip,rar,xls,xlsx|max:20000', // Validasi file
            'file_date' => 'required|date',
        ]);

        // Buat Document baru dengan created_at dari file_date
        $document = Document::create([
            'title' => $request->title,
            'data_id' => $request->data_id,
            'user_id' => auth()->id(),
            'created_at' => $request->file_date,
        ]);

        // Simpan file yang terkait dengan dokumen
        if ($request->hasFile('file_path')) {
            foreach ($request->file('file_path') as $file) {
                $originalName = $file->getClientOriginalName();
                $path = $file->storeAs('files', $originalName);

                // Buat entri file baru di database
                File::create([
                    'file_path' => $path,
                    'file_date' => $request->file_date,
                    'document_id' => $document->id,
                    'data_id' => $request->data_id,
                    'user_id' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('document.data')->with('success', 'Document and Files created successfully.');
    }

    public function edit($id)
    {
        $document = Document::with('file')->findOrFail($id);
        $data = Data::all(); // Dropdown data

        return view('admin.document.edit', compact('document', 'data'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang dikirim
        $request->validate([
            'title' => 'required|string|max:255',
            'file_path.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip,rar,xls,xlsx|max:20000', // Validasi file
            'file_date' => 'required|date',
        ]);

        // Temukan dokumen berdasarkan ID
        $document = Document::findOrFail($id);

        // Update dokumen dan created_at
        $document->update([
            'title' => $request->title,
            'data_id' => $request->data_id,
            'created_at' => $request->file_date,
        ]);

        // Simpan file yang terkait dengan dokumen
        if ($request->hasFile('file_path')) {
            foreach ($request->file('file_path') as $file) {
                $originalName = $file->getClientOriginalName();
                $path = $file->storeAs('files', $originalName);

                // Buat entri file baru di database
                File::create([
                    'file_path' => $path,
                    'file_date' => $request->file_date,
                    'document_id' => $document->id,
                    'data_id' => $request->data_id,
                    'created_at' => $request->file_date,
                ]);
            }
        }

        return redirect()->route('document.data')->with('success', 'Document and Files updated successfully.');
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
        return view('admin.document.show', compact('document'));
    }
}
