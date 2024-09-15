<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function data()
    {
        $categories = Category::all();
        return view('category.data', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Buat kategori baru
        Category::create([
            'title' => $request->title,
        ]);

        // Redirect ke halaman yang diinginkan (misalnya halaman daftar kategori)
        return redirect()->route('category.data')->with('success', 'Category created successfully.');
    }

    // Fungsi untuk menampilkan form edit kategori
    public function edit($id)
    {
        // Cari kategori berdasarkan ID
        $category = Category::find($id);

        // Jika kategori tidak ditemukan, kembalikan dengan pesan error
        if (!$category) {
            return redirect()->route('category.data')->with('error', 'Category not found.');
        }

        // Tampilkan view untuk mengedit kategori
        return view('category.edit', compact('category'));
    }

    // Fungsi untuk memperbarui kategori
    public function update(Request $request, $id)
    {
        // Validasi data yang dikirim
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Cari kategori berdasarkan ID
        $category = Category::find($id);

        // Jika kategori tidak ditemukan, kembalikan dengan pesan error
        if (!$category) {
            return redirect()->route('category.data')->with('error', 'Category not found.');
        }

        // Update data kategori
        $category->update([
            'title' => $request->title,
        ]);

        // Redirect kembali ke halaman daftar kategori dengan pesan sukses
        return redirect()->route('category.data')->with('success', 'Category updated successfully.');
    }
    
    public function destroy($id)
    {
        // Cari kategori berdasarkan ID
        $category = Category::find($id);

        // Jika kategori tidak ditemukan, kembalikan dengan pesan error
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found.');
        }

        // Hapus kategori
        $category->delete();

        // Redirect kembali ke halaman daftar kategori dengan pesan sukses
        return redirect('category/data')->with('success', 'Category deleted successfully.');
    }
}
