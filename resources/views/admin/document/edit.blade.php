@extends('admin.layouts.navigation')

@section('content')
    <div class="container p-4">
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="text-center">
                    <h1>Edit Document and Files</h1>
                </div>

                <!-- Form untuk edit dokumen dan mengunggah file -->
                <form action="{{ route('document.update', $document->id) }}" method="post" enctype="multipart/form-data"
                    id="file-form">
                    @csrf
                    @method('PATCH')

                    <!-- Input untuk judul dokumen -->
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" name="title" id="title"
                            value="{{ old('title', $document->title) }}">
                        @if ($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <!-- Dropdown untuk memilih Data -->
                    <label for="data_id">Data:</label>
                    <select name="data_id" class="form-control" id="data-select">
                        <option value="">-- Select Data --</option>
                        @foreach ($data as $dataItem)
                            <option value="{{ $dataItem->id }}" {{ $dataItem->id == $document->data_id ? 'selected' : '' }}>
                                {{ $dataItem->title }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Pratinjau file yang sudah ada -->
                    <div class="mb-3">
                        <label for="current_files" class="form-label">Current Files:</label>
                        @if ($document->file->isNotEmpty())
                            @foreach ($document->file as $index => $file)
                                <div class="file-item d-flex align-items-center mb-2" style="position: relative;">
                                    <img src="{{ asset('icons/' . strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION)) . '-icon.png') }}"
                                        alt="File Icon" width="50" class="me-2">
                                    <div class="me-2" style="flex: 1;">
                                        <label class="form-label">File Title</label>
                                        <input type="text" class="form-control"
                                            name="existing_files[{{ $file->id }}][title]"
                                            value="{{ old('existing_files.' . $file->id . '.title', $file->title ?? basename($file->file_path)) }}"
                                            placeholder="Enter file title">
                                        <small class="text-muted">File:
                                            {{ str_replace('files/', '', $file->file_path) }}</small>
                                    </div>
                                    <a href="{{ route('file.download', $file->id) }}"
                                        class="btn btn-sm btn-outline-primary me-2" target="_blank"
                                        style="margin-top: 7px;">Download</a>
                                    <button type="button" class="btn btn-danger btn-sm delete-existing-file"
                                        data-file-id="{{ $file->id }}"
                                        style="margin-top: 7px; width: 30px; height: 30px; border-radius: 50%; padding: 0; font-size: 14px;">×</button>
                                </div>
                            @endforeach
                        @else
                            <p>No files uploaded yet.</p>
                        @endif
                    </div>

                    <!-- Input untuk mengganti atau menambah file -->
                    <div id="file-sections">
                        <div class="file-section mb-3">
                            <div class="d-flex align-items-center">
                                <div class="me-2" style="flex: 1;">
                                    <label class="form-label">File Title</label>
                                    <input type="text" class="form-control" name="files[0][title]"
                                        placeholder="Enter file title">
                                </div>
                                <div class="me-2" style="flex: 1;">
                                    <label class="form-label">Upload File</label>
                                    <input type="file" class="form-control" name="files[0][file]">
                                </div>
                                <button type="button" class="btn btn-danger remove-file-section"
                                    style="margin-top: 32px;">Remove</button>
                            </div>
                        </div>
                    </div>

                    <!-- Button untuk menambahkan file baru -->
                    <button type="button" id="add-file-btn" class="btn btn-secondary mb-3">Add Another File</button>

                    <!-- Input untuk tanggal file -->
                    <div class="mb-3">
                        <label for="file_date" class="form-label">File Date</label>
                        <input type="date" class="form-control" id="file_date" name="file_date"
                            value="{{ old('file_date', $document->file->first()->file_date ?? '') }}" required>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-lg btn-primary mt-3">Update Document</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tambahkan CSS untuk mengatur Select2 dan preview file -->
    <style>
        .select2-container .select2-selection--single {
            height: 37px;
            padding: 3px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 30px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }

        .file-item {
            position: relative;
            display: inline-block;
            margin-right: 10px;
        }

        .remove-file-btn {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            cursor: pointer;
        }
    </style>

    <!-- Script untuk mengelola Select2 dan dynamic file upload -->
    <script>
        let fileIndex = 1;

        // Function to add new file section
        function addFileSection() {
            const fileSections = document.getElementById('file-sections');
            const newSection = document.createElement('div');
            newSection.className = 'file-section mb-3';
            newSection.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="me-2" style="flex: 1;">
                        <label class="form-label">File Title</label>
                        <input type="text" class="form-control" name="files[${fileIndex}][title]" placeholder="Enter file title">
                    </div>
                    <div class="me-2" style="flex: 1;">
                        <label class="form-label">Upload File</label>
                        <input type="file" class="form-control" name="files[${fileIndex}][file]">
                    </div>
                    <button type="button" class="btn btn-danger remove-file-section" style="margin-top: 32px;">Remove</button>
                </div>
            `;
            fileSections.appendChild(newSection);
            fileIndex++;
        }

        // Event listener untuk tombol Add File
        document.getElementById('add-file-btn').addEventListener('click', addFileSection);

        // Event delegation untuk tombol Remove
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-file-section')) {
                const fileSections = document.querySelectorAll('.file-section');
                if (fileSections.length > 1) {
                    e.target.closest('.file-section').remove();
                } else {
                    alert('At least one file section is required.');
                }
            }

            // Handle delete existing file
            if (e.target.classList.contains('delete-existing-file')) {
                const fileId = e.target.getAttribute('data-file-id');

                if (confirm('Are you sure you want to delete this file?')) {
                    // Send AJAX request to delete file
                    fetch(`/admin/file/${fileId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Remove the file element from DOM
                                e.target.closest('.file-item').remove();
                                alert('File deleted successfully');
                            } else {
                                alert('Error deleting file');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error deleting file');
                        });
                }
            }
        });

        // Inisialisasi Select2
        document.addEventListener('DOMContentLoaded', function() {
            $('#data-select').select2({
                placeholder: '-- Select Data --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
