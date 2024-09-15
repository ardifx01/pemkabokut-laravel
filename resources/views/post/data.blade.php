@extends('layout')

@section('title', 'Data Posts')

@section('content')
    <section style="padding-top: 150px;" >
        <div class="card bg-white p-4 shadow rounded-4 border-0">
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <h4>Data Posts</h4>
                </div>
                <div>
                    <a href="/post/create" class="btn btn-primary">Add new Post</a>
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
                            <th>Category</th>
                            <th>Headline</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->category->title ?? 'No Category' }}</td>
                                <td>{{ $post->headline->title ?? 'No Headline' }}</td>
                                <td>
                                    @if ($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" height="100">
                                    @else
                                        <p>No Image</p>
                                    @endif
                                </td>
                                <td>
                                    <a href="/post/show/{{ $post->id }}" class="btn btn-success">Show</a>
                                    <a href="/post/edit/{{ $post->id }}" class="btn btn-info">Edit</a>
                                    <form action="{{ route('post.destroy', $post->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?')">
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
