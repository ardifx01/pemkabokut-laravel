@extends('layout')

@section('content')
    <div class="container mt-5" style="padding-top: 90px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Edit UMKM</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('umkm.update', $business->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama UMKM *</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" value="{{ old('nama', $business->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis Usaha *</label>
                                <select class="form-control @error('jenis') is-invalid @enderror" id="jenis"
                                    name="jenis" required>
                                    <option value="">Pilih Jenis Usaha</option>
                                    <option value="Makanan dan Minuman"
                                        {{ old('jenis', $business->jenis) == 'Makanan dan Minuman' ? 'selected' : '' }}>
                                        Makanan dan Minuman</option>
                                    <option value="Pakaian dan Aksesoris"
                                        {{ old('jenis', $business->jenis) == 'Pakaian dan Aksesoris' ? 'selected' : '' }}>
                                        Pakaian dan Aksesoris</option>
                                    <option value="Jasa" {{ old('jenis', $business->jenis) == 'Jasa' ? 'selected' : '' }}>
                                        Jasa</option>
                                    <option value="Kerajinan Tangan"
                                        {{ old('jenis', $business->jenis) == 'Kerajinan Tangan' ? 'selected' : '' }}>
                                        Kerajinan Tangan</option>
                                    <option value="Elektronik"
                                        {{ old('jenis', $business->jenis) == 'Elektronik' ? 'selected' : '' }}>Elektronik
                                    </option>
                                    <option value="Kesehatan"
                                        {{ old('jenis', $business->jenis) == 'Kesehatan' ? 'selected' : '' }}>Kesehatan
                                    </option>
                                    <option value="Transportasi"
                                        {{ old('jenis', $business->jenis) == 'Transportasi' ? 'selected' : '' }}>
                                        Transportasi</option>
                                    <option value="Pendidikan"
                                        {{ old('jenis', $business->jenis) == 'Pendidikan' ? 'selected' : '' }}>Pendidikan
                                    </option>
                                    <option value="Teknologi"
                                        {{ old('jenis', $business->jenis) == 'Teknologi' ? 'selected' : '' }}>Teknologi
                                    </option>
                                </select>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat *</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                    required>{{ old('alamat', $business->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nomor_telepon" class="form-label">Nomor Telepon *</label>
                                <input type="tel" class="form-control @error('nomor_telepon') is-invalid @enderror"
                                    id="nomor_telepon" name="nomor_telepon"
                                    value="{{ old('nomor_telepon', $business->nomor_telepon) }}" required>
                                @error('nomor_telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $business->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nib" class="form-label">NIB (Nomor Induk Berusaha)</label>
                                <input type="text" class="form-control @error('nib') is-invalid @enderror" id="nib"
                                    name="nib" value="{{ old('nib', $business->nib) }}">
                                @error('nib')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Opsional - jika sudah memiliki NIB</small>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi *</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4"
                                    required>{{ old('deskripsi', $business->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto UMKM</label>
                                <input type="file" class="form-control @error('foto.*') is-invalid @enderror"
                                    id="foto" name="foto[]" multiple accept="image/*">
                                @error('foto.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Opsional - Pilih beberapa foto untuk diupload</small>

                                @if ($business->foto && count($business->foto) > 0)
                                    <div class="mt-2">
                                        <label class="form-label">Foto saat ini:</label>
                                        <div class="row">
                                            @foreach ($business->foto as $foto)
                                                <div class="col-md-3 mb-2">
                                                    <img src="{{ asset('storage/' . $foto) }}" class="img-thumbnail"
                                                        style="max-height: 100px;">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status Saat Ini:</label>
                                <span class="badge {{ $business->status == 1 ? 'bg-success' : 'bg-warning' }} ms-2">
                                    {{ $business->status == 1 ? 'Approved' : 'Pending' }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('umkm.show', $business->id) }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Update UMKM</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
