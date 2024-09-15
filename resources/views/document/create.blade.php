@extends('layout')

@section('content')
<section style="padding-top: 150px;">
    <div class="container p-4">
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="text-center">
                    <h1>Create a New Documents</h1>
                </div>
                <form action="{{ route('document.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                        @if ($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <label for="data_id">Data:</label> <!-- Dropdown untuk data -->
                        <select name="data_id" class="form-control" id="data-select">
                            <option value="">-- Select Data --</option> <!-- Opsi kosong -->
                            @foreach ($data as $dataItem)
                                <option value="{{ $dataItem->id }}">{{ $dataItem->title }}</option>
                            @endforeach
                        </select>
                    <button type="submit" class="btn btn-lg btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
