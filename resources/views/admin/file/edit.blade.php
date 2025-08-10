@extends('layout')

@section('content')
    <section style="padding-top: 100px;">
        <div class="container p-5">
            <div class="text-center">
                <h1>Edit File</h1>
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

            <form action="{{ route('file.update', $file->id) }}" method="POST" enctype="multipart/form-data" id="file-form">
                @csrf
                @method('PUT')

                <div class="mb-3 d-flex align-items-center">
                    <div class="me-2" style="flex: 1;">
                        <label for="file_path" class="form-label">Files</label>
                        <input type="file" class="form-control" id="file_path" name="file_path[]" multiple
                            style="width: 725px;">
                    </div>

                    <!-- Button to trigger file input -->
                    <button type="button" id="add-file-btn" class="btn btn-secondary mb-3" style="margin-top: 45px">Add
                        File</button>
                </div>

                <!-- Container untuk ikon dan nama file yang sudah ada dan yang dipilih -->
                <div id="file-preview" class="mt-3">
                    @if ($file->file_path)
                        <!-- Pratinjau file yang sudah ada -->
                        @php
                            $fileExtension = pathinfo($file->file_path, PATHINFO_EXTENSION);
                            $iconPath = '';

                            if ($fileExtension === 'pdf') {
                                $iconPath = asset('icons/pdf-icon.png');
                            } elseif (in_array($fileExtension, ['doc', 'docx'])) {
                                $iconPath = asset('icons/word-icon.png');
                            } elseif (in_array($fileExtension, ['xls', 'xlsx'])) {
                                $iconPath = asset('icons/excel-icon.png');
                            } else {
                                $iconPath = asset('icons/default-icon.png');
                            }
                        @endphp

                        <div class="file-item d-flex align-items-center mb-2">
                            <img src="{{ $iconPath }}" alt="File Icon" width="50" class="me-2">
                            <span>{{ basename($file->file_path) }}</span>
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="file_date" class="form-label">File Date</label>
                    <input type="date" class="form-control" id="file_date" name="file_date" value="{{ old('file_date', $file->file_date) }}" required>
                </div>

                <div class="mb-3">
                    <label for="document_id" class="form-label">Document</label>
                    <select class="form-control select2" id="document_id" name="document_id" data-placeholder="Select a Document">
                        <option value="">Select a Document</option>
                        @foreach ($documents as $document)
                            <option value="{{ $document->id }}" {{ $document->id == $file->document_id ? 'selected' : '' }}>
                                {{ $document->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="data_id" class="form-label">Data</label>
                    <select class="form-control select2" id="data_id" name="data_id" data-placeholder="Select Data">
                        <option value="">Select Data</option>
                        @foreach ($data as $dataItem)
                            <option value="{{ $dataItem->id }}" {{ $dataItem->id == $file->data_id ? 'selected' : '' }}>
                                {{ $dataItem->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update File</button>
            </form>
        </div>
    </section>

    <!-- Tambahkan CSS untuk mengatur tinggi Select2 -->
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

                if (fileExtension === 'pdf') {
                    iconPath = '{{ asset('icons/pdf-icon.png') }}';
                } else if (['doc', 'docx'].includes(fileExtension)) {
                    iconPath = '{{ asset('icons/word-icon.png') }}';
                } else if (['xls', 'xlsx'].includes(fileExtension)) {
                    iconPath = '{{ asset('icons/excel-icon.png') }}';
                } else {
                    iconPath = '{{ asset('icons/default-icon.png') }}';
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
                        fileInput.value = '';
                    }
                });

                fileItem.appendChild(fileIcon);
                fileItem.appendChild(fileName);
                fileItem.appendChild(removeBtn);
                filePreviewContainer.appendChild(fileItem);
            });

            fileInput.files = selectedFiles.files;
        }

        document.getElementById('add-file-btn').addEventListener('click', function() {
            fileInput.click();
        });

        fileInput.addEventListener('change', function(event) {
            updateFilePreview(event.target.files);
        });

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
