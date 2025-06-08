<?php

namespace App\Http\Controllers;


use DOMDocument;
use App\Models\Icon;
use App\Models\Post;
use App\Models\Category;
use App\Models\Document;
use App\Models\Headline;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::whereNotNull('headline_id')->orderBy('published_at', 'desc')->get();
        $icons = Icon::with('dropdowns')->get();
        $documents = Document::orderBy('id', 'desc')->take(4)->get();
        return view('index', compact('posts', 'icons', 'documents'));
    }

    public function data(Request $request)
    {
        // Cek apakah terdapat request untuk sorting, default adalah 'desc' (terbaru)
        $sort_order = $request->get('sort_order', 'desc');

        // Dapatkan posts dengan sorting berdasarkan 'id'
        $posts = Post::orderBy('id', $sort_order)->get();

        // Kirim variabel sorting order ke view agar tombol tetap sinkron
        return view('/post/data', compact('posts', 'sort_order'));
    }

    public function create()
    {
        $categories = Category::all();
        $headlines = Headline::all();
        return view('/post/create', compact('categories', 'headlines'));
    }

    public function store(Request $request)
    {
        $image_paths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Nama file ori
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();

                // Counter untuk duplikat file
                $filename = $originalName;
                $counter = 1;
                while (Storage::disk('public')->exists("uploads/{$filename}.{$extension}")) {
                    $filename = $originalName . " ({$counter})";
                    $counter++;
                }

                // Simpan file ke penyimpanan dengan nama baru
                $image_path = $image->storeAs('uploads', "{$filename}.{$extension}", 'public');

                // Membungkus path menjadi array
                $image_paths[] = $image_path;
            }
        }

        // Simpan array path gambar sebagai string JSON di database
        $description = $request->description;

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {
            $src = $img->getAttribute('src');

            // Mengecek jika base64-encoded
            if (strpos($src, 'data:image/') === 0) {
                $data = base64_decode(explode(',', explode(';', $src)[1])[1]);
                $image_name = "/uploads/" . time() . $key . '.png';
                file_put_contents(public_path() . $image_name, $data);

                $img->removeAttribute('src');
                $img->setAttribute('src', $image_name);
            }
        }
        $description = $dom->saveHTML();

        Post::create([
            'title' => $request->title,
            'image' => json_encode($image_paths), // Simpan sebagai JSON
            'description' => $description,
            'category_id' => $request->category_id,
            'headline_id' => $request->headline_id,
            'published_at' => $request->published_at,
        ]);

        return redirect('/post/data');
    }


    public function show($id)
    {
        $post = Post::find($id);

        $post->increment('views');

        return view('/post/show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::all();
        $headlines = Headline::all();
        return view('/post/edit', compact('post', 'categories', 'headlines'));
    }


    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        // Array untuk menyimpan path gambar
        $image_paths = json_decode($post->image, true) ?? [];

        // Proses file gambar yang diunggah
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Ambil nama asli file
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();

                // Membuat nama file yang unik
                $filename = $originalName;
                $counter = 1;
                while (Storage::disk('public')->exists("uploads/{$filename}.{$extension}")) {
                    $filename = $originalName . " ({$counter})";
                    $counter++;
                }

                // Simpan file ke penyimpanan dengan nama baru
                $image_path = $image->storeAs('uploads', "{$filename}.{$extension}", 'public');

                // Tambahkan path ke array
                $image_paths[] = $image_path;
            }
        }

        // Simpan array path gambar sebagai string JSON di database
        $description = $request->description;

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {
            $src = $img->getAttribute('src');

            // Check if the image is base64-encoded
            if (strpos($src, 'data:image/') === 0) {
                $data = base64_decode(explode(',', explode(';', $src)[1])[1]);
                $image_name = "/uploads/" . time() . $key . '.png';
                file_put_contents(public_path() . $image_name, $data);

                $img->removeAttribute('src');
                $img->setAttribute('src', $image_name);
            }
        }
        $description = $dom->saveHTML();

        // Update post dengan gambar dan deskripsi baru
        $post->update([
            'title' => $request->title,
            'image' => json_encode($image_paths), // Update gambar
            'description' => $description,
            'category_id' => $request->category_id,
            'headline_id' => $request->headline_id,
            'published_at' => $request->published_at,
        ]);

        return redirect('/post/data');
    }

    public function deleteImage(Request $request)
    {
        $post = Post::find($request->post_id);

        if ($post) {
            // Mengambil array gambar dari post
            $images = json_decode($post->image, true);

            // Mencari index dari gambar yang ingin dihapus
            if (($key = array_search($request->image, $images)) !== false) {
                // Hapus gambar dari array
                unset($images[$key]);

                // Hapus file dari storage jika ada
                if (Storage::disk('public')->exists($request->image)) {
                    Storage::disk('public')->delete($request->image);
                }

                // Update post dengan array gambar baru
                $post->image = json_encode(array_values($images));
                $post->save();

                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false]);
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return redirect()->back()->with('error', 'Post not found.');
        }

        // Hapus gambar terkait jika ada
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        // Hapus post
        $post->delete();

        return redirect('/post/data')->with('success', 'Post deleted successfully.');
    }

    public function search(Request $request)
    {
        // Ambil query pencarian
        $searchQuery = $request->input('query');

        // Pencarian untuk Document (prioritaskan dokumen)
        $documents = Document::where('title', 'LIKE', "%{$searchQuery}%")
            ->orWhereHas('file', function ($query) use ($searchQuery) {
                $query->where('file_path', 'LIKE', "%{$searchQuery}%");
            })->get();

        // Pencarian untuk Post
        $posts = Post::where('title', 'LIKE', "%{$searchQuery}%")
            ->orWhere('description', 'LIKE', "%{$searchQuery}%")
            ->get();

        // Gabungkan hasil pencarian, prioritas dokumen di awal
        $results = $documents->concat($posts);

        // Kirim hasil dan query pencarian ke view
        return view('post.search', compact('results', 'searchQuery'));
    }
}
