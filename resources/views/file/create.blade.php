@extends('layout')

@section('content')
    <section style="padding-top: 100px;">
        <div class="container p-5">
            <div class="text-center">
                <h1>Create New File</h1>
            </div>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('file.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                </div>
            
                <div class="mb-3">
                    <label for="file_path" class="form-label">Files</label>
                    <input type="file" class="form-control" id="file_path" name="file_path[]" multiple required>
                </div>
            
                <div class="mb-3">
                    <label for="file_date" class="form-label">File Date</label>
                    <input type="date" class="form-control" id="file_date" name="file_date" value="{{ old('file_date') }}" required>
                </div>
            
                <div class="mb-3">
                    <label for="document_id" class="form-label">Document</label>
                    <select class="form-control" id="document_id" name="document_id">
                        <option value="">Select a Document</option>
                        @foreach ($documents as $document)
                            <option value="{{ $document->id }}">{{ $document->title }}</option>
                        @endforeach
                    </select>
                </div>
            
                <div class="mb-3">
                    <label for="data_id" class="form-label">Data</label>
                    <select class="form-control" id="data_id" name="data_id">
                        <option value="">Select Data</option>
                        @foreach ($data as $dataItem)
                            <option value="{{ $dataItem->id }}">{{ $dataItem->title }}</option>
                        @endforeach
                    </select>
                </div>
            
                <button type="submit" class="btn btn-primary">Create Files</button>
            </form>            
        </div>
    </section>

@endsection
