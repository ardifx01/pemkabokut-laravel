@extends('admin.layouts.navigation')

@section('title', 'Dashboard - Sistem Admin Portal Informasi OKU Timur')

@section('content')
    <!-- Blue Background Section -->
    <div
        style="background: linear-gradient(rgba(7, 63, 151, 0.8), rgba(7, 63, 151, 0.8)), url('{{ asset('images/Perjaya.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative; margin: -21px -23px 0 -23px; padding: 20px 20px 210px 20px;">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-1 text-white">Dashboard</h1>
                            <p class="text-white-50 mb-0" id="welcomeText">Selamat datang, Admin - <span
                                    id="currentDateTime"></span></p>
                        </div>
                        <div>
                            <button class="btn btn-light">
                                <i class="fas fa-plus me-1"></i>Create New
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-top: -210px; position: relative; z-index: 10;">

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-primary text-white rounded me-3">
                            <i class="fas fa-list"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Categories</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['categories']) ? number_format($statistics['categories']) : '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-info text-white rounded me-3">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Headlines</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['headlines']) ? number_format($statistics['headlines']) : '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-success text-white rounded me-3">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Posts</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['posts']) ? number_format($statistics['posts']) : '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-warning text-white rounded me-3">
                            <i class="fas fa-database"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Data</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['data']) ? number_format($statistics['data']) : '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row of Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-danger text-white rounded me-3">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Documents</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['documents']) ? number_format($statistics['documents']) : '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-dark text-white rounded me-3">
                            <i class="fas fa-folder"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Files</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['files']) ? number_format($statistics['files']) : '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-purple text-white rounded me-3"
                            style="background-color: #6f42c1 !important;">
                            <i class="fas fa-store"></i>
                        </div>
                        <div>
                            <div class="text-muted small">UMKM</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['businesses']) ? number_format($statistics['businesses']) : '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-secondary text-white rounded me-3">
                            <i class="fas fa-icons"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Portal</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['icons']) ? number_format($statistics['icons']) : '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar Row -->
        <div class="row">
            <!-- Calendar Card -->
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary me-3">Kalender</h6>
                            <h5 class="m-0 text-gray-800" id="calendarTitle">Agustus 2025</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <button id="prevButton" class="btn btn-sm btn-outline-primary me-2">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button id="todayButton" class="btn btn-sm btn-primary me-2">Today</button>
                            <button id="nextButton" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Customers and Transaction History Row -->
        <div class="row">
            <!-- Transaction History Card -->
            <div class="col-12">
                <div class="card shadow mb-4">
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Function to update current date and time
        function updateDateTime() {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            const dayName = days[now.getDay()];
            const day = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');

            const dateTimeString = `${dayName}, ${day} ${month} ${year} - ${hours}:${minutes} WIB`;

            const dateTimeElement = document.getElementById('currentDateTime');
            if (dateTimeElement) {
                dateTimeElement.textContent = dateTimeString;
            }
        }

        // Initialize FullCalendar
        document.addEventListener('DOMContentLoaded', function() {
            // Update date time immediately and every minute
            updateDateTime();
            setInterval(updateDateTime, 60000); // Update every minute

            const calendarEl = document.getElementById('calendar');
            let calendar;

            if (calendarEl) {
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'id',
                    headerToolbar: false, // We'll use custom buttons
                    height: 'auto',
                    aspectRatio: 2.5,
                    firstDay: 1, // Start week on Monday
                    dayMaxEvents: 3,
                    moreLinkClick: 'popover',
                    dayHeaderFormat: {
                        weekday: 'short'
                    },
                    titleFormat: {
                        year: 'numeric',
                        month: 'long'
                    },
                    datesSet: function(dateInfo) {
                        // Update the custom calendar title
                        updateCalendarTitle(dateInfo.view.title);
                    },
                    events: {
                        url: '{{ route('admin.api.calendar-events') }}',
                        method: 'GET',
                        failure: function() {
                            // Fallback to static events if AJAX fails
                            return @json($calendarEvents ?? []);
                        }
                    },
                    eventClick: function(info) {
                        const eventDetails = info.event.extendedProps.description ||
                            'Tidak ada deskripsi';
                        Swal.fire({
                            title: info.event.title,
                            html: `<strong>Tanggal:</strong> ${info.event.startStr}<br><strong>Deskripsi:</strong> ${eventDetails}`,
                            icon: 'info',
                            confirmButtonText: 'OK'
                        });
                    },
                    dayCellDidMount: function(info) {
                        // Highlight today
                        if (info.date.toDateString() === new Date().toDateString()) {
                            info.el.style.backgroundColor = '#f8f9fc';
                            info.el.style.border = '2px solid #4e73df';
                        }
                    },
                    eventDidMount: function(info) {
                        // Add hover effects
                        info.el.style.cursor = 'pointer';
                        info.el.addEventListener('mouseenter', function() {
                            this.style.opacity = '0.8';
                        });
                        info.el.addEventListener('mouseleave', function() {
                            this.style.opacity = '1';
                        });
                    }
                });

                calendar.render();

                // Function to update calendar title
                function updateCalendarTitle(title) {
                    document.getElementById('calendarTitle').textContent = title;
                }

                // Initialize title
                updateCalendarTitle(calendar.view.title);

                // Custom button handlers
                document.getElementById('prevButton').addEventListener('click', function() {
                    calendar.prev();
                });

                document.getElementById('todayButton').addEventListener('click', function() {
                    calendar.today();
                });

                document.getElementById('nextButton').addEventListener('click', function() {
                    calendar.next();
                });
            }
        });

        // CSRF Token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); // Approve business function
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
    </script>
@endsection
