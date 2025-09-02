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

                    <!-- Dynamic Files Section -->
                    <div class="file-section" style="margin-top: 20px;">
                        <h5>Add Files</h5>
                        <div class="file-entry">
                            <div class="mb-3">
                                <label for="file_title" class="form-label">File Title</label>
                                <input type="text" name="files[0][title]" class="form-control"
                                    placeholder="Enter file title">
                            </div>
                            <div class="mb-3">
                                <label for="file_path" class="form-label">Choose File</label>
                                <input type="file" name="files[0][file]" class="form-control"
                                    accept=".pdf,.doc,.docx,.jpg,.png,.zip,.rar,.xls,.xlsx">
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary" id="add-file">Add File</button>

                    <!-- Input untuk tanggal file -->
                    <div class="mb-3" style="margin-top: 20px;">
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

    <!-- Script untuk mengelola Select2 dan dynamic files -->
    <script>
        let fileIndex = 1;
        document.getElementById('add-file').addEventListener('click', function() {
            const fileSection = document.querySelector('.file-section');
            const newFile = `
                <div class="file-entry mt-4">
                    <div class="mb-3">
                        <label for="file_title" class="form-label">File Title</label>
                        <input type="text" name="files[${fileIndex}][title]" class="form-control" placeholder="Enter file title">
                    </div>
                    <div class="mb-3">
                        <label for="file_path" class="form-label">Choose File</label>
                        <input type="file" name="files[${fileIndex}][file]" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png,.zip,.rar,.xls,.xlsx">
                    </div>
                </div>
            `;
            fileSection.insertAdjacentHTML('beforeend', newFile);
            fileIndex++;
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
