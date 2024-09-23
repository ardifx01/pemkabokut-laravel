@extends('layout')

@section('content')
    {{-- Background Section with Search Form --}}
    <!-- Search Form Section -->
    <section id="search-section"
        style="background-image: url('{{ asset('images/pemda1.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 755px; margin-top: -80px">
        <!-- Overlay -->
        <div
            style="background: radial-gradient(110% 300% at 2% 0%, rgba(0, 39, 106, 0.999) 5%, rgba(0, 0, 0, 0.200) 62%); position: absolute; top: 0; left: 0; width: 102%; height: 100%;">
        </div>

        <!-- Search Form -->
        <div class="container-fluid d-flex flex-column justify-content-center align-items-center"
            style="height: 173%; position: relative;">
            <form class="d-flex justify-content-center" role="search"
                style="height: 40px; width: 50%; position: relative; margin-bottom: 0px;">
                <input class="form-control" type="search" placeholder="Cari informasi disini...." aria-label="Search"
                    style="background-color: rgba(255, 255, 255, 0.842); color: #6c757d; border: none; border-radius: 10px; box-shadow: none; font-size: 18px; padding: 10px 20px; width: 100%;">
                <button class="btn btn-primary" type="submit"
                    style="position: absolute; right: 5px; top: 5px; bottom: 5px; padding: 0 20px; background-color: #213349; border: none; border-radius: 10px;">Cari</button>
            </form>

            <!-- Icon Section -->
            <div class="icon-section d-flex justify-content-center align-items-center">
                <div class="row">
                    <div class="col text-center">
                        <div class="card">
                            <div class="card-body">
                                <img src="{{ URL::asset('/images/agent.png') }}" alt="Pelayanan Kependudukan"
                                    class="icon-img">
                            </div>
                        </div>
                        <p class="mt-2">Pelayanan Kependudukan</p>
                    </div>
                    <div class="col text-center">
                        <div class="card">
                            <div class="card-body">
                                <img src="{{ URL::asset('/images/public-service.png') }}" alt="Pelayanan Masyarakat"
                                    class="icon-img">
                            </div>
                        </div>
                        <p class="mt-2">Pelayanan Masyarakat</p>
                    </div>
                    <div class="col text-center">
                        <div class="card">
                            <div class="card-body">
                                <img src="{{ URL::asset('/images/taxes.png') }}" alt="Pelayanan Pajak" class="icon-img">
                            </div>
                        </div>
                        <p class="mt-2">Pelayanan Pajak</p>
                    </div>
                    <div class="col text-center">
                        <div class="card">
                            <div class="card-body">
                                <img src="{{ URL::asset('/images/petition.png') }}" alt="Pengaduan Masyarakat"
                                    class="icon-img">
                            </div>
                        </div>
                        <p class="mt-2">Pengaduan Masyarakat</p>
                    </div>
                    <div class="col text-center">
                        <div class="card">
                            <div class="card-body">
                                <img src="{{ URL::asset('/images/calculator.png') }}" alt="Transparansi Anggaran"
                                    class="icon-img">
                            </div>
                        </div>
                        <p class="mt-2">Transparansi Anggaran</p>
                    </div>
                    <div class="col text-center">
                        <div class="card">
                            <div class="card-body">
                                <img src="{{ URL::asset('/images/travel-map.png') }}" alt="Destinasi Wisata"
                                    class="icon-img">
                            </div>
                        </div>
                        <p class="mt-2">Destinasi Wisata</p>
                    </div>
                    <div class="col text-center">
                        <div class="card">
                            <div class="card-body">
                                <img src="{{ URL::asset('/images/legal-document.png') }}" alt="Produk Hukum"
                                    class="icon-img">
                            </div>
                        </div>
                        <p class="mt-2">Produk Hukum</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section Berita dan Pengumuman --}}
    <section id="pengumuman-section" style="background-image: url('images/cover.png')">
        {{-- Main Container for the Section --}}
        <div class="container d-flex justify-content-center" style="padding-top: 40px;">
            {{-- Berita Terkini --}}
            <div class="col-md-8" style="margin-top: -50px; width: 832px;">
                {{-- Judul "Berita Terkini" --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="text-dark" style="font-weight: 600; font-size: 22px; margin-top: 40px;">Berita Terkini
                    </h2>
                    {{-- Nav untuk carousel --}}
                    <div class="d-flex" style="margin-top: 30px;">
                        <button class="owl-prev btn btn-light" style="border: 1px solid #ccc; border-radius: 4px;">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button class="owl-next btn btn-light ms-2" style="border: 1px solid #ccc; border-radius: 4px;">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>

                {{-- Garis Bawah untuk Judul --}}
                <div class="mb-2 d-flex align-items-center" style="margin-top: -11px">
                    <div style="width: 50px; height: 6px; background-color: #2F4F7F;"></div>
                    <div style="flex-grow: 1; height: 2px; background-color: #2F4F7F;"></div>
                </div>

                {{-- Container Pengumuman with Owl Carousel --}}
                <div class="container py-4" style="margin-top: -20px; margin-left: -12px; width: 104%;">
                    <div id="latestArticle" class="owl-carousel owl-theme">
                        @foreach ($posts as $post)
                            <div class="item">
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="row g-0">
                                        <div class="col-md-4" style="width: 55%; ">
                                            {{-- Gambar untuk Post --}}
                                            @if (Str::startsWith($post->image, ['http://', 'https://']))
                                                <img src="{{ $post->image }}" class="img-fluid" alt="Gambar Post"
                                                    style="width: 90%; height: 250px; object-fit: cover; border-radius: 5px;">
                                            @else
                                                <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid"
                                                    alt="Gambar Post"
                                                    style="width: 100%; height: 250px; object-fit: cover; border-radius: 5px;">
                                            @endif
                                        </div>
                                        <div class="col-md-8" style="width: 40%; margin-left: -40px; margin-top: -15px;">
                                            <div class="card-body" style="width: 420px">
                                                <h5 class="card-title title-clamp">{{ $post->title }}</h5>
                                                <div
                                                    class="d-flex justify-content-start align-items-center text-muted mb-2">
                                                    <span class="me-3"><i class="bi bi-calendar"></i>
                                                        @if ($post->published_at)
                                                            {{ $post->published_at->format('d M Y') }}
                                                        @else
                                                            Tanggal tidak tersedia
                                                        @endif
                                                    </span>
                                                    <small><i class="bi bi-person"></i> Admin &nbsp; <i class="bi bi-eye"></i> {{ $post->views }}</small>
                                                </div>
                                                {{-- Deskripsi dengan Batasan 4 Baris --}}
                                                <p class="card-text description-clamp">
                                                    {{ Str::limit(html_entity_decode(strip_tags($post->description)), 200, '...') }}
                                                </p>
                                                <a href="/post/show/{{ $post->id }}"
                                                    class="btn btn-link text-primary p-0">Selengkapnya <i
                                                        class="bi bi-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            

            {{-- Pengumuman --}}
            <div class="col-md-4" style="width: 27%;">
                <h5 class="mb-3" style="font-weight: 600; font-size: 22px; margin-top: -13px;">Pengumuman</h5>
                {{-- Garis Bawah untuk Judul --}}
                <div class="mb-2 d-flex align-items-center" style="margin-top: 2px">
                    <div style="width: 50px; height: 6px; background-color: #2F4F7F;"></div>
                    <div style="flex-grow: 1; height: 2px; background-color: #2F4F7F;"></div>
                </div>
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1">MEMPERINGATI HARI PENDIDIKAN NASIONAL</h6>
                            <small><i class="bi bi-calendar"></i> 2 Mei 2020</small>
                        </div>
                        <small><i class="bi bi-person"></i> Admin &nbsp; <i class="bi bi-eye"></i> 40.784</small>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1">Pelayanan PBB Bandung Barat</h6>
                            <small><i class="bi bi-calendar"></i> 4 Oktober 2021</small>
                        </div>
                        <small><i class="bi bi-person"></i> Admin &nbsp; <i class="bi bi-eye"></i> 36.438</small>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1">KPU Kabupaten Bandung Barat Umumkan Daftar Calon Sementara...</h6>
                            <small><i class="bi bi-calendar"></i> 23 Agustus 2023</small>
                        </div>
                        <small><i class="bi bi-person"></i> Admin &nbsp; <i class="bi bi-eye"></i> 17.092</small>
                    </a>
                </div>
            </div>
        </div>
    </section>

    

    {{-- Headline --}}
    <section id="headline" class="py-4">
        <div class="container">
            <h2 class="mb-4" style="font-family: 'Roboto', serif; font-size: 23px;">Berita Lainnya</h2>
            {{-- Garis Bawah untuk Judul --}}
            <div class="mb-2 d-flex align-items-center" style="margin-top: -15px">
                <div style="width: 50px; height: 6px; background-color: #2F4F7F;"></div>
                <div style="flex-grow: 1; height: 2px; background-color: #2F4F7F;"></div>
            </div>
            <div class="row" style="margin-top: 20px">
                @foreach ($posts->whereNotNull('headline_id')->sortByDesc('id')->take(6) as $post)
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <a href="/post/show/{{ $post->id }}" class="text-decoration-none">
                            <div class="card border-0 shadow-sm">
                                @if (Str::startsWith($post->image, ['http://', 'https://']))
                                    <img src="{{ $post->image }}" class="img-fluid"
                                        style="height: 270px;   object-fit: cover; border-radius: 10px;"
                                        alt="{{ $post->title }}">
                                @else
                                    <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid"
                                        style="height: 300px; object-fit: cover; border-radius: 10px;"
                                        alt="{{ $post->title }}">
                                @endif
                                <div class="card-body p-3"
                                    style="position: absolute; bottom: 0; left: 0; right: 0; background-color: rgba(0, 0, 0, 0.7); border-radius: 0 0 10px 10px;">
                                    <h5 class="card-title text-white" style="font-size: 16px;">{{ $post->title }}</h5>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-white-50" style="font-size: 12px;">
                                            <i class="bi bi-calendar"></i>
                                            @if ($post->published_at)
                                                Published on {{ $post->published_at->format('d M Y') }}
                                            @endif
                                        </span>
                                        <span class="text-white-50" style="font-size: 12px;">
                                            <i class="bi bi-person"></i> Admin
                                        </span>
                                        <span class="text-white-50" style="font-size: 12px;">
                                            <i class="bi bi-eye"></i> {{ $post->views }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-end">
                <a href="/headlines" class="btn btn-outline-primary">
                    Selengkapnya <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>
    {{-- Headline --}}

    <!-- jQuery (required for Owl Carousel) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Owl Carousel
            var owl = $('#latestArticle').owlCarousel({
                loop: true,
                margin: 10,
                nav: false, // Disable default nav
                autoplay: true, // Enable autoplay
                autoplayTimeout: 3000, // Set autoplay speed (in milliseconds)
                autoplayHoverPause: true, // Pause on hover
                responsive: {
                    0: {
                        items: 1 // Display 1 item at a time
                    },
                    600: {
                        items: 1 // Display 1 item at a time
                    },
                    1000: {
                        items: 1 // Display 1 item at a time
                    }
                }
            });

            // Custom Navigation Events
            $('.owl-next').click(function() {
                owl.trigger('next.owl.carousel');
            });
            $('.owl-prev').click(function() {
                owl.trigger('prev.owl.carousel');
            });
        });
    </script>
@endsection
