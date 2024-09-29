<?php

namespace App\Http\Controllers;

use App\Models\Icon;
use Illuminate\Http\Request;

class IconController extends Controller
{
    public function index()
    {
        $icons = Icon::all();
        return view('icon.index', compact('icons'));
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
        $imagePath = $request->file('image')->store('uploads/icons', 'public');

        Icon::create([
            'title' => $request->input('title'),
            'image' => $imagePath,
        ]);

        // Redirect to the index page (using route name 'home')
        return redirect()->route('home')->with('success', 'Icon created successfully.');
    }

    // Display the specified icon.
    public function show(Icon $icon)
    {
        return view('icons.show', compact('icon'));
    }

    // Show the form for editing the specified icon.
    public function edit(Icon $icon)
    {
        return view('icons.edit', compact('icon'));
    }

    // Update the specified icon in storage.
    public function update(Request $request, Icon $icon)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Handle the file upload
            $imagePath = $request->file('image')->store('uploads/icons', 'public');
            $icon->image = $imagePath;
        }

        $icon->title = $request->input('title');
        $icon->save();

        return redirect()->route('/')->with('success', 'Icon updated successfully.');
    }

    // Remove the specified icon from storage.
    public function destroy(Icon $icon)
    {
        $icon->delete();
        return redirect()->route('icons.index')->with('success', 'Icon deleted successfully.');
    }
}
