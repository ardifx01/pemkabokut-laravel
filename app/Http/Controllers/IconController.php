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
        return view('icon.data', compact('icons'));
    }

    public function data()
    {
        $icons = Icon::all();
        return view('icon.data', compact('icons'));
    }

    // Show the form for creating a new icon.
    public function create()
    {
        return view('icon.create');
    }

    // app/Http/Controllers/IconController.php

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle the file upload
        $originalName = $request->file('image')->getClientOriginalName(); // Mendapatkan nama asli
        $imagePath = $request->file('image')->storeAs('uploads/icons', $originalName, 'public'); // Menggunakan storeAs

        Icon::create([
            'title' => $request->input('title'),
            'image' => $imagePath,
        ]);

        return redirect()->route('icon.index')->with('success', 'Icon created successfully.');
    }

    public function storeWithDropdowns(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dropdowns' => 'required|array',
            'dropdowns.*.title' => 'required|string',
            'dropdowns.*.link' => 'required|url',
        ]); 

        // Handle the file upload
        $originalName = $request->file('image')->getClientOriginalName(); // Mendapatkan nama asli
        $imagePath = $request->file('image')->storeAs('uploads/icons', $originalName, 'public'); // Menggunakan storeAs

        // Create Icon
        $icon = Icon::create([
            'title' => $request->input('title'),
            'image' => $imagePath,
        ]);

        // Create Dropdowns associated with this Icon
        foreach ($request->input('dropdowns') as $dropdown) {
            Dropdown::create([
                'title' => $dropdown['title'],
                'link' => $dropdown['link'],
                'icon_id' => $icon->id,
            ]);
        }

        return redirect()->route('icon.index')->with('success', 'Icon and Dropdowns created successfully.');
    }

    // Display the specified icon.
    public function show(Icon $icon)
    {
        return view('icons.show', compact('icon'));
    }

    // Show the form for editing the specified icon.
    public function edit(Icon $icon)
    {
        return view('icon.edit', compact('icon'));
    }

    // Update the specified icon in storage.
    public function update(Request $request, Icon $icon)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'dropdowns' => 'sometimes|array',
            'dropdowns.*.title' => 'required|string',
            'dropdowns.*.link' => 'required|url',
        ]);

        if ($request->hasFile('image')) {
            // Handle the file upload
            $imagePath = $request->file('image')->store('uploads/icons', 'public');
            $icon->image = $imagePath;
        }

        $icon->title = $request->input('title');
        $icon->save();

        // Handle dropdowns update
        if ($request->has('dropdowns')) {
            foreach ($request->input('dropdowns') as $dropdownId => $dropdownData) {
                if (str_starts_with($dropdownId, 'new_')) {
                    // Create new dropdown
                    Dropdown::create([
                        'title' => $dropdownData['title'],
                        'link' => $dropdownData['link'],
                        'icon_id' => $icon->id,
                    ]);
                } else {
                    // Update existing dropdown
                    $dropdown = Dropdown::find($dropdownId);
                    if ($dropdown) {
                        $dropdown->update([
                            'title' => $dropdownData['title'],
                            'link' => $dropdownData['link'],
                        ]);
                    }
                }
            }
        }

        return redirect()->route('home')->with('success', 'Icon and Dropdowns updated successfully.');
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
