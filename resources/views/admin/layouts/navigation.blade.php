<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - Sistem Admin Portal Informasi OKU Timur')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin/navbar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/calendar.css') }}" rel="stylesheet">

    <!-- Custom Topbar Styles -->
    <style>
        .hover-effect {
            transition: all 0.3s ease;
        }

        .hover-effect:hover {
            background-color: #f8f9fa !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 0.75rem 1rem;
        }

        .nav-item .nav-link {
            position: relative;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .notification-icon .fas.fa-bell {
            font-size: 18px;
            line-height: 1;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-profile-link {
            padding: 6px 12px !important;
            min-width: 120px;
        }

        .badge-notification {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: translate(-50%, -50%) scale(1);
            }

            50% {
                transform: translate(-50%, -50%) scale(1.1);
            }

            100% {
                transform: translate(-50%, -50%) scale(1);
            }
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            padding: 0.5rem 0;
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        /* Submenu Dropdown Styles */
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            right: 100%;
            /* Pindah ke kiri */
            left: auto;
            /* Reset left position */
            margin-top: 0;
            margin-right: 1px;
            /* Margin ke kanan */
            min-width: 280px;
            display: none;
        }

        .dropdown-submenu.show .dropdown-menu {
            display: block;
        }

        .dropdown-submenu .dropdown-toggle::after {
            display: none;
            /* Hide the arrow */
        }

        /* Toggle Switch Styles */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.toggle-slider {
            background-color: #28a745;
        }

        input:checked+.toggle-slider:before {
            transform: translateX(26px);
        }

        /* Settings submenu item styles */
        .settings-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-bottom: 1px solid #f1f3f4;
        }

        .settings-item:last-child {
            border-bottom: none;
        }

        .settings-item .item-info {
            flex: 1;
        }

        .settings-item .item-title {
            font-weight: 500;
            color: #333;
            font-size: 14px;
            margin-bottom: 2px;
        }

        .settings-item .item-description {
            font-size: 12px;
            color: #6c757d;
            line-height: 1.3;
        }
    </style>
</head>

