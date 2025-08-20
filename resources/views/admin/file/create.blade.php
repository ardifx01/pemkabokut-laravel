@extends('admin.layouts.navigation')

@section('content')
    <div class="container p-5">
        <div class="text-center">
            <h1>Create New File</h1>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('file.store') }}" method="POST" enctype="multipart/form-data" id="file-form">
            @csrf

            <div class="mb-3 d-flex align-items-center">
                <div class="me-2" style="flex: 1;">
                    <label for="file_path" class="form-label">Files</label>
                    <input type="file" class="form-control" id="file_path" name="file_path[]" multiple required
                        style="width: 725px;">
                </div>

                <!-- Button to trigger file input -->
                <button type="button" id="add-file-btn" class="btn btn-secondary mb-3" style="margin-top: 45px">Add
                    File</button>
            </div>

            <!-- Container untuk ikon dan nama file -->
            <div id="file-preview" class="mt-3"></div>

            <div class="mb-3">
                <label for="file_date" class="form-label">File Date</label>
                <input type="date" class="form-control" id="file_date" name="file_date" value="{{ old('file_date') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="document_id" class="form-label">Document</label>
                <select class="form-control select2" id="document_id" name="document_id"
                    data-placeholder="Select a Document">
                    <option value="">Select a Document</option>
                    @foreach ($documents as $document)
                        <option value="{{ $document->id }}">{{ $document->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="data_id" class="form-label">Data</label>
                <select class="form-control select2" id="data_id" name="data_id" data-placeholder="Select Data">
                    <option value="">Select Data</option>
                    @foreach ($data as $dataItem)
                        <option value="{{ $dataItem->id }}">{{ $dataItem->title }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create Files</button>
        </form>
    </div>

    <!-- Tambahkan CSS untuk mengatur tinggi Select2 -->
    <style>
        .select2-container .select2-selection--single {
            height: 37px;
            /* Sesuaikan tinggi sesuai kebutuhan */
            padding: 3px;
            /* Sesuaikan padding untuk konten di dalamnya */
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 30px;
            /* Sesuaikan line-height agar teks berada di tengah */
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
            /* Sesuaikan tinggi panah dropdown */
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

    <!-- Script untuk menampilkan ikon file dan nama file -->
    <script>
        const fileInput = document.getElementById('file_path');
        const filePreviewContainer = document.getElementById('file-preview');
        let selectedFiles = new DataTransfer();

        // Fungsi untuk memperbarui pratinjau file
        function updateFilePreview(files) {
            Array.from(files).forEach((file, index) => {
                const fileExtension = file.name.split('.').pop().toLowerCase();
                let iconPath = '';

                // Tentukan ikon berdasarkan ekstensi file
                if (fileExtension === 'pdf') {
                    iconPath = '{{ asset('icons/pdf-icon.png') }}';
                } else if (['doc', 'docx'].includes(fileExtension)) {
                    iconPath = '{{ asset('icons/word-icon.png') }}';
                } else if (['xls', 'xlsx'].includes(fileExtension)) {
                    iconPath = '{{ asset('icons/excel-icon.png') }}';
                } else {
                    iconPath = '{{ asset('icons/default-icon.png') }}'; // Ikon default
                }

                // Tambahkan file ke DataTransfer
                selectedFiles.items.add(file);

                // Buat elemen untuk menampilkan ikon dan nama file
                const fileItem = document.createElement('div');
                fileItem.classList.add('file-item');

                const fileIcon = document.createElement('img');
                fileIcon.src = iconPath;
                fileIcon.alt = 'File Icon';
                fileIcon.width = 50;
                fileIcon.classList.add('me-2');

                const fileName = document.createElement('span');
                fileName.textContent = file.name;

                // Tambahkan tombol X untuk menghapus file
                const removeBtn = document.createElement('button');
                removeBtn.classList.add('remove-file-btn');
                removeBtn.textContent = 'X';

                // Hapus file dari daftar file yang dipilih dan pratinjau
                removeBtn.addEventListener('click', function() {
                    fileItem.remove();
                    selectedFiles.items.remove(index); // Hapus file dari DataTransfer
                    fileInput.files = selectedFiles.files; // Update input dengan file yang tersisa

                    // Jika tidak ada file tersisa, kosongkan input file
                    if (selectedFiles.items.length === 0) {
                        fileInput.value = ''; // Reset input file
                    }
                });

                fileItem.appendChild(fileIcon);
                fileItem.appendChild(fileName);
                fileItem.appendChild(removeBtn);
                filePreviewContainer.appendChild(fileItem);
            });

            // Update elemen input file dengan file yang dipilih
            fileInput.files = selectedFiles.files;
        }

        // Trigger file input when "Add File" button is clicked
        document.getElementById('add-file-btn').addEventListener('click', function() {
            fileInput.click();
        });

        // Update file preview when files are selected
        fileInput.addEventListener('change', function(event) {
            updateFilePreview(event.target.files);
        });

        // Inisialisasi Select2 untuk setiap dropdown dengan placeholder berbeda
        document.addEventListener('DOMContentLoaded', function() {
            $('#document_id').select2({
                placeholder: $('#document_id').data('placeholder'),
                allowClear: true,
                width: '100%'
            });

            $('#data_id').select2({
                placeholder: $('#data_id').data('placeholder'),
                allowClear: true,
                width: '100%'
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
