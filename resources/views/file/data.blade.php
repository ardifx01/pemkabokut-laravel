@extends('layout')

@section('title', 'Data Files')

@section('content')
    <section style="padding-top: 150px;">
        <div class="card bg-white p-4 shadow rounded-4 border-0">
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <h4>Data Files</h4>
                </div>
                <div>
                    <a href="/file/create" class="btn btn-primary">Add new Files</a>
                </div>
            </div>

            {{-- Pesan Sukses di Simpan dan di Update --}}
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Informasi</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            {{-- Pesan Sukses di Simpan dan di Update --}}

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Path</th>
                            <th>Date</th>
                            <th>Data</th>
                            <th>Document</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $file)
                            <tr>
                                <td>{{ $file->id }}</td>
                                <td>{{ $file->title }}</td>
                                <td>{{ $file->file_path }}</td>
                                <td>{{ $file->file_date }}</td>
                                <td>{{ $file->data->title ?? 'No Data' }}</td>
                                <td>{{ $file->document->title ?? 'No Document' }}</td>

                                <td>
                                    <a href="/file/show/{{ $file->id }}" class="btn btn-success">Show</a>
                                    <a href="/file/edit/{{ $file->id }}" class="btn btn-info">Edit</a>
                                    <form action="{{ route('file.destroy', $file->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this file?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection
