@extends('admin.layouts.navigation')

@section('title', 'Dashboard - Kata Admin')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1 text-gray-800">Dashboard</h1>
                        <p class="text-muted mb-0">Free Bootstrap 5 Admin Dashboard</p>
                    </div>
                    <div>
                        <button class="btn btn-outline-success me-2">
                            <i class="fas fa-download me-1"></i>Manage
                        </button>
                        <button class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Add Customer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-primary text-white rounded me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Visitors</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['visitors']) ? number_format($statistics['visitors']) : '1,294' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-info text-white rounded me-3">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Subscribers</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['subscribers']) ? number_format($statistics['subscribers']) : '1303' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-success text-white rounded me-3">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Sales</div>
                            <div class="h4 mb-0 font-weight-bold">$
                                {{ isset($statistics['sales']) ? number_format($statistics['sales']) : '1,345' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-secondary text-white rounded me-3">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Order</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['orders']) ? number_format($statistics['orders']) : '576' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <!-- User Statistics Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">User Statistics</h6>
                        <div>
                            <button class="btn btn-sm btn-outline-success me-2">
                                <i class="fas fa-download me-1"></i>Export
                            </button>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-print me-1"></i>Print
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="userStatsChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daily Sales Card -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary">
                        <h6 class="m-0 font-weight-bold text-white">Daily Sales</h6>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                Export
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">PDF</a></li>
                                <li><a class="dropdown-item" href="#">Excel</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body bg-primary text-white">
                        <div class="text-center">
                            <div class="small text-light mb-2">March 25 - April 02</div>
                            <div class="h2 font-weight-bold text-white mb-3">$4,578.58</div>
                            <div class="chart-pie mb-3">
                                <canvas id="dailySalesChart" width="100%" height="100"></canvas>
                            </div>
                            <div class="row text-center">
                                <div class="col">
                                    <div class="h4 font-weight-bold text-white">17</div>
                                    <div class="small text-light">Days</div>
                                </div>
                                <div class="col">
                                    <div class="h4 font-weight-bold text-success">+5%</div>
                                    <div class="small text-light">Growth</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Customers and Transaction History Row -->
        <div class="row">
            <!-- New UMKM Businesses Card -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">DATA UMKM</h6>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.businesses.index') }}">View All</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.businesses.index', ['status' => 1]) }}">Approved</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.businesses.index', ['status' => 0]) }}">Not Approved</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @forelse($recentBusinesses as $business)
                                <div class="list-group-item border-0 px-0 py-2">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            @if ($business->foto && is_array($business->foto) && count($business->foto) > 0)
                                                <img src="{{ asset('storage/' . $business->foto[0]) }}"
                                                    class="rounded-circle" alt="{{ $business->nama }}" width="40"
                                                    height="40" style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                                    style="width: 40px; height: 40px; font-weight: bold;">
                                                    {{ strtoupper(substr($business->nama, 0, 2)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-bold">{{ $business->nama }}</div>
                                            <div class="text-muted small">{{ $business->email }}</div>
                                            <div class="text-muted small">{{ $business->nomor_telepon }}</div>
                                        </div>
                                        <div class="col-auto d-flex align-items-center">
                                            <!-- Status Light Bar -->
                                            <div class="me-2">
                                                @if ($business->status == 1)
                                                    <div class="bg-success rounded" style="width: 4px; height: 30px;"
                                                        title="Approved"></div>
                                                @else
                                                    <div class="bg-warning rounded" style="width: 4px; height: 30px;"
                                                        title="Pending"></div>
                                                @endif
                                            </div>
                                            <!-- Action Buttons -->
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
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="list-group-item border-0 px-0 py-4 text-center">
                                    <div class="text-muted">
                                        <i class="fas fa-store fa-3x mb-3"></i>
                                        <p>Belum ada data UMKM</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction History Card -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Transaction History</h6>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">View All</a></li>
                                <li><a class="dropdown-item" href="#">Export</a></li>
                                <li><a class="dropdown-item" href="#">Filter</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead class="text-muted small">
                                    <tr>
                                        <th>PAYMENT NUMBER</th>
                                        <th>DATE & TIME</th>
                                        <th>AMOUNT</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="text-success me-2">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">Payment from #10231</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-muted small">Mar 19, 2020, 2.45pm</td>
                                        <td class="font-weight-bold">$250.00</td>
                                        <td>
                                            <span class="badge bg-success text-white">Completed</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="text-success me-2">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">Payment from #10231</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-muted small">Mar 19, 2020, 2.45pm</td>
                                        <td class="font-weight-bold">$250.00</td>
                                        <td>
                                            <span class="badge bg-success text-white">Completed</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="text-success me-2">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">Payment from #10231</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-muted small">Mar 19, 2020, 2.45pm</td>
                                        <td class="font-weight-bold">$250.00</td>
                                        <td>
                                            <span class="badge bg-success text-white">Completed</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="text-success me-2">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">Payment from #10231</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-muted small">Mar 19, 2020, 2.45pm</td>
                                        <td class="font-weight-bold">$250.00</td>
                                        <td>
                                            <span class="badge bg-success text-white">Completed</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="text-success me-2">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">Payment from #10231</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-muted small">Mar 19, 2020, 2.45pm</td>
                                        <td class="font-weight-bold">$250.00</td>
                                        <td>
                                            <span class="badge bg-success text-white">Completed</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="text-success me-2">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">Payment from #10231</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-muted small">Mar 19, 2020, 2.45pm</td>
                                        <td class="font-weight-bold">$250.00</td>
                                        <td>
                                            <span class="badge bg-success text-white">Completed</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="text-success me-2">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">Payment from #10231</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-muted small">Mar 19, 2020, 2.45pm</td>
                                        <td class="font-weight-bold">$250.00</td>
                                        <td>
                                            <span class="badge bg-success text-white">Completed</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            const button = $(this);

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

        // User Statistics Chart
        const userStatsCtx = document.getElementById('userStatsChart').getContext('2d');
        const userStatsChart = new Chart(userStatsCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Users',
                    data: [400, 300, 400, 500, 400, 300, 400, 500, 600, 700, 800, 900],
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Sessions',
                    data: [200, 250, 200, 300, 250, 200, 250, 300, 350, 400, 450, 500],
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Bounce Rate',
                    data: [150, 180, 150, 200, 180, 150, 180, 200, 220, 250, 280, 300],
                    borderColor: 'rgb(255, 205, 86)',
                    backgroundColor: 'rgba(255, 205, 86, 0.2)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Daily Sales Chart
        const dailySalesCtx = document.getElementById('dailySalesChart').getContext('2d');
        const dailySalesChart = new Chart(dailySalesCtx, {
            type: 'line',
            data: {
                labels: ['Mar 25', 'Mar 26', 'Mar 27', 'Mar 28', 'Mar 29', 'Mar 30', 'Mar 31', 'Apr 01', 'Apr 02'],
                datasets: [{
                    label: 'Daily Sales',
                    data: [3000, 3200, 3100, 3400, 3300, 3500, 3800, 4200, 4578],
                    borderColor: 'rgba(255, 255, 255, 0.8)',
                    backgroundColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        display: false
                    },
                    x: {
                        display: false
                    }
                },
                elements: {
                    point: {
                        radius: 0
                    }
                }
            }
        });
    </script>
@endsection
