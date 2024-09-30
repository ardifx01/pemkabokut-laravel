@extends('layout')

@section('content')
    <div class="container" style="margin-top: 100px; height: auto;">
        <h1>Edit Icon and Dropdowns</h1>

        <form action="{{ route('icon.update', $icon->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Icon Title</label>
                <input type="text" name="title" class="form-control" id="title" value="{{ $icon->title }}" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Icon Image</label>
                @if($icon->image)
                    <img src="{{ asset('storage/' . $icon->image) }}" alt="{{ $icon->title }}" class="img-thumbnail mb-2" width="100">
                @endif
                <input type="file" name="image" class="form-control" id="image">
                <small class="form-text text-muted">Leave empty if you don't want to change the image.</small>
            </div>

            {{-- Dynamic Dropdowns Section --}}
            <div class="dropdown-section">
                <h5>Edit Dropdowns</h5>
                
                @foreach($icon->dropdowns as $index => $dropdown)
                    <div class="dropdown-entry">
                        <div class="mb-3">
                            <label for="dropdown_title_{{ $index }}" class="form-label">Dropdown Title</label>
                            <input type="text" name="dropdowns[{{ $dropdown->id }}][title]" class="form-control" value="{{ $dropdown->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="dropdown_link_{{ $index }}" class="form-label">Dropdown Link</label>
                            <input type="url" name="dropdowns[{{ $dropdown->id }}][link]" class="form-control" value="{{ $dropdown->link }}" required>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm remove-dropdown" data-dropdown-id="{{ $dropdown->id }}">Delete Dropdown</button>
                    </div>
                @endforeach
            </div>

            <button type="button" class="btn btn-secondary" id="add-dropdown">Add New Dropdown</button>

            <button type="submit" class="btn btn-primary mt-3">Update Icon and Dropdowns</button>
        </form>
    </div>

    <script>
        let dropdownIndex = {{ $icon->dropdowns->count() }};

        // Add new dropdown input fields
        document.getElementById('add-dropdown').addEventListener('click', function () {
            const dropdownSection = document.querySelector('.dropdown-section');
            const newDropdown = `
                <div class="dropdown-entry mt-4">
                    <div class="mb-3">
                        <label for="dropdown_title_${dropdownIndex}" class="form-label">Dropdown Title</label>
                        <input type="text" name="dropdowns[new_${dropdownIndex}][title]" class="form-control" placeholder="Enter dropdown title" required>
                    </div>
                    <div class="mb-3">
                        <label for="dropdown_link_${dropdownIndex}" class="form-label">Dropdown Link</label>
                        <input type="url" name="dropdowns[new_${dropdownIndex}][link]" class="form-control" placeholder="Enter dropdown link" required>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-dropdown">Delete Dropdown</button>
                </div>
            `;
            dropdownSection.insertAdjacentHTML('beforeend', newDropdown);
            dropdownIndex++;
        });

        // Remove dropdown entry
        document.addEventListener('click', function (event) {
            if (event.target && event.target.matches('.remove-dropdown')) {
                const entry = event.target.closest('.dropdown-entry');
                entry.remove();
            }
        });
    </script>
@endsection
