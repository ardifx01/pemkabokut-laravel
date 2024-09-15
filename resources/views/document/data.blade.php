@extends('layout')

@section('title', 'Data Documents')

@section('content')
    <section style="padding-top: 150px;">
        <div class="card bg-white p-4 shadow rounded-4 border-0">
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <h4>Data Documents</h4>
                </div>
                <div>
                    <a href="/document/create" class="btn btn-primary">Add new Document</a>
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
                            <th>Data</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documents as $document)
                            <tr>
                                <td>{{ $document->id }}</td>
                                <td>{{ $document->title }}</td>
                                <td>{{ $document->data->title ?? 'No Data' }}</td>

                                <td>
                                    <a href="/data/show/{{ $document->id }}" class="btn btn-success">Show</a>
                                    <a href="/data/edit/{{ $document->id }}" class="btn btn-info">Edit</a>
                                    <form action="{{ route('document.destroy', $document->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this document?')">
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
    </section>
@endsection
