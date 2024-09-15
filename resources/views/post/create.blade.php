<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Post</title>
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

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('{{ asset('images/OKU Timur.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #495057;
            position: relative;
        }

        /* Overlay */
        body::before {
            content: '';
            position: absolute;
            top: -10%;
            left: 0;
            width: 100%;
            height: 110%;
            background: radial-gradient(110% 300% at 2% 0%, rgba(0, 39, 106, 0.999) 5%, rgba(0, 0, 0, 0.387) 62%);
            
        }

        .container {
            background-color: rgb(255, 255, 255);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            position: relative;
        }

        .form-control,
        .select2-container--default .select2-selection--single {
            height: 44px;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
            top: 50%;
            transform: translateY(-50%);
        }

        .note-editor {
            border-radius: 4px;
        }

        #image-preview img {
            max-width: 100%;
            border-radius: 8px;
            margin-top: 15px;
        }

        .col-centered {
            margin-left: 94px;
            margin-right: auto;
        }

        .note-dialog {
            z-index: 1060 !important;
        }

        .note-modal {
            z-index: 1060 !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-10 col-centered">
                <div class="text-center mb-5">
                    <h1>Create a New Post</h1>
                </div>
                <form action="/post" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter the title">
                    </div>

                    <div class="form-group mb-4">
                        <label for="category_id">Category:</label>
                        <select name="category_id" class="form-control" id="category-select">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="headline_id">Headline:</label>
                        <select name="headline_id" class="form-control" id="headline-select">
                            <option value="">-- Select Headline --</option>
                            @foreach ($headlines as $headline)
                                <option value="{{ $headline->id }}">{{ $headline->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="image">Image:</label>
                        <input type="file" class="form-control" name="image" id="image-upload">
                        <div id="image-preview" class="mt-3"></div>
                    </div>

                    <label for="description">Description:</label>
                    <textarea name="description" id="description" cols="30" rows="10"></textarea>


                    <div class="form-group mb-4">
                        <label for="published_at">Tanggal publish:</label>
                        <input type="datetime-local" class="form-control" name="published_at" id="published_at">
                    </div>

                    <button type="submit" class="btn btn-lg btn-primary btn-block">Submit</button>
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
                    $('#image-preview').html('<img src="' + e.target.result +
                        '" class="img-fluid rounded-3" alt="Uploaded Image" width="300">');
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
</body>

</html>
