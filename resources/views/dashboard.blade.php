<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        #sidebar {
            transition: all 0.3s;
            width: 250px;
        }

        #sidebar.closed {
            width: 0;
            overflow: hidden;
        }

        #content {
            transition: all 0.3s;
            margin-left: 250px;
        }

        #content.full {
            margin-left: 0;
        }

        .sidebar-header {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            padding: 1rem 0;
        }

        .sidebar-menu {
            padding: 1rem;
        }

        .sidebar-menu li {
            margin-bottom: 1rem;
        }

        .dropdown-menu {
            right: 0;
            left: auto;
        }
    </style>
</head>
<body class="bg-light">

    <!-- Sidebar -->
    <div id="sidebar" class="bg-dark text-white vh-100 position-fixed">
        <div class="sidebar-header">
            <img src="https://via.placeholder.com/100" alt="Logo" class="rounded-circle" width="100">
            <h4>My Dashboard</h4>
        </div>
        <div class="px-3">
            <input type="text" class="form-control mb-3" placeholder="Search...">
        </div>
        <ul class="list-unstyled sidebar-menu px-3">
            <li><a href="#" class="text-white text-decoration-none">Home</a></li>
            <li><a href="#" class="text-white text-decoration-none">Profile</a></li>
            <li><a href="#" class="text-white text-decoration-none">Settings</a></li>
            <li><a href="#" class="text-white text-decoration-none">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div id="content" class="w-100">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4">
            <button class="btn btn-outline-primary me-3" id="toggleSidebar">☰</button>
            <span class="navbar-brand mb-0 h1">Dashboard</span>

            <div class="ms-auto dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="settingsMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    ⚙
                </button>
                <ul class="dropdown-menu" aria-labelledby="settingsMenu">
                    <li><a class="dropdown-item" href="#">Account</a></li>
                    <li><a class="dropdown-item" href="#">Privacy</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
            </div>
        </nav>

        <!-- Placeholder Content -->
        <div class="container mt-4">
            <h1>Welcome to the Dashboard</h1>
            <p>Content goes here...</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Sidebar Toggle Script -->
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            sidebar.classList.toggle('closed');
            content.classList.toggle('full');
        });
    </script>
</body>
</html>
