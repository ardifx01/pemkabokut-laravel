@extends('layout')

@section('title', 'Daftar Artikel')

@push('styles')
    <style>
        /* Fix untuk mencegah konflik dengan navbar */
        body {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }

        /* Pastikan navbar tidak memiliki garis putih yang mengganggu */
        .navbar {
            border: none !important;
            margin-bottom: 0 !important;
            border-bottom: 4px solid #cfec4a !important;
        }

        /* Menghilangkan border atau outline yang tidak diinginkan */
        .navbar-nav .nav-item,
        .navbar-nav .nav-link {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
        }

        /* Override navbar-nav positioning untuk mencegah item bergeser */
        .navbar-collapse .navbar-nav {
            margin-left: auto !important;
            margin-right: auto !important;
            align-items: center !important;
        }

        .navbar-nav .nav-item {
            position: relative;
            vertical-align: middle;
            display: inline-flex;
            align-items: center;
        }

        .navbar-nav .nav-item:first-child {
            margin-left: 0;
        }

        .navbar-nav .nav-item .nav-link {
            vertical-align: middle;
            line-height: 1.5;
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
            display: flex;
            align-items: center;
        }

        /* Menghilangkan garis putih di bawah nav items */
        .navbar-nav .nav-item::after,
        .navbar-nav .nav-item::before {
            display: none !important;
        }

        /* Pastikan semua nav item sejajar */
        .navbar-nav {
            align-items: center;
        }

        .article-section {
            padding: 2rem 0;
            background-color: #f8f9fa;
            position: relative;
            z-index: 1;
        }

        .section-header {
            border-bottom: 3px solid #007bff;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .article-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }

        .article-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .article-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .article-content {
            padding: 1rem;
        }

        .article-category {
            background: #28a745;
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            position: absolute;
            top: 0.5rem;
            left: 0.5rem;
            z-index: 2;
        }

        .article-title {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .article-meta {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 0.75rem;
        }

        .article-meta i {
            margin-right: 0.25rem;
        }

        .article-excerpt {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .category-sidebar {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            height: fit-content;
            position: sticky;
            top: 2rem;
        }

        .category-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            color: inherit;
        }

        .category-item:hover {
            background-color: #f8f9fa;
            color: inherit;
            text-decoration: none;
        }

        .category-item:last-child {
            border-bottom: none;
        }

        .category-name {
            font-size: 0.9rem;
            color: #333;
        }

        .category-count {
            background: #007bff;
            color: white;
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            min-width: 24px;
            text-align: center;
        }

        .category-item.active {
            background-color: #e3f2fd;
            border-left: 3px solid #007bff;
        }

        .category-item.active .category-name {
            color: #007bff;
            font-weight: 600;
        }

        .load-more-btn {
            background: #007bff;
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            transition: background-color 0.3s;
        }

        .load-more-btn:hover {
            background: #0056b3;
        }
    </style>
@endpush

@section('content')
    <section class="article-section" style="margin-top: 100px;">
        <div class="container">
            <div class="row">
                <!-- Daftar Artikel (Kiri) -->
                <div class="col-lg-8">
                    <div class="section-header">
                        <h2 class="section-title">Daftar Artikel</h2>
                    </div>

                    <div id="articles-container">
                        <div class="row">
                            @foreach ($posts as $post)
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <a href="{{ url('post/show/' . $post->id) }}" class="article-card"
                                        style="text-decoration:none; color:inherit;">
                                        <div class="position-relative">
                                            @php
                                                $images = json_decode($post->image);
                                                $firstImage = $images ? $images[0] : null;
                                            @endphp

                                            @if ($firstImage)
                                                @if (Str::startsWith($firstImage, ['http://', 'https://']))
                                                    <img src="{{ $firstImage }}" class="article-image"
                                                        alt="{{ $post->title }}">
                                                @else
                                                    <img src="{{ asset('storage/' . $firstImage) }}" class="article-image"
                                                        alt="{{ $post->title }}">
                                                @endif
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" class="article-image"
                                                    alt="No Image">
                                            @endif

                                            <span class="article-category">
                                                @if ($post->headline)
                                                    {{ $post->headline->title }}
                                                @elseif($post->category)
                                                    {{ $post->category->title }}
                                                @else
                                                    Umum
                                                @endif
                                            </span>
                                        </div>

                                        <div class="article-content">
                                            <h5 class="article-title">{{ $post->title }}</h5>
                                            <div class="article-meta">
                                                <i class="bi bi-calendar"></i> {{ $post->published_at->format('d M Y') }}
                                                <span class="mx-2">•</span>
                                                <i class="bi bi-person"></i>
                                                {{ $post->user ? $post->user->name : 'Admin' }}
                                                <span class="mx-2">•</span>
                                                <i class="bi bi-eye"></i> {{ $post->views ?? 0 }}
                                            </div>
                                            <p class="article-excerpt">
                                                {{ Str::limit(strip_tags($post->description), 150, '...') }}
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if ($posts->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $posts->links() }}
                        </div>
                    @endif

                    @if ($posts->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-file-earmark-text" style="font-size: 3rem; color: #dee2e6;"></i>
                            <h4 class="mt-3 text-muted">Tidak ada artikel</h4>
                            <p class="text-muted">Belum ada artikel untuk kategori ini.</p>
                        </div>
                    @endif
                </div>

                <!-- Kategori Artikel (Kanan) -->
                <div class="col-lg-4">
                    <div class="category-sidebar">
                        <div class="section-header">
                            <h2 class="section-title">Kategori Artikel</h2>
                        </div>

                        <!-- Categories -->
                        @foreach ($categories as $category)
                            <a href="javascript:void(0)" class="category-item" data-type="category"
                                data-id="{{ $category->id }}">
                                <span class="category-name">{{ $category->title }}</span>
                                <span class="category-count">{{ $category->posts_count ?? 0 }}</span>
                            </a>
                        @endforeach

                        <!-- Headlines -->
                        @foreach ($headlines as $headline)
                            <a href="javascript:void(0)" class="category-item" data-type="headline"
                                data-id="{{ $headline->id }}">
                                <span class="category-name">{{ $headline->title }}</span>
                                <span class="category-count">{{ $headline->posts_count ?? 0 }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryItems = document.querySelectorAll('.category-item');
            const articlesContainer = document.getElementById('articles-container');

            categoryItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Remove active class from all items
                    categoryItems.forEach(i => i.classList.remove('active'));

                    // Add active class to clicked item
                    this.classList.add('active');

                    const type = this.getAttribute('data-type');
                    const id = this.getAttribute('data-id');

                    // Show loading
                    articlesContainer.innerHTML =
                        '<div class="text-center py-5"><div class="spinner-border" role="status"></div></div>';

                    // Fetch articles
                    fetch(`/api/articles/${type}/${id}`)
                        .then(response => response.json())
                        .then(data => {
                            let html = '<div class="row">';

                            if (data.articles && data.articles.length > 0) {
                                data.articles.forEach(post => {
                                    const images = post.image ? JSON.parse(post.image) :
                                        [];
                                    const firstImage = images.length > 0 ? images[0] :
                                        null;
                                    let imageUrl = '/images/no-image.png';

                                    if (firstImage) {
                                        if (firstImage.startsWith('http://') ||
                                            firstImage.startsWith('https://')) {
                                            imageUrl = firstImage;
                                        } else {
                                            imageUrl = `/storage/${firstImage}`;
                                        }
                                    }

                                    const publishedDate = new Date(post.published_at)
                                        .toLocaleDateString('id-ID', {
                                            day: 'numeric',
                                            month: 'short',
                                            year: 'numeric'
                                        });

                                    // Determine category/headline for badge
                                    let categoryTitle = 'Umum';
                                    if (post.headline && post.headline.title) {
                                        categoryTitle = post.headline.title;
                                    } else if (post.category && post.category.title) {
                                        categoryTitle = post.category.title;
                                    }

                                    html += `
                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                            <div class="article-card">
                                                <div class="position-relative">
                                                    <img src="${imageUrl}" class="article-image" alt="${post.title}">
                                                    <span class="article-category">
                                                        ${categoryTitle}
                                                    </span>
                                                </div>
                                                <div class="article-content">
                                                    <h5 class="article-title">${post.title}</h5>
                                                    <div class="article-meta">
                                                        <i class="bi bi-calendar"></i> ${publishedDate}
                                                        <span class="mx-2">•</span>
                                                        <i class="bi bi-person"></i> Admin
                                                        <span class="mx-2">•</span>
                                                        <i class="bi bi-eye"></i> ${post.views || 0}
                                                    </div>
                                                    <p class="article-excerpt">
                                                        ${post.description ? post.description.replace(/<[^>]*>/g, '').substring(0, 150) + '...' : ''}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                });
                                html += '</div>';
                            } else {
                                html = `
                                    <div class="text-center py-5">
                                        <i class="bi bi-file-earmark-text" style="font-size: 3rem; color: #dee2e6;"></i>
                                        <h4 class="mt-3 text-muted">Tidak ada artikel</h4>
                                        <p class="text-muted">Belum ada artikel untuk kategori ini.</p>
                                    </div>
                                `;
                            }

                            articlesContainer.innerHTML = html;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            articlesContainer.innerHTML =
                                '<div class="text-center py-5 text-danger">Terjadi kesalahan saat memuat artikel.</div>';
                        });
                });
            });
        });
    </script>
@endpush