<body>
    <!-- Sidebar Toggle Button -->
    <button class="sidebar-toggle-btn" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <img src="{{ asset('icons/logo_okutimur.png') }}" alt="Logo OKU Timur" class="brand-logo">
                <div class="brand-text">
                    <div class="brand-text-top">Sistem Admin</div>
                    <div class="brand-text-bottom">Portal Informasi OKU Timur</div>
                </div>
            </div>
        </div>

        <div class="sidebar-content">
            <ul class="sidebar-nav">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
            </ul>
            <div class="nav-section">
                <div class="nav-section-title">INFORMASI PUBLIK</div>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="{{ route('category.data') }}"
                            class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}">
                            <i class="fas fa-tags"></i>
                            <span>Category</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('post.data') }}"
                            class="nav-link {{ request()->routeIs('post.*') ? 'active' : '' }}">
                            <i class="fas fa-newspaper"></i>
                            <span>Posts</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('headline.data') }}"
                            class="nav-link {{ request()->routeIs('headline.*') ? 'active' : '' }}">
                            <i class="fas fa-bullhorn"></i>
                            <span>Headlines</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">DOKUMEN PUBLIK</div>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="{{ route('data.index') }}"
                            class="nav-link {{ request()->routeIs('data.*') ? 'active' : '' }}">
                            <i class="fas fa-database"></i>
                            <span>Data</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('document.data') }}"
                            class="nav-link {{ request()->routeIs('document.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt"></i>
                            <span>Dokumen</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('file.data') }}"
                            class="nav-link {{ request()->routeIs('file.*') ? 'active' : '' }}">
                            <i class="fas fa-folder"></i>
                            <span>Files</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">LAYANAN MASYARAKAT</div>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="{{ route('icon.data') }}"
                            class="nav-link {{ request()->routeIs('icon.*') ? 'active' : '' }}">
                            <i class="fas fa-globe"></i>
                            <span>Portal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.businesses.index') }}"
                            class="nav-link {{ request()->routeIs('admin.businesses.*') ? 'active' : '' }}">
                            <i class="fas fa-store"></i>
                            <span>UMKM</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
            <div class="container-fluid">
                <div class="navbar-nav ms-auto d-flex align-items-center">
                    <!-- Notifikasi UMKM Pending -->
                    <div class="nav-item dropdown me-3">
                        <a class="nav-link notification-icon rounded-circle bg-light hover-effect d-flex align-items-center justify-content-center"
                            href="#" role="button" data-bs-toggle="dropdown" id="pendingBusinessNotification"
                            style="border: none; text-decoration: none; position: relative;">
                            <i class="fas fa-bell text-secondary"></i>
                            <span class="position-absolute badge rounded-pill bg-danger badge-notification"
                                id="pendingCount"
                                style="top: -2px; right: -10px; font-size: 0.6rem; min-width: 18px; height: 18px; display: none; align-items: center; justify-content: center;">0</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0"
                            style="min-width: 400px; max-height: 400px; overflow-y: auto; border-radius: 8px;">
                            <li>
                                <h6 class="dropdown-header text-primary fw-bold">
                                    <i class="fas fa-bell me-2"></i>UMKM Menunggu Persetujuan
                                </h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <div id="pendingBusinessList">
                                <!-- Pending businesses will be loaded here -->
                            </div>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-center text-primary fw-medium"
                                    href="{{ route('admin.businesses.index', ['status' => 0]) }}">
                                    <i class="fas fa-external-link-alt me-2"></i>Lihat Semua
                                </a></li>
                        </ul>
                    </div>

                    <!-- User Profile -->
                    <div class="nav-item dropdown">
                        <a class="nav-link user-profile-link d-flex align-items-center rounded-pill bg-light hover-effect"
                            href="#" role="button" data-bs-toggle="dropdown"
                            style="border: none; text-decoration: none;">
                            @if (Auth::user()->foto && file_exists(storage_path('app/public/users/' . Auth::user()->foto)))
                                <img src="{{ asset('storage/users/' . Auth::user()->foto) }}"
                                    alt="Foto {{ Auth::user()->name }}" class="rounded-circle me-2" width="40"
                                    height="40"
                                    style="object-fit: cover; border: 2px solid #e9ecef; object-position: top;">
                            @else
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                    style="width: 36px; height: 36px; font-size: 14px; font-weight: bold; border: 2px solid #e9ecef;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                            @endif
                            <span class="fw-medium text-dark d-none d-md-inline">Hi, {{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down ms-2 text-muted" style="font-size: 0.8rem;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" style="border-radius: 8px;">
                            <li><a class="dropdown-item" href="{{ route('admin.profile.show') }}"><i
                                        class="fas fa-user me-2 text-primary"></i>Profile</a>
                            </li>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#"><i
                                        class="fas fa-cog me-2 text-secondary"></i>Settings</a>
                                <ul class="dropdown-menu">
                                    <li class="settings-item">
                                        <div class="item-info">
                                            <div class="item-title">Hide UMKM Registration</div>
                                            <div class="item-description">Hide UMKM registration button from homepage
                                            </div>
                                        </div>
                                        <label class="toggle-switch">
                                            <input type="checkbox" id="hideUmkmRegistration"
                                                onchange="toggleUmkmRegistration(this)">
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </li>
                                    <li class="settings-item">
                                        <div class="item-info">
                                            <div class="item-title">Hide UMKM Menu</div>
                                            <div class="item-description">Hide UMKM icon menu from homepage</div>
                                        </div>
                                        <label class="toggle-switch">
                                            <input type="checkbox" id="hideUmkmMenu" onchange="toggleUmkmMenu(this)">
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="page-content">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleBtn = document.getElementById('sidebarToggle');

            sidebar.classList.toggle('collapsed');
            if (mainContent) {
                mainContent.classList.toggle('expanded');
            }

            // Update toggle button position
            if (sidebar.classList.contains('collapsed')) {
                toggleBtn.style.left = '85px';
            } else {
                toggleBtn.style.left = '265px';
            }
        });

        // Submenu toggle
        document.querySelectorAll('.has-submenu > .nav-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const parent = this.parentElement;
                parent.classList.toggle('open');
            });
        });

        // Load pending businesses notification
        function loadPendingBusinesses() {
            $.ajax({
                url: '/admin/api/pending-businesses',
                type: 'GET',
                success: function(response) {
                    const pendingCount = response.count || 0;
                    const businesses = response.businesses || [];

                    // Update notification count
                    $('#pendingCount').text(pendingCount);

                    // Update badge visibility and color
                    if (pendingCount > 0) {
                        $('#pendingCount').removeClass('d-none').css('display', 'flex').addClass(
                            'bg-danger text-white');
                    } else {
                        $('#pendingCount').addClass('d-none').css('display', 'none');
                    }

                    // Update business list
                    let businessHtml = '';
                    if (businesses.length > 0) {
                        businesses.forEach(function(business) {
                            businessHtml += `
                                <li>
                                    <a class="dropdown-item py-2" href="/admin/businesses/${business.id}">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                ${business.foto && business.foto.length > 0 ? 
                                                    `<img src="/storage/${business.foto[0]}" class="rounded-circle" width="32" height="32" style="object-fit: cover;">` :
                                                    `<div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px;">${business.nama.substring(0, 2).toUpperCase()}</div>`
                                                }
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-bold text-truncate" style="max-width: 150px;">${business.nama}</div>
                                                <div class="text-muted small">${business.email}</div>
                                            </div>
                                            <div class="ms-2">
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>`;
                        });
                    } else {
                        businessHtml =
                            '<li><div class="dropdown-item-text text-center text-muted py-3">Tidak ada UMKM pending</div></li>';
                    }

                    $('#pendingBusinessList').html(businessHtml);
                },
                error: function() {
                    $('#pendingBusinessList').html(
                        '<li><div class="dropdown-item-text text-center text-muted py-3">Error loading data</div></li>'
                    );
                }
            });
        }

        // Load pending businesses on page load
        $(document).ready(function() {
            loadPendingBusinesses();

            // Refresh every 30 seconds
            setInterval(loadPendingBusinesses, 30000);
        });

        // Refresh when dropdown is clicked
        $('#pendingBusinessNotification').on('click', function() {
            loadPendingBusinesses();
        });

        // UMKM Settings Toggle Functions
        function toggleUmkmRegistration(checkbox) {
            const isHidden = checkbox.checked;

            // Send AJAX request to update setting
            $.ajax({
                url: '/admin/settings/toggle-umkm-registration',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    hide_registration: isHidden
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        showToast(isHidden ? 'UMKM Registration hidden' : 'UMKM Registration shown', 'success');
                    }
                },
                error: function() {
                    // Revert checkbox if error
                    checkbox.checked = !checkbox.checked;
                    showToast('Error updating setting', 'error');
                }
            });
        }

        function toggleUmkmMenu(checkbox) {
            const isHidden = checkbox.checked;

            // Send AJAX request to update setting
            $.ajax({
                url: '/admin/settings/toggle-umkm-menu',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    hide_menu: isHidden
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        showToast(isHidden ? 'UMKM Menu hidden' : 'UMKM Menu shown', 'success');
                    }
                },
                error: function() {
                    // Revert checkbox if error
                    checkbox.checked = !checkbox.checked;
                    showToast('Error updating setting', 'error');
                }
            });
        }

        // Toast notification function
        function showToast(message, type) {
            const toast = $(`
                <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `);

            // Add toast container if it doesn't exist
            if ($('#toast-container').length === 0) {
                $('body').append(
                    '<div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>');
            }

            $('#toast-container').append(toast);

            // Initialize and show toast
            const bsToast = new bootstrap.Toast(toast[0]);
            bsToast.show();

            // Remove toast element after it's hidden
            toast.on('hidden.bs.toast', function() {
                $(this).remove();
            });
        }

        // Load current settings on page load
        function loadCurrentSettings() {
            $.ajax({
                url: '/admin/settings/get-umkm-settings',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#hideUmkmRegistration').prop('checked', response.data.hide_registration);
                        $('#hideUmkmMenu').prop('checked', response.data.hide_menu);
                    }
                },
                error: function() {
                    console.log('Error loading settings');
                }
            });
        }

        // Load settings when page loads
        $(document).ready(function() {
            loadCurrentSettings();

            // Handle dropdown submenu click
            $('.dropdown-submenu .dropdown-toggle').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Close other submenus
                $('.dropdown-submenu').not($(this).parent()).removeClass('show');

                // Toggle current submenu
                $(this).parent('.dropdown-submenu').toggleClass('show');
            });

            // Close submenu when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown-submenu').length) {
                    $('.dropdown-submenu').removeClass('show');
                }
            });

            // Prevent submenu from closing when clicking inside it
            $('.dropdown-submenu .dropdown-menu').on('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
</body>

</html>
