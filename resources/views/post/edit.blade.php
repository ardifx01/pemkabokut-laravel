<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Post - Laravel 10 Summernote Text Editor with Image Upload CRUD</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body>
    <div class="container col-xxl-8 py-5 ">
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="text-center">
                    <h1>Edit Post</h1>
                </div>
                <form action="/update/{{ $post->id }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" name="title" value="{{ $post->title }}">
                    
                    <label for="category_id">Category:</label>
                    <select name="category_id" class="form-control" id="category-select">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                    
                    <label for="headline_id">Headline:</label>
                    <select name="headline_id" class="form-control" id="headline-select">
                        <option value="">-- Select Headline --</option>
                        @foreach ($headlines as $headline)
                            <option value="{{ $headline->id }}"
                                {{ $post->headline_id == $headline->id ? 'selected' : '' }}>
                                {{ $headline->title }}
                            </option>
                        @endforeach
                    </select>
                    
                    <label for="image">Image:</label>
                    <div id="image-preview" class="mt-3">
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded-3" alt="Uploaded Image" width="300">
                        @endif
                    </div>
                    <input type="file" class="form-control" name="image" id="image-upload">
                    
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" cols="30" rows="10">{{ $post->description }}</textarea>
                    <label for="published_at">Tanggal publish:</label>
                    <input type="datetime-local" class="form-control" name="published_at" id="published_at">
                    <button type="submit" class="btn btn-lg btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize Summernote
            $('#description').summernote({
                placeholder: 'description...',
                tabsize: 2,
                height: 300
            });

            // Initialize Select2 for the category select
            $('#category-select').select2({
                placeholder: "-- Select Category --",
                allowClear: true
            });

            // Initialize Select2 for the headline select
            $('#headline-select').select2({
                placeholder: "-- Select Headline --",
                allowClear: true
            });

            // Image preview function
            $('#image-upload').change(function() {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview').html('<img src="' + e.target.result + '" class="img-fluid rounded-3" alt="Uploaded Image" width="300">');
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
</body>

</html>
