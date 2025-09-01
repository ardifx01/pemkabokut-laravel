@extends('layout')

@section('content')
    <div class="container mt-5" style="padding-top: 90px">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Daftarkan UMKM</h4>
                            <a href="{{ route('umkm.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('umkm.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <!-- Nama UMKM -->
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">Nama UMKM <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ old('nama') }}" required>
                                </div>

                                <!-- Jenis Usaha -->
                                <div class="col-md-6 mb-3">
                                    <label for="jenis" class="form-label">Jenis Usaha <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="jenis" name="jenis" required>
                                        <option value="">Pilih Jenis Usaha</option>
                                        <option value="Makanan dan Minuman"
                                            {{ old('jenis') == 'Makanan dan Minuman' ? 'selected' : '' }}>Makanan dan
                                            Minuman</option>
                                        <option value="Pakaian dan Aksesoris"
                                            {{ old('jenis') == 'Pakaian dan Aksesoris' ? 'selected' : '' }}>Pakaian dan
                                            Aksesoris</option>
                                        <option value="Jasa" {{ old('jenis') == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                                        <option value="Kerajinan Tangan"
                                            {{ old('jenis') == 'Kerajinan Tangan' ? 'selected' : '' }}>Kerajinan Tangan
                                        </option>
                                        <option value="Elektronik" {{ old('jenis') == 'Elektronik' ? 'selected' : '' }}>
                                            Elektronik</option>
                                        <option value="Kesehatan" {{ old('jenis') == 'Kesehatan' ? 'selected' : '' }}>
                                            Kesehatan</option>
                                        <option value="Transportasi"
                                            {{ old('jenis') == 'Transportasi' ? 'selected' : '' }}>Transportasi</option>
                                        <option value="Pendidikan" {{ old('jenis') == 'Pendidikan' ? 'selected' : '' }}>
                                            Pendidikan</option>
                                        <option value="Teknologi" {{ old('jenis') == 'Teknologi' ? 'selected' : '' }}>
                                            Teknologi</option>
                                    </select>
                                </div>

                                <!-- Owner -->
                                <div class="col-md-6 mb-3">
                                    <label for="owner" class="form-label">Nama Pemilik <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="owner" name="owner"
                                        value="{{ old('owner') }}" required>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email') }}" required>
                                </div>

                                <!-- Nomor Telepon -->
                                <div class="col-md-6 mb-3">
                                    <label for="nomor_telepon" class="form-label">Nomor Telepon <span
                                            class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="nomor_telepon" name="nomor_telepon"
                                        value="{{ old('nomor_telepon') }}" required>
                                </div>

                                <!-- NIB -->
                                <div class="col-md-12 mb-3">
                                    <label for="nib" class="form-label">NIB (Nomor Induk Berusaha) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nib" name="nib"
                                        value="{{ old('nib') }}" required>
                                </div>

                                <!-- Alamat Lengkap -->
                                <div class="col-md-12 mb-3">
                                    <label for="alamat" class="form-label">Alamat Lengkap <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required
                                        placeholder="Masukkan alamat lengkap usaha Anda (contoh: Jl. Sudirman No. 123, Kelurahan ABC, Kecamatan XYZ, Kota Jakarta)">{{ old('alamat') }}</textarea>
                                </div>

                                <!-- Link Google Maps -->
                                <div class="col-md-12 mb-3">
                                    <label for="google_maps_link" class="form-label">Link Google Maps (Opsional)</label>
                                    <div class="input-group">
                                        <input type="url" class="form-control" id="google_maps_link"
                                            name="google_maps_link" value="{{ old('google_maps_link') }}"
                                            placeholder="Contoh: https://www.google.com/maps/place/Nama+Tempat/@-6.2087634,106.845599,17z">
                                        <button type="button" class="btn btn-success"
                                            onclick="extractLocationFromLink()">
                                            <i class="fas fa-map-marker-alt"></i> Preview Lokasi
                                        </button>
                                    </div>
                                    <small class="text-muted">
                                        <strong>Cara mendapat link:</strong>
                                        1. Buka Google Maps → 2. Cari lokasi usaha → 3. Klik "Bagikan" → 4. Copy link dan
                                        paste di sini
                                    </small>

                                    <!-- Preview Map Container -->
                                    <div id="map-preview"
                                        style="height: 300px; width: 100%; margin-top: 15px; display: none;"
                                        class="border rounded">
                                        <div id="map" style="height: 100%; width: 100%;"></div>
                                    </div>

                                    <!-- Koordinat tersembunyi -->
                                    <input type="hidden" id="latitude" name="latitude">
                                    <input type="hidden" id="longitude" name="longitude">
                                </div>

                                <!-- Deskripsi -->
                                <div class="col-md-12 mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi Usaha <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi') }}</textarea>
                                    <small class="text-muted">Ceritakan tentang usaha Anda, produk/jasa yang ditawarkan,
                                        dll.</small>
                                </div>

                                <!-- Upload Foto -->
                                <div class="col-md-12 mb-3">
                                    <label for="foto" class="form-label">Foto Usaha</label>
                                    <input type="file" class="form-control" id="foto" name="foto[]" multiple
                                        accept="image/*" onchange="previewImages()">
                                    <small class="text-muted">Anda dapat memilih lebih dari 1 foto. Format: JPG, JPEG, PNG,
                                        GIF. Maksimal 2MB per foto.</small>

                                    <!-- Preview Images -->
                                    <div id="image-preview" class="mt-3 row"></div>
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('umkm.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Daftarkan UMKM
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet OpenStreetMap CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        let map;
        let marker;

        function extractLocationFromLink() {
            const linkInput = document.getElementById('google_maps_link');
            const link = linkInput.value.trim();

            if (!link) {
                alert('Masukkan link Google Maps terlebih dahulu');
                return;
            }

            // Extract coordinates from various Google Maps link formats
            const coordinates = extractCoordinatesFromGoogleMapsLink(link);

            if (coordinates) {
                showMapPreview(coordinates.lat, coordinates.lng);

                // Save coordinates
                document.getElementById('latitude').value = coordinates.lat;
                document.getElementById('longitude').value = coordinates.lng;

                // Optional: Update address field with reverse geocoding
                reverseGeocode(coordinates.lat, coordinates.lng);

                showMessage('success', 'Lokasi berhasil ditemukan dan ditampilkan di peta!');
            } else {
                showMessage('danger',
                    'Link Google Maps tidak valid atau tidak dapat diproses. Pastikan link yang Anda masukkan benar.');
            }
        }

        function extractCoordinatesFromGoogleMapsLink(link) {
            try {
                // Pattern 1: @lat,lng,zoom (most common in share links)
                let match = link.match(/@(-?\d+\.?\d*),(-?\d+\.?\d*),/);
                if (match) {
                    return {
                        lat: parseFloat(match[1]),
                        lng: parseFloat(match[2])
                    };
                }

                // Pattern 2: !3d[lat]!4d[lng] (from embed links)
                match = link.match(/!3d(-?\d+\.?\d*)!4d(-?\d+\.?\d*)/);
                if (match) {
                    return {
                        lat: parseFloat(match[1]),
                        lng: parseFloat(match[2])
                    };
                }

                // Pattern 3: q=lat,lng
                match = link.match(/q=(-?\d+\.?\d*),(-?\d+\.?\d*)/);
                if (match) {
                    return {
                        lat: parseFloat(match[1]),
                        lng: parseFloat(match[2])
                    };
                }

                // Pattern 4: ll=lat,lng
                match = link.match(/ll=(-?\d+\.?\d*),(-?\d+\.?\d*)/);
                if (match) {
                    return {
                        lat: parseFloat(match[1]),
                        lng: parseFloat(match[2])
                    };
                }

                // Pattern 5: /place/name/@lat,lng
                match = link.match(/\/place\/[^\/]+\/@(-?\d+\.?\d*),(-?\d+\.?\d*)/);
                if (match) {
                    return {
                        lat: parseFloat(match[1]),
                        lng: parseFloat(match[2])
                    };
                }

                return null;
            } catch (error) {
                console.error('Error extracting coordinates:', error);
                return null;
            }
        }

        function showMapPreview(lat, lng) {
            const mapContainer = document.getElementById('map-preview');
            mapContainer.style.display = 'block';

            if (!map) {
                // Initialize Leaflet map
                map = L.map('map').setView([lat, lng], 15);

                // Add OpenStreetMap tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors',
                    maxZoom: 19
                }).addTo(map);
            } else {
                // Update existing map
                map.setView([lat, lng], 15);
            }

            // Remove existing marker
            if (marker) {
                map.removeLayer(marker);
            }

            // Add new marker
            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);

            // Update coordinates when marker is dragged
            marker.on('dragend', function() {
                const position = marker.getLatLng();
                document.getElementById('latitude').value = position.lat;
                document.getElementById('longitude').value = position.lng;
                reverseGeocode(position.lat, position.lng);
            });

            // Add click event to map for repositioning marker
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                document.getElementById('latitude').value = e.latlng.lat;
                document.getElementById('longitude').value = e.latlng.lng;
                reverseGeocode(e.latlng.lat, e.latlng.lng);
            });
        }

        function reverseGeocode(lat, lng) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.display_name) {
                        const alamatField = document.getElementById('alamat');
                        // Only update if field is empty or user confirms
                        if (!alamatField.value.trim() || confirm('Update alamat dengan data dari peta?')) {
                            alamatField.value = data.display_name;
                            showMessage('info', 'Alamat telah diperbarui berdasarkan lokasi di peta');
                        }
                    }
                })
                .catch(error => {
                    console.log('Error reverse geocoding:', error);
                });
        }

        function showMessage(type, message) {
            // Remove existing alerts
            const existingAlerts = document.querySelectorAll('.temp-alert');
            existingAlerts.forEach(alert => alert.remove());

            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show mt-2 temp-alert`;
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
            `;

            const mapContainer = document.getElementById('map-preview');
            mapContainer.appendChild(alertDiv);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }

        function previewImages() {
            const input = document.getElementById('foto');
            const preview = document.getElementById('image-preview');
            preview.innerHTML = '';

            if (input.files) {
                Array.from(input.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-md-3 mb-2';
                        col.innerHTML = `
                    <div class="card">
                        <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;">
                        <div class="card-body p-2">
                            <small class="text-muted">${file.name}</small>
                        </div>
                    </div>
                `;
                        preview.appendChild(col);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        // Add helpful example function
        function showExampleLinks() {
            const examples = `
Contoh format link Google Maps yang didukung:

Contoh Link Place:
https://www.google.com/maps/place/Nama+Tempat/@-6.2087634,106.845599,17z

Cara mendapatkan link yang berfungsi:
1. Buka Google Maps di browser desktop
2. Cari atau tandai lokasi usaha Anda
3. Copy link yang muncul di search bar browser
4. Paste di kolom di atas
            `;
            alert(examples);
        }

        // Add example button in the DOM
        document.addEventListener('DOMContentLoaded', function() {
            const linkInput = document.getElementById('google_maps_link');
            if (linkInput) {
                const helpButton = document.createElement('button');
                helpButton.type = 'button';
                helpButton.className = 'btn btn-outline-info btn-sm mt-1';
                helpButton.innerHTML = '<i class="fas fa-question-circle"></i> Lihat Contoh Link';
                helpButton.onclick = showExampleLinks;

                linkInput.parentNode.appendChild(helpButton);
            }
        });
    </script>

    <style>
        .gap-2 {
            gap: 0.5rem;
        }

        #image-preview .card {
            border: 1px solid #dee2e6;
        }

        #image-preview .card-img-top {
            border-bottom: 1px solid #dee2e6;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
        }

        .text-danger {
            color: #dc3545 !important;
        }
    </style>
@endsection
