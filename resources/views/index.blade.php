@extends('layout')

@section('content')
    {{-- Background Section with Search Form --}}
    <!-- Search Form Section -->
    <section id="search-section" style="position: relative;">
        <!-- Bootstrap Carousel for Background Images -->
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel"
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; overflow: hidden;">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('images/kantor.jpg') }}" class="d-block w-100"
                        style="height: 100%; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/Perjaya.jpg') }}" class="d-block w-100"
                        style="height: 100%; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/Bendungan-Perjaya.jpg') }}" class="d-block w-100"
                        style="height: 100%; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/sawah.jpg') }}" class="d-block w-100"
                        style="height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>

        <!-- Overlay to darken the background for readability -->
        <div
            style="background: radial-gradient(110% 300% at 2% 0%, #00276aff 5%, rgba(0, 0, 0, 0.200) 62%);
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;">
        </div>

        <!-- Search Form and Icon Section (on top of the carousel) -->
        <div class="container-fluid d-flex flex-column justify-content-center align-items-center"
            style="height: 100%; position: relative; z-index: 2;">
            <!-- Welcome Text -->
            <h1 class="text-white text-center fw-bold text-uppercase mb-3" style="transform: translateY(60px);">
                Selamat Datang<br>Pemerintah Kabupaten OKU TIMUR
            </h1>
            <p class="text-white fs-5 text-center mb-4" style="transform: translateY(60px);">
                Temukan informasi publik terkini dari Kabupaten OKU TIMUR
            </p>

            <!-- Search Form -->
            <form class="search-form d-flex justify-content-between align-items-center" method="GET"
                action="{{ route('post.search') }}">
                <div class="input-group">
                    <span class="input-group-text bg-white border-0">
                        <i class="bi bi-search"></i> <!-- Icon pencarian -->
                    </span>
                    <input type="text" name="query" class="form-control border-0"
                        placeholder="Cari informasi, berita, dan dokumen disini...." aria-label="Search">
                </div>
                <button class="btn btn-primary btn-search" type="submit">Cari</button>
            </form>

            <!-- Icon Section -->
            <div class="icon-section d-flex flex-wrap justify-content-center rounded-3 py-3 mt-3" id="iconAccordion">
                @foreach ($icons as $icon)
                    <div class="icon-container d-flex flex-column gap-2 justify-content-center align-items-center">
                        <div class="card bg-opacity-60 text-center">
                            <div class="card-body">
                                <!-- Icon image -->
                                <img src="{{ asset('storage/' . $icon->image) }}" alt="{{ $icon->title }}"
                                    class="img-fluid submenu-toggle" data-icon-id="{{ $icon->id }}">
                            </div>
                        </div>
                        <div class="portal-title">
                            <p class="text-center text-white">{{ $icon->title }}</p>
                        </div>
                        <!-- Submenu Collapse -->
                        <div id="iconMenu{{ $icon->id }}" class="submenu-collapse">
                            <ul>
                                @foreach ($icon->dropdowns as $dropdown)
                                    <li><a href="{{ $dropdown->link }}" target="_blank">{{ $dropdown->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section Berita dan Pengumuman --}}
    <section id="pengumuman-section" style="background-image: url('images/cover.png')">
        {{-- Main Container for the Section --}}
        <div class="container pengumuman-container d-flex justify-content-center" style="padding-top: 40px;">
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
                        @foreach ($posts->take(4) as $post)
                            {{-- Menampilkan hanya 4 item --}}
                            <div class="item">
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="row g-0">
                                        <div class="col-md-4" style="width: 55%;">
                                            {{-- Gambar untuk Post --}}
                                            @php
                                                $images = json_decode($post->image); // Dekode JSON untuk mendapatkan array gambar
                                                $firstImage = $images ? $images[0] : null; // Ambil gambar pertama
                                            @endphp

                                            @if ($firstImage)
                                                {{-- Jika gambar berupa link eksternal --}}
                                                @if (Str::startsWith($firstImage, ['http://', 'https://']))
                                                    <img src="{{ $firstImage }}" class="img-fluid" alt="Gambar Post"
                                                        style="width: 90%; height: 250px; object-fit: cover; border-radius: 5px;">
                                                @else
                                                    {{-- Jika gambar dari folder storage/uploads --}}
                                                    <img src="{{ asset('storage/' . $firstImage) }}" class="img-fluid"
                                                        alt="Gambar Post"
                                                        style="width: 90%; height: 250px; object-fit: cover; border-radius: 5px;">
                                                @endif
                                            @else
                                                {{-- Placeholder jika tidak ada gambar --}}
                                                <img src="{{ asset('images/placeholder.png') }}" class="img-fluid"
                                                    alt="Placeholder Image"
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
                                                    <small><i class="bi bi-person"></i> Admin &nbsp; <i
                                                            class="bi bi-eye"></i>
                                                        {{ $post->views }}</small>
                                                </div>
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
            <div class="col-md-4" style="width: 400px;">
                <h5 class="mb-3" style="font-weight: 600; font-size: 22px; margin-top: -13px;">Pengumuman</h5>
                {{-- Garis Bawah untuk Judul --}}
                <div class="mb-2 d-flex align-items-center" style="margin-top: 2px">
                    <div style="width: 50px; height: 6px; background-color: #2F4F7F;"></div>
                    <div style="flex-grow: 1; height: 2px; background-color: #2F4F7F;"></div>
                </div>
                <div class="list-group">
                    {{-- Looping untuk menampilkan 4 dokumen terbaru --}}
                    @foreach ($documents as $document)
                        <a href="{{ route('data.show', $document->data_id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                {{-- Image local yang ditambahkan di sebelah kiri --}}
                                <img src="{{ asset('/icons/dokumen.jpg') }}" alt="Document Icon" class="me-3" style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                                
                                {{-- Konten teks dokumen --}}
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1">{{ $document->title }}</h6>
                                    </div>
                                    <small><i class="bi bi-calendar"></i> {{ $document->created_at->format('d M Y') }}</small>
                                    <small><i class="bi bi-person"></i> Admin &nbsp; <i class="bi bi-eye"></i> {{ $document->views ?? 0 }}</small>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>                             
            </div>
        </div>
    </section>

    {{-- Headline --}}
    <section id="headline" class="py-4" style="background-image: url('images/cover.png');">
        <div class="headline-container">
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
                                @php
                                    // Dekode JSON untuk mendapatkan array gambar
                                    $images = json_decode($post->image);
                                    $firstImage = $images ? $images[0] : null;
                                @endphp

                                @if ($firstImage)
                                    {{-- Jika gambar berupa link eksternal --}}
                                    @if (Str::startsWith($firstImage, ['http://', 'https://']))
                                        <img src="{{ $firstImage }}" class="img-fluid" alt="Gambar Post"
                                            style="width: 100%; height: 250px; object-fit: cover; border-radius: 5px;">
                                    @else
                                        {{-- Jika gambar dari folder storage/uploads --}}
                                        <img src="{{ asset('storage/' . $firstImage) }}" class="img-fluid"
                                            alt="Gambar Post"
                                            style="width: 100%; height: 250px; object-fit: cover; border-radius: 5px;">
                                    @endif
                                @else
                                    {{-- Placeholder jika tidak ada gambar --}}
                                    <img src="{{ asset('images/placeholder.png') }}" class="img-fluid"
                                        alt="Placeholder Image"
                                        style="width: 100%; height: 250px; object-fit: cover; border-radius: 5px;">
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
                <a href="{{ route('headline.show', ['id' => $post->headline_id]) }}" class="btn btn-outline-primary">
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
        document.addEventListener('DOMContentLoaded', function() {
            var submenuToggles = document.querySelectorAll('.submenu-toggle');

            submenuToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah aksi default (jika link)

                    var iconId = this.getAttribute('data-icon-id');
                    var selectedSubmenu = document.getElementById('iconMenu' + iconId);
                    var iconRect = this.getBoundingClientRect(); // Dapatkan posisi ikon yang diklik
                    var submenuRect = selectedSubmenu
                        .getBoundingClientRect(); // Dapatkan posisi submenu

                    // Hitung posisi segitiga agar sejajar dengan ikon yang diklik
                    var trianglePosition = (iconRect.left + iconRect.width / 2) - submenuRect.left -
                        10;

                    // Pindahkan segitiga (::before) agar sejajar dengan ikon
                    selectedSubmenu.style.setProperty('--triangle-position',
                        `${trianglePosition}px`);

                    // Tutup submenu lain jika terbuka
                    document.querySelectorAll('.submenu-collapse').forEach(function(submenu) {
                        if (submenu !== selectedSubmenu && submenu.classList.contains(
                                'show')) {
                            submenu.classList.remove('show');
                        }
                    });

                    // Tampilkan submenu yang diklik
                    selectedSubmenu.classList.toggle('show');
                });
            });
        });

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
