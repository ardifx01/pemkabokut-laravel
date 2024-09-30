@extends('layout')

@section('title', 'Data Icons')

@section('content')
    <div class="card bg-white p-4 shadow rounded-4 border-0" style="margin-top: 100px;">
        <div class="d-flex justify-content-between mb-4">
            <div>
                <h4>Data Icons</h4>
            </div>
            <div>
                <a href="{{ route('icon.create') }}" class="btn btn-primary">Add new Icon</a>
            </div>
        </div>

        {{-- Pesan Sukses di Simpan dan di Update --}}
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Informasi:</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($icons as $icon)
                        <tr>
                            <td>{{ $icon->id }}</td>
                            <td>{{ $icon->title }}</td>
                            <td>
                                <div class="icon-section d-flex flex-column gap-2 justify-content-center align-items-center">
                                    <div class="card bg-opacity-60 text-center">
                                        <div class="card-body">
                                            @php
                                                // Cek apakah gambar merupakan URL eksternal
                                                $isExternalImage = Str::startsWith($icon->image, [
                                                    'http://',
                                                    'https://',
                                                ]);
                                            @endphp

                                            <!-- Jika gambar merupakan URL eksternal -->
                                            @if ($isExternalImage)
                                                <img src="{{ $icon->image }}" alt="{{ $icon->title }}" class="img-fluid"
                                                    style="width: 50px; height: 50px; object-fit: contain;">
                                            @else
                                                <img src="{{ asset('storage/' . $icon->image) }}" alt="{{ $icon->title }}"
                                                    class="img-fluid"
                                                    style="width: 50px; height: 50px; object-fit: contain;">
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $icon->created_at->format('d M Y, H:i') }}</td>
                            <td>{{ $icon->updated_at->format('d M Y, H:i') }}</td>
                            <td>
                                <a href="{{ route('icon.edit', $icon->id) }}" class="btn btn-info">Edit</a>
                                <form action="{{ route('icon.destroy', $icon->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this icon?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
