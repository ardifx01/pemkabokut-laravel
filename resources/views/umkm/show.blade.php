@extends('layout')

@section('content')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        .foto-umkm-card {
            transition: transform 0.2s ease-in-out;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .foto-umkm-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .foto-umkm-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
            cursor: pointer;
        }

        .map-container {
            position: relative;
        }

        .map-container #map {
            transition: box-shadow 0.3s ease;
            z-index: 1;
        }

        .map-container #map:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Ensure Leaflet controls are properly displayed */
        .leaflet-container {
            font-family: inherit;
        }
    </style>

    <div class="container mt-5" style="padding-top: 90px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Detail UMKM</h4>
                        <span class="badge {{ $business->status == 1 ? 'bg-success' : 'bg-warning' }}">
                            {{ $business->status == 1 ? 'Approved' : 'Pending' }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-4">Nama UMKM:</dt>
                                    <dd class="col-sm-8">{{ $business->nama }}</dd>

                                    <dt class="col-sm-4">Jenis Usaha:</dt>
                                    <dd class="col-sm-8">{{ $business->jenis }}</dd>

                                    <dt class="col-sm-4">Owner:</dt>
                                    <dd class="col-sm-8">{{ $business->owner }}</dd>

                                    <dt class="col-sm-4">Email:</dt>
                                    <dd class="col-sm-8">{{ $business->email }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-4">Telepon:</dt>
                                    <dd class="col-sm-8">{{ $business->nomor_telepon }}</dd>

                                    <dt class="col-sm-4">NIB:</dt>
                                    <dd class="col-sm-8">{{ $business->nib ?: 'Belum ada' }}</dd>

                                    <dt class="col-sm-4">Tanggal Daftar:</dt>
                                    <dd class="col-sm-8">{{ $business->created_at->format('d M Y') }}</dd>
                                </dl>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-12">
                                <dt>Alamat:</dt>
                                <dd>{{ $business->alamat }}</dd>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-12">
                                <dt class="mb-3">Lokasi pada Peta:</dt>
                                <div class="map-container">
                                    <div id="map" style="height: 300px; border: 1px solid #ddd; border-radius: 8px;">
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt"></i> {{ $business->alamat }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($business->deskripsi)
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <dt>Deskripsi:</dt>
                                    <dd style="text-align: justify; white-space: pre-line;">{{ $business->deskripsi }}</dd>
                                </div>
                            </div>
                        @else
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <dt>Deskripsi:</dt>
                                    <dd class="text-muted">Belum ada deskripsi</dd>
                                </div>
                            </div>
                        @endif

                        @if ($business->foto && count($business->foto) > 0)
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <dt class="mb-3">Foto UMKM:</dt>
                                    <div class="row g-3">
                                        @foreach ($business->foto as $index => $foto)
                                            <div class="col-md-4 col-sm-6">
                                                <div class="foto-umkm-card">
                                                    <img src="{{ asset('storage/' . $foto) }}" class="foto-umkm-img"
                                                        alt="Foto UMKM {{ $index + 1 }}"
                                                        onclick="showImageModal('{{ asset('storage/' . $foto) }}', 'Foto UMKM {{ $index + 1 }}')">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <dt class="mb-3">Foto UMKM:</dt>
                                    <dd class="text-muted">Belum ada foto yang diupload</dd>
                                </div>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('umkm.index') }}" class="btn btn-secondary">Kembali</a>

                            @auth
                                <div class="btn-group">
                                    <a href="{{ route('umkm.edit', $business->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    @if ($business->status == 0)
                                        <form action="{{ route('umkm.approve', $business->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm"
                                                onclick="return confirm('Setujui UMKM ini?')">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('umkm.reject', $business->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-secondary btn-sm"
                                                onclick="return confirm('Tolak UMKM ini?')">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk menampilkan foto dalam ukuran besar -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Foto UMKM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Foto UMKM">
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        function showImageModal(imageSrc, imageTitle) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModalLabel').textContent = imageTitle;
            var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        }

        // Initialize map
        document.addEventListener('DOMContentLoaded', function() {
            // Default coordinates (Jakarta as fallback)
            var defaultLat = -6.2088;
            var defaultLng = 106.8456;
            var businessAddress = @json($business->alamat);

            // Initialize map
            var map = L.map('map').setView([defaultLat, defaultLng], 13);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Geocoding function using Nominatim
            async function geocodeAddress(address) {
                try {
                    const response = await fetch(
                        `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1`
                    );
                    const data = await response.json();

                    if (data && data.length > 0) {
                        const result = data[0];
                        const lat = parseFloat(result.lat);
                        const lng = parseFloat(result.lon);

                        // Update map view
                        map.setView([lat, lng], 15);

                        // Add marker
                        L.marker([lat, lng])
                            .addTo(map)
                            .bindPopup(`<strong>{{ $business->nama }}</strong><br>${address}`)
                            .openPopup();
                    } else {
                        // If geocoding fails, add a marker with the address at default location
                        L.marker([defaultLat, defaultLng])
                            .addTo(map)
                            .bindPopup(
                                `<strong>{{ $business->nama }}</strong><br>${address}<br><em>Koordinat perkiraan</em>`
                            )
                            .openPopup();
                    }
                } catch (error) {
                    console.error('Geocoding error:', error);
                    // Add fallback marker
                    L.marker([defaultLat, defaultLng])
                        .addTo(map)
                        .bindPopup(
                            `<strong>{{ $business->nama }}</strong><br>${address}<br><em>Lokasi tidak dapat diverifikasi</em>`
                        )
                        .openPopup();
                }
            }

            // Geocode the business address
            if (businessAddress) {
                geocodeAddress(businessAddress);
            } else {
                // Add default marker if no address
                L.marker([defaultLat, defaultLng])
                    .addTo(map)
                    .bindPopup(`<strong>{{ $business->nama }}</strong><br><em>Alamat belum tersedia</em>`)
                    .openPopup();
            }
        });
    </script>
@endsection
