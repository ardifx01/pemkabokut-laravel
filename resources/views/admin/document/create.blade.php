@extends('admin.layouts.navigation')

@section('content')
    <div class="container p-4">
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="text-center">
                    <h1>Create a New Document and Upload Files</h1>
                </div>

                <!-- Form untuk membuat dokumen dan mengunggah file -->
                <form action="{{ route('document.store') }}" method="post" enctype="multipart/form-data" id="file-form">
                    @csrf

                    <!-- Input untuk judul dokumen -->
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" name="title" id="title"
                            value="{{ old('title') }}">
                        @if ($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <!-- Dropdown untuk memilih Data -->
                    <label for="data_id">Data:</label>
                    <select name="data_id" class="form-control" id="data-select">
                        <option value="">-- Select Data --</option>
                        @foreach ($data as $dataItem)
                            <option value="{{ $dataItem->id }}">{{ $dataItem->title }}</option>
                        @endforeach
                    </select>

                    <!-- Input untuk memilih file -->
                    <div class="mb-3 d-flex align-items-center">
                        <div class="me-2" style="flex: 1;">
                            <label for="file_path" class="form-label">Files</label>
                            <input type="file" class="form-control" id="file_path" name="file_path[]" multiple required
                                style="width: 725px;">
                        </div>

                        <!-- Button untuk menambahkan file -->
                        <button type="button" id="add-file-btn" class="btn btn-secondary mb-3" style="margin-top: 45px">Add
                            File</button>
                    </div>

                    <!-- Container untuk ikon dan nama file -->
                    <div id="file-preview" class="mt-3"></div>

                    <!-- Input untuk tanggal file -->
                    <div class="mb-3">
                        <label for="file_date" class="form-label">File Date</label>
                        <input type="date" class="form-control" id="file_date" name="file_date"
                            value="{{ old('file_date') }}" required>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-lg btn-primary mt-3">Submit</button>
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

    <!-- Script untuk mengelola Select2 dan preview file -->
    <script>
        const fileInput = document.getElementById('file_path');
        const filePreviewContainer = document.getElementById('file-preview');
        let selectedFiles = new DataTransfer();

        // Fungsi untuk memperbarui pratinjau file
        function updateFilePreview(files) {
            Array.from(files).forEach((file, index) => {
                const fileExtension = file.name.split('.').pop().toLowerCase();
                let iconPath = '';

                if (fileExtension === 'pdf') {
                    iconPath = '{{ asset('icon/pdf-icon.png') }}';
                } else if (['doc', 'docx'].includes(fileExtension)) {
                    iconPath = '{{ asset('icon/word-icon.png') }}';
                } else if (['xls', 'xlsx'].includes(fileExtension)) {
                    iconPath = '{{ asset('icon/excel-icon.png') }}';
                } else {
                    iconPath = '{{ asset('icon/default-icon.png') }}'; // Ikon default
                }

                selectedFiles.items.add(file);

                const fileItem = document.createElement('div');
                fileItem.classList.add('file-item');

                const fileIcon = document.createElement('img');
                fileIcon.src = iconPath;
                fileIcon.alt = 'File Icon';
                fileIcon.width = 50;
                fileIcon.classList.add('me-2');

                const fileName = document.createElement('span');
                fileName.textContent = file.name;

                const removeBtn = document.createElement('button');
                removeBtn.classList.add('remove-file-btn');
                removeBtn.textContent = 'X';

                removeBtn.addEventListener('click', function() {
                    fileItem.remove();
                    selectedFiles.items.remove(index);
                    fileInput.files = selectedFiles.files;

                    if (selectedFiles.items.length === 0) {
                        fileInput.value = ''; // Reset input file jika kosong
                    }
                });

                fileItem.appendChild(fileIcon);
                fileItem.appendChild(fileName);
                fileItem.appendChild(removeBtn);
                filePreviewContainer.appendChild(fileItem);
            });

            fileInput.files = selectedFiles.files;
        }

        // Trigger file input ketika "Add File" diklik
        document.getElementById('add-file-btn').addEventListener('click', function() {
            fileInput.click();
        });

        // Perbarui pratinjau ketika file dipilih
        fileInput.addEventListener('change', function(event) {
            updateFilePreview(event.target.files);
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
