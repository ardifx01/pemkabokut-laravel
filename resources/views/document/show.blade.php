@extends('layout')

@section('title', 'Dokumen Publik')

@push('styles')
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('images/backgroundb.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 400px;
            display: flex;
            align-items: center;
            position: relative;
            margin-left: calc(-50vw + 50%);
            margin-right: calc(-50vw + 50%);
            width: 100vw;
        }

        .hero-content {
            color: white;
            text-align: left;
        }

        .hero-section .container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 1rem;
        }

        .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: white;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .content-section {
            padding: 4rem 0;
            background-color: #f8f9fa;
        }

        .section-title {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 2rem;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .table-container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #dee2e6;
        }

        .download-btn {
            background-color: #28a745;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background-color 0.3s;
        }

        .download-btn:hover {
            background-color: #218838;
            color: white;
            text-decoration: none;
        }

        .table-responsive {
            border-radius: 8px;
        }

        .no-data {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Daftar Dokumen Publik
                        </li>
                    </ol>
                </nav>
                <h1 class="hero-title">{{ $document->title ?? 'Dokumen Perencanaan' }}</h1>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <div class="table-container">
                @if ($document && $document->file->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No.</th>
                                    <th style="width: 10%">Tahun</th>
                                    <th style="width: 55%">Judul</th>
                                    <th style="width: 15%">Tanggal Upload</th>
                                    <th style="width: 15%" class="text-center">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($document->file as $index => $file)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($file->file_date)->format('Y') }}</td>
                                        <td>{{ $file->title ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($file->created_at)->format('d M Y') }}</td>
                                        <td class="text-center">
                                            @if (is_array($file->file_path) && count($file->file_path) > 0)
                                                @foreach ($file->file_path as $path)
                                                    <a href="{{ route('file.download', $file->id) }}"
                                                        class="download-btn mb-1">
                                                        <i class="bi bi-download"></i>
                                                        Download
                                                    </a>
                                                    @if (!$loop->last)
                                                        <br>
                                                    @endif
                                                @endforeach
                                            @elseif($file->file_path)
                                                <a href="{{ route('file.download', $file->id) }}" class="download-btn">
                                                    <i class="bi bi-download"></i>
                                                    Download
                                                </a>
                                            @else
                                                <span class="text-muted">No file available</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="no-data">
                        <i class="bi bi-file-earmark-text" style="font-size: 3rem; color: #dee2e6;"></i>
                        <h4 class="mt-3">Tidak ada dokumen tersedia</h4>
                        <p>Belum ada dokumen yang diunggah untuk kategori ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
