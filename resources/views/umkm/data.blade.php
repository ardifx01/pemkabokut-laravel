@extends('layout')

@section('content')
    <div class="container mt-5" style="padding-top: 90px; min-height: 100vh;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Data UMKM</h2>
            <a href="{{ route('umkm.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Daftarkan UMKM
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <style>
            .umkm-card {
                border-radius: 18px;
                overflow: hidden;
                background: #fff;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                height: 300px;
                position: relative;
                border: none;
            }

            .umkm-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }

            .umkm-card-background {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }

            .umkm-card-background.no-image {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                color: rgba(255, 255, 255, 0.7);
                font-size: 1.2rem;
                font-weight: 500;
            }

            .umkm-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2) 0%, rgba(0, 0, 0, 0.7) 100%);
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                padding: 20px;
                color: white;
            }

            .umkm-title {
                font-weight: 700;
                font-size: 1.25rem;
                margin-bottom: 6px;
                color: #fff;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            }

            .umkm-badge {
                font-size: 0.85rem;
                padding: 4px 12px;
                border-radius: 20px;
                background: rgba(255, 255, 255, 0.9);
                color: #4e54c8;
                margin-bottom: 8px;
                display: inline-block;
                font-weight: 600;
                width: fit-content;
                backdrop-filter: blur(10px);
            }

            .umkm-desc {
                color: rgba(255, 255, 255, 0.95);
                font-size: 0.9rem;
                margin-bottom: 12px;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
                line-height: 1.4;
            }

            .umkm-actions {
                display: flex;
                gap: 8px;
                flex-wrap: wrap;
            }

            .btn-detail {
                background: rgba(255, 255, 255, 0.9);
                color: #4e54c8;
                border: none;
                padding: 8px 16px;
                border-radius: 25px;
                font-size: 0.85rem;
                font-weight: 600;
                backdrop-filter: blur(10px);
                transition: all 0.3s ease;
            }

            .btn-detail:hover {
                background: rgba(255, 255, 255, 1);
                color: #4e54c8;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            }

            .empty-state {
                text-align: center;
                padding: 60px 20px;
                background: #f8f9fa;
                border-radius: 18px;
                border: 2px dashed #dee2e6;
            }

            .empty-state i {
                font-size: 3rem;
                color: #6c757d;
                margin-bottom: 20px;
            }
        </style>

        <div class="row g-4">
            @forelse($businesses as $index => $business)
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="umkm-card card">
                        @php
                            $foto = is_array($business->foto) ? $business->foto[0] : $business->foto;
                        @endphp

                        @if ($foto)
                            <div class="umkm-card-background"
                                style="background-image: url('{{ asset('storage/' . $foto) }}')"></div>
                        @else
                            <div class="umkm-card-background no-image">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif

                        <div class="umkm-overlay">
                            <div class="umkm-badge">{{ $business->jenis }}</div>
                            <div class="umkm-title">{{ $business->nama }}</div>
                            <div class="umkm-desc">{{ Str::limit($business->deskripsi, 80, '...') }}</div>
                            <div class="umkm-actions">
                                <a href="{{ route('umkm.show', $business->id) }}" class="btn btn-detail">
                                    <i class="fas fa-eye"></i> Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-store"></i>
                        <h4 class="text-muted">Belum ada data UMKM</h4>
                        <p class="text-muted mb-3">Mulai daftarkan UMKM pertama Anda</p>
                        <a href="{{ route('umkm.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Daftarkan UMKM Sekarang
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
