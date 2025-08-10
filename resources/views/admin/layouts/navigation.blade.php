<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - Kata Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin/navbar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/dashboard.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <i class="fas fa-infinity text-primary"></i>
                <span class="brand-text">kata<strong>admin</strong></span>
            </div>
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
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
                    <a href="{{ route('admin.businesses.index') }}"
                        class="nav-link {{ request()->routeIs('admin.businesses.*') ? 'active' : '' }}">
                        <i class="fas fa-store"></i>
                        <span>UMKM Management</span>
                    </a>
                </li>
            </ul>

            <div class="nav-section">
                <div class="nav-section-title">COMPONENTS</div>
                <ul class="sidebar-nav">
                    <li class="nav-item has-submenu">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <span>Base</span>
                            <i class="fas fa-chevron-down submenu-arrow"></i>
                        </a>
                    </li>
                    <li class="nav-item has-submenu">
                        <a href="#" class="nav-link">
                            <i class="fas fa-bars"></i>
                            <span>Sidebar Layouts</span>
                            <i class="fas fa-chevron-down submenu-arrow"></i>
                        </a>
                    </li>
                    <li class="nav-item has-submenu">
                        <a href="#" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <span>Forms</span>
                            <i class="fas fa-chevron-down submenu-arrow"></i>
                        </a>
                    </li>
                    <li class="nav-item has-submenu">
                        <a href="#" class="nav-link">
                            <i class="fas fa-table"></i>
                            <span>Tables</span>
                            <i class="fas fa-chevron-down submenu-arrow"></i>
                        </a>
                    </li>
                    <li class="nav-item has-submenu">
                        <a href="#" class="nav-link">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Maps</span>
                            <i class="fas fa-chevron-down submenu-arrow"></i>
                        </a>
                    </li>
                    <li class="nav-item has-submenu">
                        <a href="#" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Charts</span>
                            <i class="fas fa-chevron-down submenu-arrow"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-puzzle-piece"></i>
                            <span>Widgets</span>
                            <span class="badge bg-success ms-auto">4</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            <span>Documentation</span>
                            <span class="badge bg-primary ms-auto">1</span>
                        </a>
                    </li>
                    <li class="nav-item has-submenu">
                        <a href="#" class="nav-link">
                            <i class="fas fa-sitemap"></i>
                            <span>Menu Levels</span>
                            <i class="fas fa-chevron-down submenu-arrow"></i>
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
                <div class="navbar-nav ms-auto">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-envelope me-2"></i>
                        </a>
                    </div>
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                            data-bs-toggle="dropdown">
                            <span class="badge bg-success me-2">1</span>
                        </a>
                    </div>
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-bars me-2"></i>
                        </a>
                    </div>
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                            data-bs-toggle="dropdown">
                            <img src="https://via.placeholder.com/32x32" alt="Avatar" class="rounded-circle me-2"
                                width="32" height="32">
                            <span>Hi, Hizrian</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a>
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#"><i
                                        class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
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
    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('mainContent').classList.toggle('expanded');
        });

        // Submenu toggle
        document.querySelectorAll('.has-submenu > .nav-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const parent = this.parentElement;
                parent.classList.toggle('open');
            });
        });
    </script>
</body>

</html>
