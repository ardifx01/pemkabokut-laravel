@extends('layout')

@section('content')
    {{-- Detail Post --}}
    <section id="detail" style="padding-top: 100px; width: 100vw; margin-left: calc(-50vw + 50%);">
        <div class="container-fluid col-xxl-12 py-3" id="main-container">
            {{-- Menggunakan Row untuk mengatur layout --}}
            <div class="row justify-content-between">
                {{-- bagian untuk Post Utama --}}
                <div class="col-lg-8 col-md-12 col-sm-12 col-12 post-section" style="width: 1020px">
                    <div class="post-content bg-white text-left border shadow-sm p-4 mb-4">
                        <p class="mb-4">
                            <a href="/" class="text-decoration-none text-dark">Beranda</a> /
                            @if ($post->category)
                                <a href="/category/{{ $post->category->id }}"
                                    class="text-decoration-none text-dark">{{ $post->category->title }}</a> /
                            @endif
                            @if ($post->headline)
                                <a href="/headline/{{ $post->headline->id }}"
                                    class="text-decoration-none text-dark">{{ $post->headline->title }}</a> /
                            @endif
                            {{ $post->title }}
                        </p>

                        <h3 class="fw-bold mb-3">{{ $post->title }}</h3>
                        <p class="mb-3">
                            @if ($post->published_at)
                                Published on {{ $post->published_at->format('d M Y, H:i') }} WIB
                            @else
                                Tanggal tidak tersedia
                            @endif
                        </p>

                        {{-- Gambar Postingan --}}
                        @if ($post->image)
                            @php
                                $images = json_decode($post->image); // Mengambil array gambar dari post
                                $count = count($images); // Menghitung jumlah gambar
                                $chunks = array_chunk($images, 3); // Membagi gambar ke dalam grup 3 (atau kurang)
                            @endphp
                            <div class="image-gallery mb-4">
                                @foreach ($chunks as $chunk)
                                    <div class="row">
                                        @foreach ($chunk as $index => $image)
                                            {{-- Aturan untuk menampilkan gambar sesuai jumlah gambar dalam row --}}
                                            @if (count($chunk) == 1)
                                                {{-- Jika hanya ada 1 gambar --}}
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                @elseif (count($chunk) == 2)
                                                    {{-- Jika ada 2 gambar --}}
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                    @else
                                                        {{-- Jika ada 3 gambar --}}
                                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            @endif
                                            <!-- Set kolom tanpa margin dan padding -->
                                            <div
                                                class="post-image-container {{ count($chunk) == 1 ? 'one-image' : (count($chunk) == 2 ? 'two-images' : 'three-images') }}">

                                                @php
                                                    // Cek apakah gambar adalah URL eksternal
                                                    $isExternalImage = Str::startsWith($image, ['http://', 'https://']);
                                                @endphp

                                                <a href="{{ $isExternalImage ? $image : asset('storage/' . $image) }}"
                                                    target="_blank">
                                                    <img src="{{ $isExternalImage ? $image : asset('storage/' . $image) }}"
                                                        alt="Image"
                                                        class="img-fluid post-image {{ count($chunk) == 1 ? 'one-image' : (count($chunk) == 2 ? 'two-images' : 'three-images') }}">
                                                </a>
                                            </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    @endif


                    {{-- Konten Deskripsi --}}
                    <div class="description mt-4" style="overflow: hidden; text-align: justify;">
                        {!! $post->description !!}
                    </div>
                </div>
            </div>

            {{-- bagian untuk Berita Lainnya --}}
            <div class="col-lg-4 col-md-12 col-sm-12 col-12 related-news-section mt-4 mt-lg-0" style="width: 405px;">
                <div class="related-news bg-white border shadow-sm p-3" style="border-radius: 10px;">
                    <div class="header bg-primary text-white p-2" style="border-radius: 10px; margin-bottom: 20px">
                        Berita Lainnya
                    </div>
                    <div class="body">
                        @foreach (\App\Models\Post::where('id', '!=', $post->id)->whereNotNull('headline_id')->orderBy('id', 'desc')->take(5)->get() as $otherPost)
                            <a href="/post/show/{{ $otherPost->id }}" class="text-decoration-none">
                                <div class="d-flex mb-3">
                                    @php
                                        $images = json_decode($otherPost->image); // Dekode JSON untuk mendapatkan array gambar
                                        $firstImage = $images ? $images[0] : null; // Ambil gambar pertama
                                    @endphp

                                    {{-- Cek apakah gambar merupakan URL eksternal --}}
                                    @if ($firstImage && Str::startsWith($firstImage, ['http://', 'https://']))
                                        <img src="{{ $firstImage }}" alt="{{ $otherPost->title }}"
                                            class="related-news-image thumbnail-blur">
                                    @else
                                        <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $otherPost->title }}"
                                            class="related-news-image thumbnail-blur">
                                    @endif

                                    <div class="ms-3">
                                        <h6 class="text-dark post-title">{{ $otherPost->title }}</h6>
                                        <p class="text-muted" style="font-size: 12px;">
                                            {{ $otherPost->published_at ? $otherPost->published_at->format('d M Y') : 'Tanggal tidak tersedia' }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
        </div>
    </section>
    <style>
        .post-content {
            width: 107%;
            border-radius: 10px;
            margin-left: 25px;
        }

        .related-news {
            width: 100%;
            margin-left: 0px;
            /* Lebar Berita Lainnya disesuaikan dengan kolom */
        }

        .related-news img {
            width: 130px;
            /* Set width to 130px */
            height: 80px;
            /* Set height to 80px */
            object-fit: cover;
            /* Ensure the image fits within the 130x80 container */
            object-position: center;
            border-radius: 5px;
            background-color: #d1d3e2;
            min-width: 130px;
            /* Force the minimum width to be 130px */
        }


        .thumbnail-blur {
            filter: blur(0.2px);
            /* Sesuaikan nilai blur sesuai kebutuhan */
            transition: filter 0.3s ease-in-out;
        }

        .thumbnail-blur:hover {
            filter: none;
            /* Blur hilang saat di-hover, untuk efek visual yang menarik */
        }

        .description img {
            max-width: 100%;
            height: auto;
            margin-bottom: -59px;
            padding-bottom: 35px;
        }

        .description p {
            margin-bottom: 15px;
        }

        /* Styling untuk membatasi judul menjadi dua baris dengan ellipsis */
        .post-title {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2em;
            max-height: 2.4em;
            font-size: 14px;
        }

        /* Kolom gambar dan container */
        .image-gallery .col-lg-4,
        .image-gallery .col-md-6,
        .image-gallery .col-sm-12 {
            padding: 3px !important;
            margin: 0 !important;
        }

        .post-image-container.one-image {
            max-width: 1015px;
            max-height: 678px;
            width: auto;
            height: auto;
            overflow: hidden;
            position: relative;
            margin-bottom: 0 !important;
        }

        .post-image.one-image {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .two-images {
            height: 336px !important;
            width: 504px !important;
        }

        .three-images img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            filter: blur(0.4px);
            transition: filter 0.3s ease-in-out;
        }

        .three-images img:hover {
            filter: none;
            /* Hilangkan blur saat gambar di-hover */
        }

        .three-images {
            height: 222px !important;
            width: 333px !important;
            overflow: hidden;
        }

        .post-image.three-images {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            filter: blur(0.4px);
            /* Tambahkan efek blur ringan */
            transition: filter 0.3s ease-in-out;
        }

        .post-image.three-images:hover {
            filter: none;
            /* Hilangkan blur saat gambar di-hover */
        }

        .row {
            margin-left: 0 !important;
            margin-right: 0px !important;
        }

        /* ======= Responsive Layout for Mobile Devices ======= */
        @media (max-width: 768px) {
            #detail {
                padding-top: 50px;
            }

            .post-section {
                width: 100% !important;
                padding: 0 15px;
                /* Add padding to ensure content isn't too close to the screen edge */
            }

            .related-news-section {
                width: 100% !important;
                margin-top: 20px;
                /* Ensure spacing between the main post and related news */
            }

            .related-news .post-title {
                font-size: 14px;
                line-height: 1.4;
                -webkit-line-clamp: 3;
                /* Allow up to 3 lines before truncating */
                max-height: 4.2em;
                /* Set max height for 3 lines */
                display: -webkit-box;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: normal;
            }

            /* Adjusting the image gallery for mobile */
            .image-gallery .col-lg-4,
            .image-gallery .col-md-6,
            .image-gallery .col-sm-12 {
                padding: 5px !important;
                /* Slight padding to keep images spaced */
                width: 100% !important;
                /* Full width for images on mobile */
            }

            /* Adjust post content for mobile */
            .post-content {
                width: 100% !important;
                margin-left: 0 !important;
                padding: 10px;
            }

            /* Adjust the size of the post images */
            .post-image-container {
                width: 100% !important;
                height: auto !important;
            }

            /* Adjust the related news images for mobile */
            .related-news img {
                width: 100px;
                height: 70px;
            }

            .related-news {
                margin-left: 0 !important;
                padding: 15px;
            }

            /* Adjust the text size and layout for mobile */
            .post-title {
                font-size: 16px;
                line-height: 1.5;
            }

            .description p {
                font-size: 14px;
                line-height: 1.6;
            }

            /* Remove unnecessary padding and margins */
            .row {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .post-image {
                max-width: 100%;
                height: auto;
                object-fit: cover;
            }
        }

    </style>
@endsection
