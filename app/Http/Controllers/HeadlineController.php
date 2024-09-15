<?php

namespace App\Http\Controllers;

use App\Models\Headline;
use Illuminate\Http\Request;

class HeadlineController extends Controller
{
    public function data()
    {
        $headlines = Headline::all();
        return view('headline.data', compact('headlines'));
    }

    public function create()
    {
        return view('headline.create');
    }

    public function show($id)
    {
        $headline = Headline::find($id);
        return view('/headline/show', compact('headlines'));
    }

    public function store(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Buat headline baru
        Headline::create([
            'title' => $request->title,
        ]);

        // Redirect ke halaman yang diinginkan (misalnya halaman daftar headline)
        return redirect()->route('headline.data')->with('success', 'Headline created successfully.');
    }

    // Fungsi untuk menampilkan form edit headline
    public function edit($id)
    {
        // Cari headline berdasarkan ID
        $headline = Headline::find($id);

        // Jika headline tidak ditemukan, kembalikan dengan pesan error
        if (!$headline) {
            return redirect()->route('headline.data')->with('error', 'Headline not found.');
        }

        // Tampilkan view untuk mengedit headline
        return view('headline.edit', compact('headline'));
    }

    // Fungsi untuk memperbarui headline
    public function update(Request $request, $id)
    {
        // Validasi data yang dikirim
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Cari headline berdasarkan ID
        $headline = Headline::find($id);

        // Jika headline tidak ditemukan, kembalikan dengan pesan error
        if (!$headline) {
            return redirect()->route('headline.data')->with('error', 'Headline not found.');
        }

        // Update data headline
        $headline->update([
            'title' => $request->title,
        ]);

        // Redirect kembali ke halaman daftar headline dengan pesan sukses
        return redirect()->route('headline.data')->with('success', 'Headline updated successfully.');
    }
    
    public function destroy($id)
    {
        // Cari headline berdasarkan ID
        $headline = Headline::find($id);

        // Jika headline tidak ditemukan, kembalikan dengan pesan error
        if (!$headline) {
            return redirect()->route('headline.data')->with('error', 'Headline not found.');
        }

        // Hapus headline
        $headline->delete();

        // Redirect kembali ke halaman daftar headline dengan pesan sukses
        return redirect()->route('headline.data')->with('success', 'Headline deleted successfully.');
    }
}
