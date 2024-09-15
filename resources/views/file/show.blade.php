@extends('layout')

@section('content')
    {{-- Detail File --}}
    <section id="detail" style="padding-top: 120px;">
        <style>
            .container-fluid {
                padding-left: 0;
                padding-right: 0;
            }

            .col-md-15 {
                margin-left: -220px;
                margin-right: 50px;
            }
        </style>
        <div class="container-fluid col-xxl-12 py-3">
            <div class="row">
                <div class="col-md-15">
                    <div class="card bg-white text-left border-0">
                        <p class="mb-4">
                            <a href="/" class="text-decoration-none text-dark">Beranda</a> /
                            @if ($file->document)
                                <a href="/document/{{ $file->document->id }}"
                                    class="text-decoration-none text-dark">{{ $file->document->title }}</a> /
                            @endif
                            @if ($file->data)
                                <a href="/data/{{ $file->data->id }}"
                                    class="text-decoration-none text-dark">{{ $file->data->title }}</a> /
                            @endif
                            {{ $file->title }}
                        </p>

                        <h3 class="fw-bold mb-3">{{ $file->title }}</h3>
                        <p class="mb-3">
                            Uploaded on {{ date('d M Y', strtotime($file->file_date)) }}
                        </p>
                        <div class="mt-4">
                            <p>Nama File: {{ basename($file->file_path) }}</p>
                            <a href="{{ route('file.download', $file->id) }}" class="btn btn-dark">Download</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Detail File --}}
@endsection
