@extends('admin.layouts.navigation')

@section('title', 'Detail User - Sistem Admin Portal Informasi OKU Timur')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h3 mb-0 text-gray-800">Detail User</h2>
                        <p class="text-muted">Informasi detail user</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Profile Information Card Redesain -->
            <div class="col-12">
                <div class="card shadow mb-4" style="border-radius: 16px;">
                    <div class="card-header py-3 d-flex align-items-center"
                        style="background: linear-gradient(90deg, #7F6AED 0%, #7F6AED 100%); border-top-left-radius: 16px; border-top-right-radius: 16px;">
                        <i class="fas fa-user text-white me-2"></i>
                        <h6 class="m-0 font-weight-bold text-white">Informasi Profile</h6>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-4 d-flex justify-content-center mb-3 mb-md-0">
                                @if ($user->foto && file_exists(storage_path('app/public/users/' . $user->foto)))
                                    <img src="{{ asset('storage/users/' . $user->foto) }}" class="rounded-circle shadow"
                                        width="180" height="180"
                                        style="object-fit: cover; object-position: top; border: 6px solid #fff;">
                                @else
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow"
                                        style="width: 180px; height: 180px; font-size: 56px; font-weight: bold; border: 6px solid #fff;">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <div class="form-control-plaintext fs-5">{{ $user->name }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <div class="form-control-plaintext fs-5">{{ $user->email }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Bergabung Sejak</label>
                                    <div class="form-control-plaintext fs-5">{{ $user->created_at->format('d F Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Horizontal Account Info Card -->
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex align-items-center">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        <h6 class="m-0 font-weight-bold text-info">Informasi Akun</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-row flex-wrap justify-content-between align-items-center">
                            <div class="p-2">
                                <small class="text-muted">ID Pengguna:</small><br>
                                <span class="fw-bold">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="p-2">
                                <small class="text-muted">Status Akun:</small><br>
                                @if ($user->is_verified)
                                    <span class="badge bg-success">Terverifikasi</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Terverifikasi</span>
                                @endif
                            </div>
                            <div class="info-card-horizontal p-2">
                                <div class="card card-horizontal border-left-primary shadow mb-0">
                                    <div class="card-body d-flex align-items-center justify-content-between px-3 py-2">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fas fa-newspaper fa-2x text-primary"></i>
                                            <div>
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Post
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ \App\Models\Post::where('user_id', $user->id)->count() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="info-card-horizontal p-2">
                                <div class="card card-horizontal border-left-success shadow mb-0">
                                    <div class="card-body d-flex align-items-center justify-content-between px-3 py-2">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fas fa-file-alt fa-2x text-success"></i>
                                            <div>
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Document</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ \App\Models\Document::where('user_id', $user->id)->count() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="info-card-horizontal p-2">
                                <div class="card card-horizontal border-left-info shadow mb-0">
                                    <div class="card-body d-flex align-items-center justify-content-between px-3 py-2">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fas fa-icons fa-2x text-info"></i>
                                            <div>
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Icon
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ \App\Models\Icon::where('user_id', $user->id)->count() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
