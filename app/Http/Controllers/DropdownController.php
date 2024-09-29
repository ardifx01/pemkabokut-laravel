<?php

namespace App\Http\Controllers;

use App\Models\Icon;
use App\Models\Dropdown;
use Illuminate\Http\Request;

class DropdownController extends Controller
{
    public function index()
    {
        $dropdowns = Dropdown::with('icon')->get();
        return view('dropdowns.index', compact('dropdowns'));
    }

    // Show the form for creating a new dropdown.
    public function create()
    {
        $icons = Icon::all(); // Get all icons to associate with dropdown
        return view('dropdowns.create', compact('icons'));
    }

    // Store a newly created dropdown in storage.
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'link' => 'required|url',
            'icon_id' => 'required|exists:icons,id'
        ]);

        Dropdown::create($request->all());

        return redirect()->route('dropdowns.index')->with('success', 'Dropdown created successfully.');
    }

    // Display the specified dropdown.
    public function show(Dropdown $dropdown)
    {
        return view('dropdowns.show', compact('dropdown'));
    }

    // Show the form for editing the specified dropdown.
    public function edit(Dropdown $dropdown)
    {
        $icons = Icon::all(); // Get all icons to associate with dropdown
        return view('dropdowns.edit', compact('dropdown', 'icons'));
    }

    // Update the specified dropdown in storage.
    public function update(Request $request, Dropdown $dropdown)
    {
        $request->validate([
            'title' => 'required',
            'link' => 'required|url',
            'icon_id' => 'required|exists:icons,id'
        ]);

        $dropdown->update($request->all());

        return redirect()->route('dropdowns.index')->with('success', 'Dropdown updated successfully.');
    }

    // Remove the specified dropdown from storage.
    public function destroy(Dropdown $dropdown)
    {
        $dropdown->delete();
        return redirect()->route('dropdowns.index')->with('success', 'Dropdown deleted successfully.');
    }
}
