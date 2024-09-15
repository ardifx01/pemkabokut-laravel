<?php

namespace App\Http\Controllers;


use DOMDocument;
use App\Models\Post;
use App\Models\Category;
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
        return view('index', compact('posts'));
    }

    public function data()
    {
        $posts = Post::all();
        return view('/post/data', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $headlines = Headline::all();
        return view('/post/create', compact('categories', 'headlines'));
    }

    public function store(Request $request)
    {
        $image = null;
        if ($request->hasFile('image')) {
            // Ambil nama asli file
            $originalName = $request->file('image')->getClientOriginalName();

            // Menyimpan file dengan nama asli ke storage
            $image = $request->file('image')->storeAs('uploads', $originalName, 'public');
        }

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

        Post::create([
            'title' => $request->title,
            'image' => $image,
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

        if ($request->hasFile('image')) {
            // Delete old image
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }

            // Ambil nama asli file
            $originalName = $request->file('image')->getClientOriginalName();

            // Menyimpan file dengan nama asli ke storage
            $image = $request->file('image')->storeAs('uploads', $originalName, 'public');
            $post->image = $image;
        }

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

        $post->update([
            'title' => $request->title,
            'image' => $post->image,
            'description' => $description,
            'category_id' => $request->category_id,
            'headline_id' => $request->headline_id,
            'published_at' => $request->published_at,
        ]);

        return redirect('/post/data');
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
}
