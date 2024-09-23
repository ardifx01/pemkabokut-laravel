@extends('layout')

@section('content')
    {{-- Detail Post --}}
    <section id="detail" style="padding-top: 120px;">
        <div class="container-fluid col-xxl-12 py-3">
            {{-- Menggunakan Flexbox untuk mengatur layout --}}
            <div class="d-flex justify-content-between">
                {{-- Section untuk Post Utama --}}
                <section class="post-section" style="flex-grow: 1; margin-left: -200px">
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
                </section>

                {{-- Section untuk Berita Lainnya --}}
                <section class="related-news-section">
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
                </section>
            </div>
        </div>
    </section>
    <style>
        .post-content {
            width: 900px;
            /* Lebar post content menjadi 75% dari parent container */
        }

        .related-news {
            width: 173%;
            /* Lebar Berita Lainnya menjadi 23% dari parent container */
            margin-left: 2%;
            /* Menambahkan margin antara Post Utama dan Berita Lainnya */
        }

        .description img {
            max-width: 100%;
            /* Membuat gambar tidak melebihi lebar kontainer */
            height: auto;
            /* Menjaga rasio gambar */
            margin-bottom: -59px;
            padding-bottom: 35px
            /* Menambahkan jarak antar gambar */
        }
        .description p {
            margin-bottom: 15px;
        }

        .related-news-section {
            width: 300px;
            /* Berita Lainnya dengan lebar tetap 300px */
            margin-left: 20px;
            /* Memberikan sedikit margin antara Post Utama dan Berita Lainnya */
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
    </style>
@endsection
