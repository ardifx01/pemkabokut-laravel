<!-- resources/views/icons/create.blade.php -->

@extends('layout')

@section('content')
    <div class="container">
        <h1>Create Icon</h1>
        <form action="{{ route('icon.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Icon Image</label>
                <input type="file" name="image" class="form-control" id="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Icon</button>
        </form>
    </div>
@endsection
