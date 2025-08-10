@extends('admin.layouts.navigation')

@section('title', 'UMKM Management - Kata Admin')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1 text-gray-800">UMKM Management</h1>
                        <p class="text-muted mb-0">Manage all registered UMKM businesses</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-primary text-white rounded mb-2 mx-auto"
                            style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-store"></i>
                        </div>
                        <h5>{{ $businesses->total() }}</h5>
                        <p class="text-muted mb-0">Total UMKM</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-success text-white rounded mb-2 mx-auto"
                            style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-check"></i>
                        </div>
                        <h5>{{ $businesses->where('status', 1)->count() }}</h5>
                        <p class="text-muted mb-0">Approved</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-warning text-white rounded mb-2 mx-auto"
                            style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h5>{{ $businesses->where('status', 0)->count() }}</h5>
                        <p class="text-muted mb-0">Pending</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.businesses.index') }}">
                            <div class="row align-items-end">
                                <div class="col-md-3">
                                    <label for="status" class="form-label">Filter by Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="">All Status</option>
                                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Approved
                                        </option>
                                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Pending
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter me-1"></i>Filter
                                    </button>
                                    <a href="{{ route('admin.businesses.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-refresh me-1"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Businesses Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">UMKM List</h6>
                    </div>
                    <div class="card-body">
                        @if ($businesses->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($businesses as $business)
                                            <tr>
                                                <td>
                                                    @if ($business->foto && is_array($business->foto) && count($business->foto) > 0)
                                                        <img src="{{ asset('storage/' . $business->foto[0]) }}"
                                                            class="rounded" alt="{{ $business->nama }}" width="50"
                                                            height="50" style="object-fit: cover;">
                                                    @else
                                                        <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center"
                                                            style="width: 50px; height: 50px; font-weight: bold;">
                                                            {{ strtoupper(substr($business->nama, 0, 2)) }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="font-weight-bold">{{ $business->nama }}</div>
                                                    <small
                                                        class="text-muted">{{ $business->user->name ?? 'No User' }}</small>
                                                </td>
                                                <td>{{ $business->email }}</td>
                                                <td>{{ $business->nomor_telepon }}</td>
                                                <td>{{ $business->jenis }}</td>
                                                <td>
                                                    @if ($business->status == 1)
                                                        <span class="badge bg-success">Approved</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.businesses.show', $business) }}"
                                                            class="btn btn-sm btn-outline-info" title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if ($business->status == 0)
                                                            <button class="btn btn-sm btn-outline-success approve-btn"
                                                                data-id="{{ $business->id }}" title="Approve">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        @else
                                                            <button class="btn btn-sm btn-outline-warning reject-btn"
                                                                data-id="{{ $business->id }}" title="Set to Pending">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        @endif
                                                        <button class="btn btn-sm btn-outline-danger delete-btn"
                                                            data-id="{{ $business->id }}" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{ $businesses->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-store fa-5x text-muted mb-3"></i>
                                <h5 class="text-muted">No UMKM businesses found</h5>
                                <p class="text-muted">There are no businesses matching your filter criteria.</p>
                            </div>
                        @endif
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

        // Delete business function
        $(document).on('click', '.delete-btn', function() {
            const businessId = $(this).data('id');

            Swal.fire({
                title: 'Delete UMKM?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/businesses/${businessId}`,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Deleted!', response.message, 'success');
                                location.reload();
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        });
    </script>
@endsection
