@extends('layout')

@section('content')
    {{-- Detail Post --}}
    <section id="detail" style="padding-top: 120px; width: 100vw; margin-left: calc(-50vw + 50%);">
        <div class="container-fluid col-xxl-12 py-3" id="main-container">
            {{-- Menggunakan Row untuk mengatur layout --}}
            <div class="row justify-content-between">
                {{-- Section untuk Post Utama --}}
                <div class="col-lg-8 col-md-12 col-sm-12 col-12 post-section">
                    <div class="post-content bg-white text-left border shadow-sm p-4 mb-4" style="border-radius: 10px;">
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

                        {{-- Konten Deskripsi --}}
                        <div class="description mt-4" style="overflow: hidden; text-align: justify;">
                            {!! $post->description !!}
                        </div>
                    </div>
                </div>

                {{-- Section untuk Berita Lainnya --}}
                <div class="col-lg-4 col-md-12 col-sm-12 col-12 related-news-section mt-4 mt-lg-0">
                    <div class="related-news bg-white border shadow-sm p-3" style="border-radius: 10px;">
                        <div class="header bg-primary text-white p-2" style="border-radius: 10px; margin-bottom: 20px">
                            Berita Lainnya
                        </div>
                        <div class="body">
                            @foreach (\App\Models\Post::where('id', '!=', $post->id)->whereNotNull('headline_id')->orderBy('id', 'desc')->take(5)->get() as $otherPost)
                                <a href="/post/show/{{ $otherPost->id }}" class="text-decoration-none">
                                    <div class="d-flex mb-3">
                                        {{-- Cek apakah gambar merupakan URL eksternal --}}
                                        @if (Str::startsWith($otherPost->image, ['http://', 'https://']))
                                            <img src="{{ $otherPost->image }}" alt="{{ $otherPost->title }}" 
                                                style="height: 80px; object-fit: cover; border-radius: 5px; width: 80px;">
                                        @else
                                            <img src="{{ asset('storage/' . $otherPost->image) }}" alt="{{ $otherPost->title }}"
                                                style="height: 80px; object-fit: cover; border-radius: 5px; width: 80px;">
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
            width: 100%;
            /* Lebar post content disesuaikan dengan kolom */
        }

        .related-news {
            width: 100%;
            /* Lebar Berita Lainnya disesuaikan dengan kolom */
        }

        .description img {
            max-width: 100%;
            /* Membuat gambar tidak melebihi lebar kontainer */
            height: auto;
            /* Menjaga rasio gambar */
            margin-bottom: -59px;
            padding-bottom: 35px;
            /* Menambahkan jarak antar gambar */
        }

        .description p {
            margin-bottom: 15px;
        }

        /* Styling untuk membatasi judul menjadi dua baris dengan ellipsis */
        .post-title {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Menampilkan maksimum 2 baris */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2em;
            /* Menyelaraskan tinggi baris */
            max-height: 2.4em;
            /* Dua baris dengan tinggi 1.2em per baris */
            font-size: 14px;
            /* Sesuaikan ukuran font agar pas dengan dua baris */
        }

        @media (max-width: 768px) {
            #main-container {
                padding-left: 0px;
                padding-right: 0px;
                /* Mengurangi padding pada ponsel */
            }

            .post-content,
            .related-news {
                padding: 10px;
                /* Mengurangi padding pada konten di layar kecil */
            }
        }

        @media (min-width: 768px) {
            #main-container {
                padding-left: 120px;
                padding-right: 120px;
                /* Menjaga padding 120px di layar desktop */
            }
        }
    </style>
@endsection
