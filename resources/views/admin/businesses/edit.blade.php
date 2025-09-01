@extends('admin.layouts.navigation')


@section('title', 'Edit UMKM - Kata Admin')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1 text-gray-800"><i class="fas fa-edit me-2"></i>Edit UMKM</h1>
                        <p class="text-muted mb-0">Perbarui data dan informasi UMKM <strong>{{ $business->nama }}</strong>
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('admin.businesses.show', $business->id) }}" class="btn btn-outline-info me-2">
                            <i class="fas fa-eye me-1"></i>Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Foto & Status -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Foto UMKM</h6>
                    </div>
                    <div class="card-body">
                        @if ($business->foto && count($business->foto) > 0)
                            <div class="row" id="existing-photos">
                                @foreach ($business->foto as $index => $foto)
                                    <div class="col-md-6 mb-2" id="photo-{{ $index }}">
                                        <div class="photo-container position-relative">
                                            <img src="{{ asset('storage/' . $foto) }}" class="img-thumbnail rounded"
                                                style="max-height: 120px; width: 100%; object-fit: cover;">
                                            <button type="button"
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-photo-btn"
                                                data-photo-index="{{ $index }}"
                                                data-business-id="{{ $business->id }}"
                                                style="transform: translate(50%, -50%);" title="Hapus foto">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 100px; height: 100px; font-size: 2rem;">
                                    {{ strtoupper(substr($business->nama, 0, 2)) }}
                                </div>
                                <p class="text-muted mt-3">Belum ada foto</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Status</h6>
                    </div>
                    <div class="card-body text-center">
                        @if ($business->status == 1)
                            <div class="mb-3">
                                <i class="fas fa-check-circle fa-3x text-success"></i>
                            </div>
                            <h5 class="text-success">Approved</h5>
                            <p class="text-muted">UMKM sudah disetujui dan tampil di publik.</p>
                        @else
                            <div class="mb-3">
                                <i class="fas fa-clock fa-3x text-warning"></i>
                            </div>
                            <h5 class="text-warning">Pending</h5>
                            <p class="text-muted">UMKM menunggu persetujuan admin.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Form Edit -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Edit UMKM</h6>
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
                        <form action="{{ route('businesses.update', $business->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">Nama UMKM *</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" name="nama" value="{{ old('nama', $business->nama) }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="jenis" class="form-label">Jenis Usaha *</label>
                                    <select class="form-select @error('jenis') is-invalid @enderror" id="jenis"
                                        name="jenis" required>
                                        <option value="">Pilih Jenis Usaha</option>
                                        <option value="Makanan dan Minuman"
                                            {{ old('jenis', $business->jenis) == 'Makanan dan Minuman' ? 'selected' : '' }}>
                                            Makanan dan Minuman</option>
                                        <option value="Pakaian dan Aksesoris"
                                            {{ old('jenis', $business->jenis) == 'Pakaian dan Aksesoris' ? 'selected' : '' }}>
                                            Pakaian dan Aksesoris</option>
                                        <option value="Jasa"
                                            {{ old('jenis', $business->jenis) == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                                        <option value="Kerajinan Tangan"
                                            {{ old('jenis', $business->jenis) == 'Kerajinan Tangan' ? 'selected' : '' }}>
                                            Kerajinan Tangan</option>
                                        <option value="Elektronik"
                                            {{ old('jenis', $business->jenis) == 'Elektronik' ? 'selected' : '' }}>
                                            Elektronik</option>
                                        <option value="Kesehatan"
                                            {{ old('jenis', $business->jenis) == 'Kesehatan' ? 'selected' : '' }}>Kesehatan
                                        </option>
                                        <option value="Transportasi"
                                            {{ old('jenis', $business->jenis) == 'Transportasi' ? 'selected' : '' }}>
                                            Transportasi</option>
                                        <option value="Pendidikan"
                                            {{ old('jenis', $business->jenis) == 'Pendidikan' ? 'selected' : '' }}>
                                            Pendidikan</option>
                                        <option value="Teknologi"
                                            {{ old('jenis', $business->jenis) == 'Teknologi' ? 'selected' : '' }}>Teknologi
                                        </option>
                                    </select>
                                    @error('jenis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="owner" class="form-label">Nama Pemilik Usaha *</label>
                                    <input type="text" class="form-control @error('owner') is-invalid @enderror"
                                        id="owner" name="owner" value="{{ old('owner', $business->owner) }}"
                                        required>
                                    @error('owner')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="alamat" class="form-label">Alamat *</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="2"
                                        required>{{ old('alamat', $business->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nomor_telepon" class="form-label">Nomor Telepon *</label>
                                    <input type="tel"
                                        class="form-control @error('nomor_telepon') is-invalid @enderror"
                                        id="nomor_telepon" name="nomor_telepon"
                                        value="{{ old('nomor_telepon', $business->nomor_telepon) }}" required>
                                    @error('nomor_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $business->email) }}"
                                        required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nib" class="form-label">NIB (Nomor Induk Berusaha)</label>
                                    <input type="text" class="form-control @error('nib') is-invalid @enderror"
                                        id="nib" name="nib" value="{{ old('nib', $business->nib) }}">
                                    @error('nib')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Opsional - jika sudah memiliki NIB</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi *</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                                        rows="2" required>{{ old('deskripsi', $business->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Upload Foto Baru</label>
                                <input type="file" class="form-control @error('foto.*') is-invalid @enderror"
                                    id="foto" name="foto[]" multiple accept="image/*">
                                @error('foto.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Opsional - Pilih beberapa foto untuk diupload</small>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.businesses.index') }}" class="btn btn-secondary"><i
                                        class="fas fa-arrow-left me-1"></i>Kembali</a>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update
                                    UMKM</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .delete-photo-btn {
            border-radius: 50% !important;
            width: 30px !important;
            height: 30px !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 12px !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2) !important;
        }

        .delete-photo-btn:hover {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
            transform: translate(50%, -50%) scale(1.1) !important;
            transition: all 0.2s ease !important;
        }

        .photo-container {
            position: relative !important;
            overflow: hidden !important;
            border-radius: 8px !important;
        }

        .photo-container:hover .delete-photo-btn {
            opacity: 1 !important;
        }

        .delete-photo-btn {
            opacity: 0.8 !important;
            transition: opacity 0.2s ease !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle delete photo button clicks
            document.querySelectorAll('.delete-photo-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const photoIndex = this.getAttribute('data-photo-index');
                    const businessId = this.getAttribute('data-business-id');
                    const photoElement = document.getElementById('photo-' + photoIndex);

                    if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
                        // Show loading state
                        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                        this.disabled = true;

                        // Send AJAX request to delete photo
                        fetch(`/admin/umkm/${businessId}/photo`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    photo_index: photoIndex
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Remove photo element from DOM
                                    photoElement.remove();

                                    // Show success message
                                    showAlert('success', data.message);

                                    // Check if no photos left
                                    const remainingPhotos = document.querySelectorAll(
                                        '#existing-photos .col-md-3');
                                    if (remainingPhotos.length === 0) {
                                        document.getElementById('existing-photos').parentElement
                                            .remove();
                                    }
                                } else {
                                    showAlert('error', data.message);
                                    // Reset button state
                                    this.innerHTML = '<i class="fas fa-times"></i>';
                                    this.disabled = false;
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showAlert('error', 'Terjadi kesalahan saat menghapus foto');
                                // Reset button state
                                this.innerHTML = '<i class="fas fa-times"></i>';
                                this.disabled = false;
                            });
                    }
                });
            });

            function showAlert(type, message) {
                // Create alert element
                const alertDiv = document.createElement('div');
                alertDiv.className =
                    `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
                alertDiv.style.position = 'fixed';
                alertDiv.style.top = '20px';
                alertDiv.style.right = '20px';
                alertDiv.style.zIndex = '9999';
                alertDiv.style.minWidth = '300px';

                alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

                // Add to body
                document.body.appendChild(alertDiv);

                // Auto remove after 3 seconds
                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
            }
        });
    </script>
@endpush
