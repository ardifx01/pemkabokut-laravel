@extends('layout')

@section('content')
    <div class="container mt-5" style="padding-top: 90px">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Data UMKM2</h2>
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

        <div class="card" style="width: 100%">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama UMKM</th>
                                <th>Jenis Usaha</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>NIB</th>
                                <th>Foto</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($businesses as $index => $business)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $business->nama }}</td>
                                    <td>{{ $business->jenis }}</td>
                                    <td>{{ Str::limit($business->alamat, 30) }}</td>
                                    <td>{{ $business->nomor_telepon }}</td>
                                    <td>{{ $business->email }}</td>
                                    <td>{{ $business->nib }}</td>
                                    <td>
                                        @if ($business->foto)
                                            @php
                                                $foto = is_array($business->foto)
                                                    ? $business->foto[0]
                                                    : $business->foto;
                                            @endphp
                                            <img src="{{ asset('storage/' . $foto) }}" alt="Foto UMKM" class="img-thumbnail"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">Tidak ada foto</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($business->status == 1)
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('umkm.show', $business->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>Detail
                                            </a>

                                            @auth
                                                <a href="{{ route('umkm.edit', $business->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>Edit
                                                </a>

                                                @if ($business->status == 0)
                                                    <form action="{{ route('umkm.approve', $business->id) }}" method="POST"
                                                        style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm"
                                                            onclick="return confirm('Setujui UMKM ini?')">
                                                            <i class="fas fa-check"></i>Setujui
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('umkm.reject', $business->id) }}" method="POST"
                                                        style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-secondary btn-sm"
                                                            onclick="return confirm('Tolak UMKM ini?')">
                                                            <i class="fas fa-times"></i>Tolak
                                                        </button>
                                                    </form>
                                                @endif

                                                <form action="{{ route('umkm.destroy', $business->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin menghapus UMKM ini?')">
                                                        <i class="fas fa-trash"></i>Hapus
                                                    </button>
                                                </form>
                                            @endauth
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">Belum ada data UMKM</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
