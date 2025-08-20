<?php

namespace App\Http\Controllers;

use App\Models\Icon;
use App\Models\Dropdown;
use Illuminate\Http\Request;

class IconController extends Controller
{
    public function index()
    {
        $icons = Icon::all();
        $icons = Icon::with('dropdowns')->get();
        return view('admin.icon.data', compact('icons'));
    }

    public function data()
    {
        $icons = Icon::all();
        return view('admin.icon.data', compact('icons'));
    }

    // Show the form for creating a new icon.
    public function create()
    {
        return view('admin.icon.create');
    }

    // app/Http/Controllers/IconController.php

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dropdowns' => 'nullable|array',
            'dropdowns.*.title' => 'nullable|string',
            'dropdowns.*.link' => 'nullable|string',
        ]);

        // Proses upload gambar
        $originalName = $request->file('image')->getClientOriginalName();
        $imagePath = $request->file('image')->storeAs('uploads/icons', $originalName, 'public');

        // Buat Icon
        $icon = Icon::create([
            'title' => $request->input('title'),
            'image' => $imagePath,
            'user_id' => auth()->id(),
        ]);

        // Simpan dropdowns yang terkait
        if ($request->has('dropdowns')) {
            foreach ($request->input('dropdowns') as $dropdownData) {
                Dropdown::create([
                    'title' => $dropdownData['title'] ?? null,
                    'link' => $dropdownData['link'] ?? null,
                    'icon_id' => $icon->id,
                    'user_id' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('icon.index')->with('success', 'Icon and Dropdowns created successfully.');
    }

    // Display the specified icon.
    public function show(Icon $icon)
    {
        return view('admin.icon.show', compact('icon'));
    }

    // Show the form for editing the specified icon.
    public function edit($id)
    {
        // Ambil Icon berdasarkan ID beserta Dropdowns yang terkait
        $icon = Icon::with('dropdowns')->findOrFail($id);

        return view('admin.icon.edit', compact('icon'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dropdowns' => 'nullable|array',
            'dropdowns.*.title' => 'nullable|string',
            'dropdowns.*.link' => 'nullable|string',
        ]);

        // Temukan Icon berdasarkan ID
        $icon = Icon::findOrFail($id);

        // Update gambar jika ada file baru
        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('uploads/icons', $originalName, 'public');
            $icon->image = $imagePath;
        }

        // Update title
        $icon->title = $request->input('title');
        $icon->save();

        // Update dropdowns
        if ($request->has('dropdowns')) {
            // Hapus dropdowns lama
            $icon->dropdowns()->delete();

            // Simpan dropdowns baru
            foreach ($request->input('dropdowns') as $dropdownData) {
                Dropdown::create([
                    'title' => $dropdownData['title'] ?? null,
                    'link' => $dropdownData['link'] ?? null,
                    'icon_id' => $icon->id,
                ]);
            }
        }

        return redirect()->route('icon.index')->with('success', 'Icon and Dropdowns updated successfully.');
    }

    // Remove the specified icon from storage.
    public function destroy($id)
    {
        // Cari headline berdasarkan ID
        $icon = Icon::find($id);

        if (!$icon) {
            return redirect()->route('icon.index')->with('error', 'Icon not found.');
        }

        // Hapus headline
        $icon->delete();

        return redirect()->route('icon.index')->with('success', 'Icon deleted successfully.');
    }
}
