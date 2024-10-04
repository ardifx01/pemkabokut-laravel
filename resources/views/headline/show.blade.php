@extends('layout')

@section('content')
    {{-- Section Headline Posts --}}
    <section id="headline-posts-section" class="py-4">
        <div class="container">
            <h2 class="mb-4 text-center">Berita dengan Headline</h2>
            {{-- Grid for posts --}}
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                @php
                                    // Ambil gambar pertama dari JSON
                                    $images = json_decode($post->image);
                                    $firstImage = $images ? $images[0] : null;
                                @endphp

                                @if ($firstImage)
                                    {{-- Cek jika gambar berupa link eksternal --}}
                                    @if (Str::startsWith($firstImage, ['http://', 'https://']))
                                        <img src="{{ $firstImage }}" class="img-fluid mb-3" alt="Gambar Post"
                                            style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;">
                                    @else
                                        {{-- Jika gambar dari folder storage --}}
                                        <img src="{{ asset('storage/' . $firstImage) }}" class="img-fluid mb-3"
                                            alt="Gambar Post"
                                            style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;">
                                    @endif
                                @else
                                    {{-- Placeholder jika tidak ada gambar --}}
                                    <img src="{{ asset('images/placeholder.png') }}" class="img-fluid mb-3"
                                        alt="Placeholder Image"
                                        style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;">
                                @endif

                                <h5 class="card-title">{{ Str::limit($post->title, 50) }}</h5>
                                <p class="text-muted mb-2">
                                    <i class="bi bi-calendar"></i> {{ $post->published_at->format('d M Y') }}
                                    &nbsp;&nbsp;<i class="bi bi-person"></i> Admin
                                    &nbsp;&nbsp;<i class="bi bi-eye"></i> {{ $post->views }}
                                </p>
                                <p class="card-text">{{ Str::limit(strip_tags($post->description), 100, '...') }}</p>
                                <a href="/post/show/{{ $post->id }}" class="btn btn-primary">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $posts->links() }}
            </div>            
            {{-- Tampilkan pesan jika tidak ada post yang memiliki headline --}}
            @if ($posts->isEmpty())
                <div class="alert alert-warning text-center">
                    Tidak ada berita dengan headline saat ini.
                </div>
            @endif
        </div>
    </section>
@endsection
