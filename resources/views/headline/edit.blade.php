@extends('layout')

@section('title', 'Edit Headline')

@section('content')
    <div class="card bg-white p-4 shadow rounded-4 border-0">
        <h4>Edit Headline</h4>

        <form action="{{ route('headline.update', $headline->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $headline->title) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Headline</button>
        </form>
    </div>
@endsection
