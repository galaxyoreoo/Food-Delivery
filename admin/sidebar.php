<?php
// Memasukkan file koneksi
include '../admin/connect/connect.php';

// Menentukan halaman aktif
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collapsible Sidebar</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="../admin/asset/css/sidebar.css" rel="stylesheet">
</head>
<body>
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
            <div class="sidebar-logo">
                <img src="../admin/asset/images/logo.png" alt="Logo"> <!-- Tambahkan logo di sini -->
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Home</span>
                    </h6>
                    <a class="nav-link <?php echo $currentPage == 'dashboard.php' ? 'active-page' : ''; ?>" href="../admin/dashboard.php">
                        <i class="fas fa-tachometer-alt fa-lg"></i> <!-- Ikon Dashboard -->
                        Dashboard <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Log</span>
                    </h6>
                    <a class="nav-link <?php echo $currentPage == 'users.php' ? 'active-page' : ''; ?>" href="../admin/users.php">
                        <i class="fas fa-users fa-lg"></i> <!-- Ikon Users -->
                        Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $currentPage == 'restaurants.php' ? 'active-page' : ''; ?>" href="#" data-toggle="collapse" data-target="#homeSubmenu" aria-expanded="false">
                        <i class="fas fa-utensils fa-2x"></i> <!-- Ikon Restaurants -->
                        Restaurants
                    </a>
                    <ul id="homeSubmenu" class="collapse nav flex-column ml-3">
                        <li class="nav-item">
                            <a class="nav-link" href="../admin/all-resto.php">All Restaurant</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">All Category</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Add Restaurant</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $currentPage == 'account.php' ? 'active-page' : ''; ?>" href="#">
                        <i class="fas fa-user fa-lg"></i> <!-- Ikon Account -->
                        Account
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace()
    </script>
</body>
</html>
