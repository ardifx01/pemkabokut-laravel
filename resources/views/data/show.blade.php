@extends('layout')

@section('title', $data->category->title)

@section('content')
    <section id="judul-section"
        style="position: relative; background-image: url('{{ asset('images/backgroundb.png') }}'); background-size: 1625px 225px; background-repeat: no-repeat; background-position: center 50%; padding-top: 150px; width: 100%; height: 245px; margin-left: 0%; margin-top: 85px;">
        <div id="overlay"
            style="position: absolute; top: 0; left: 0; width: 100%; height: 94%; background-color: rgba(0, 0, 0, 0.5);">
        </div>
        <div class="container" style="position: relative; z-index: 1; top: -50px; margin-left: 10%">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0" style="font-family: 'Roboto', sans-serif; font-weight: bold;">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}" class="text-white">Beranda</a>
                        <span class="text-white mx-2">></span>
                    </li>
                    <li class="breadcrumb-item active text-white" aria-current="page">{{ $data->category->title }}</li>
                </ol>
            </nav>
            <h2 class="text-white" style="font-family: 'Roboto', sans-serif; font-weight: bold;">{{ $data->title }}</h2>
        </div>
    </section>

    <section style="padding-top: 0px; width: 120%; margin-left: -10%; font-family: 'Roboto', sans-serif;">
        <div class="container bg-black text-dark p-4 shadow rounded-4 border-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 id="selectedDocumentTitle">
                                @if ($data->document && $data->document->first())
                                    {{ $data->document->first()->title }}
                                @else
                                    Tidak ada dokumen tersedia
                                @endif
                            </h4>
                            @if ($data->document && $data->document->count() > 0)
                                <div class="d-flex align-items-center">
                                    <label for="document-select" class="me-2" style="white-space: nowrap;">Pilih
                                        Dokumen:</label>
                                    <!-- Select2 Dropdown -->
                                    <select id="document-select" class="form-control select2"
                                        placeholder="Ketik untuk mencari dokumen...">
                                        @foreach ($data->document as $document)
                                            <option value="document-{{ $document->id }}">{{ $document->title }}</option>
                                        @endforeach
                                    </select>
                                    <button id="search-button" class="btn btn-primary ms-2">Search</button>
                                    <!-- Tombol Search -->
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                @if ($data->document && $data->document->count() > 0)
                                    <table class="table table-striped table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Tahun</th>
                                                <th>File Path</th> <!-- Ganti Judul Menjadi File Path -->
                                                <th>Tanggal Upload</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        @foreach ($data->document as $document)
                                            <tbody id="document-{{ $document->id }}" class="document-section"
                                                style="display: none;">
                                                @if ($document->file && $document->file->count() > 0)
                                                    @foreach ($document->file as $file)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($file->file_date)->format('Y') }}
                                                            </td>
                                                            <td>{{ basename($file->file_path) }}</td>
                                                            <!-- Ganti dengan file_path -->
                                                            <td>{{ \Carbon\Carbon::parse($file->file_date)->format('d F Y') }}
                                                            </td>
                                                            <td><a href="{{ route('file.download', $file->id) }}"
                                                                    class="btn btn-success btn-sm">Download</a></td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5" class="text-center">Tidak ada file untuk dokumen
                                                            ini</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        @endforeach
                                    </table>
                                @else
                                    <div class="alert alert-info text-center">
                                        <h5>Tidak ada dokumen tersedia</h5>
                                        <p>Data ini belum memiliki dokumen yang terkait.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cek apakah ada dokumen
            @if ($data->document && $data->document->count() > 0 && $data->document->first())
                const documentSelect = document.getElementById('document-select');
                const selectedDocumentTitle = document.getElementById('selectedDocumentTitle');
                const searchButton = document.getElementById('search-button');

                const firstDocumentId = '{{ $data->document->first()->id }}';

                // Show the first document section by default
                if (document.getElementById('document-' + firstDocumentId)) {
                    document.getElementById('document-' + firstDocumentId).style.display = 'table-row-group';
                }

                // Handle search button click event
                if (searchButton) {
                    searchButton.addEventListener('click', function() {
                        const selectedValue = documentSelect.value;

                        if (selectedValue) {
                            // Hide all document sections
                            document.querySelectorAll('.document-section').forEach(section => {
                                section.style.display = 'none';
                            });

                            // Show the selected document section
                            const targetSection = document.getElementById(selectedValue);
                            if (targetSection) {
                                targetSection.style.display = 'table-row-group';
                            }

                            // Update the selected document title
                            const selectedOption = document.querySelector(
                                `#document-select option[value="${selectedValue}"]`);
                            if (selectedOption && selectedDocumentTitle) {
                                selectedDocumentTitle.textContent = selectedOption.textContent;
                            }
                        }
                    });
                }

                // Initialize Select2 with search functionality and placeholder
                if (documentSelect) {
                    $('#document-select').select2({
                        placeholder: "Ketik untuk mencari dokumen...", // Placeholder text
                        allowClear: true, // Allows clear functionality
                        width: '100%', // Ensures it takes full width
                        minimumResultsForSearch: 0 // Always show search box
                    });
                }
            @endif
        });
    </script>
@endsection
