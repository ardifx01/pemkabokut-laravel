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
        return view('/file/data', compact('files'));
    }
    public function create()
    {
        $documents = Document::all(); // Untuk dropdown pilihan dokumen
        $data = Data::all(); // Untuk dropdown pilihan data
        return view('/file/create', compact('documents', 'data'));
    }

    // Menyimpan file baru ke database
    public function store(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'title' => 'required|string|max:255',
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
                    'title' => $request->title,
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
        return view('/file/show', compact('file'));
    }
}
