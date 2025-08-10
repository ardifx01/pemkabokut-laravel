<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\File;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $files = File::all();
        return view('index', compact('files'));
    }
    public function data()
    {
        $files = File::all();
        return view('admin.file.data', compact('files'));
    }
    public function create()
    {
        $documents = Document::all(); // Untuk dropdown pilihan dokumen
        $data = Data::all(); // Untuk dropdown pilihan data
        return view('admin.file.create', compact('documents', 'data'));
    }

    // Menyimpan file baru ke database
    public function store(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'file_path.*' => 'required|file|mimes:pdf,doc,docx,jpg,png,zip,rar,xls,xlsx|max:20000', // Validasi array file
            'file_date' => 'required|date',
            'document_id' => 'nullable|exists:documents,id',
            'data_id' => 'nullable|exists:data,id',
        ]);

        if ($request->hasFile('file_path')) {
            foreach ($request->file('file_path') as $file) {
                // Mendapatkan nama file asli
                $originalName = $file->getClientOriginalName();

                // Menyimpan file ke storage
                $path = $file->storeAs('files', $originalName);

                // Membuat entri file baru di database untuk setiap file
                File::create([
                    'file_path' => $path,
                    'file_date' => $request->file_date,
                    'document_id' => $request->document_id,
                    'data_id' => $request->data_id,
                ]);
            }
        }

        // Redirect ke halaman yang diinginkan (misalnya halaman daftar file)
        return redirect()->route('file.data')->with('success', 'Files created successfully.');
    }

    public function download($id)
    {
        $file = File::findOrFail($id);
        $pathToFile = storage_path('app/' . $file->file_path);

        return response()->download($pathToFile);
    }

    public function edit($id)
    {
        $file = File::findOrFail($id);
        $documents = Document::all(); // Untuk dropdown pilihan dokumen
        $data = Data::all(); // Untuk dropdown pilihan data
        return view('admin.file.edit', compact('file', 'documents', 'data'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang dikirim
        $request->validate([
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip,rar,xls,xlsx|max:20000',
            'file_date' => 'required|date',
            'document_id' => 'nullable|exists:documents,id',
            'data_id' => 'nullable|exists:data,id',
        ]);

        $file = File::findOrFail($id);

        // Jika ada file baru yang diunggah, ganti file yang lama
        if ($request->hasFile('file_path')) {
            // Hapus file lama dari storage
            if (Storage::exists($file->file_path)) {
                Storage::delete($file->file_path);
            }

            // Simpan file baru
            $newFile = $request->file('file_path');
            $originalName = $newFile->getClientOriginalName();
            $path = $newFile->storeAs('files', $originalName);
            $file->file_path = $path;
        }

        // Perbarui data file di database
        $file->file_date = $request->file_date;
        $file->document_id = $request->document_id;
        $file->data_id = $request->data_id;
        $file->save();

        // Redirect ke halaman yang diinginkan
        return redirect()->route('file.data')->with('success', 'File updated successfully.');
    }

    public function destroy($id)
    {
        $file = File::findOrFail($id);

        // Hapus file dari storage
        if (Storage::exists($file->file_path)) {
            Storage::delete($file->file_path);
        }

        // Hapus entri dari database
        $file->delete();

        return redirect()->route('file.data')->with('success', 'File deleted successfully.');
    }
    public function show($id)
    {
        $file = File::find($id);
        return view('admin.file.show', compact('file'));
    }
}
