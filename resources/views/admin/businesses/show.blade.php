@extends('admin.layouts.navigation')

@section('title', 'UMKM Detail - Kata Admin')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1 text-gray-800">UMKM Detail</h1>
                        <p class="text-muted mb-0">Detailed information about {{ $business->nama }}</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.businesses.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-1"></i>Back to List
                        </a>
                        @if ($business->status == 0)
                            <form action="{{ route('admin.businesses.approve', $business->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success"
                                    onclick="return confirm('Setujui UMKM ini?')">
                                    <i class="fas fa-check me-1"></i>Approve
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.businesses.reject', $business->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-warning" onclick="return confirm('Tolak UMKM ini?')">
                                    <i class="fas fa-times me-1"></i>Set to Pending
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('admin.businesses.destroy', $business->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Hapus UMKM ini? Tindakan ini tidak dapat dibatalkan!')">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Business Info -->
        <div class="row">
            <!-- Business Photos -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Business Photos</h6>
                    </div>
                    <div class="card-body">
                        @if ($business->foto)
                            <img src="{{ asset('storage/' . $business->foto) }}" class="d-block w-100 rounded"
                                alt="{{ $business->nama }}" style="height: 300px; object-fit: cover;">
                        @else
                            <div class="text-center py-5">
                                <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 100%; height: 300px; font-size: 2rem; font-weight: bold;">
                                    {{ strtoupper(substr($business->nama, 0, 2)) }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Status Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Status</h6>
                    </div>
                    <div class="card-body text-center">
                        @if ($business->status == 1)
                            <div class="mb-3">
                                <i class="fas fa-check-circle fa-3x text-success"></i>
                            </div>
                            <h5 class="text-success">Approved</h5>
                            <p class="text-muted">This business has been approved and is visible to the public.</p>
                        @else
                            <div class="mb-3">
                                <i class="fas fa-clock fa-3x text-warning"></i>
                            </div>
                            <h5 class="text-warning">Pending</h5>
                            <p class="text-muted">This business is waiting for approval.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Business Details -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Business Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Business Name:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $business->nama }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Owner:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $business->owner }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Business Type:</strong>
                            </div>
                            <div class="col-sm-9">
                                <span class="badge bg-info">{{ $business->jenis }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Address:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $business->alamat }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Email:</strong>
                            </div>
                            <div class="col-sm-9">
                                <a href="mailto:{{ $business->email }}">{{ $business->email }}</a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Phone:</strong>
                            </div>
                            <div class="col-sm-9">
                                <a href="tel:{{ $business->nomor_telepon }}">{{ $business->nomor_telepon }}</a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>NIB:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $business->nib }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Description:</strong>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ $business->deskripsi }}</p>
                            </div>
                        </div>
                        @if ($business->google_maps_link)
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Google Maps:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <a href="{{ $business->google_maps_link }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-map-marker-alt me-1"></i>View on Maps
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if ($business->latitude && $business->longitude)
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Coordinates:</strong>
                                </div>
                                <div class="col-sm-9">
                                    {{ $business->latitude }}, {{ $business->longitude }}
                                </div>
                            </div>
                        @endif
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Approved by:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $business->user->name ?? 'No User Assigned' }}
                                @if ($business->user)
                                    <br><small class="text-muted">{{ $business->user->email }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Registration Date:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $business->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Last Updated:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $business->updated_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="card shadow-sm">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <a href="mailto:{{ $business->email }}" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-envelope me-1"></i>Send Email
                                </a>
                            </div>
                            <div class="col-md-4 mb-2">
                                <a href="tel:{{ $business->nomor_telepon }}" class="btn btn-outline-success w-100">
                                    <i class="fas fa-phone me-1"></i>Call Business
                                </a>
                            </div>
                            <div class="col-md-4 mb-2">
                                <a href="{{ route('umkm.show', $business->id) }}" target="_blank"
                                    class="btn btn-outline-info w-100">
                                    <i class="fas fa-external-link-alt me-1"></i>View Public Page
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // CSRF Token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Approve business function
        $(document).on('click', '.approve-btn', function() {
            const businessId = $(this).data('id');

            Swal.fire({
                title: 'Approve UMKM?',
                text: 'Are you sure you want to approve this business?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(`/admin/businesses/${businessId}/approve`)
                        .done(function(response) {
                            if (response.success) {
                                Swal.fire('Approved!', response.message, 'success');
                                location.reload();
                            }
                        })
                        .fail(function() {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        });
                }
            });
        });

        // Reject business function
        $(document).on('click', '.reject-btn', function() {
            const businessId = $(this).data('id');

            Swal.fire({
                title: 'Set to Pending?',
                text: 'This will change the business status to pending.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, set to pending!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(`/admin/businesses/${businessId}/reject`)
                        .done(function(response) {
                            if (response.success) {
                                Swal.fire('Changed!', response.message, 'success');
                                location.reload();
                            }
                        })
                        .fail(function() {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        });
                }
            });
        });

        // ...existing code...
    </script>
@endsection
