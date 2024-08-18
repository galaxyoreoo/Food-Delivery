<?php
include '../admin/connect/connect.php';

// Mengambil jumlah restoran
$restaurants = $conn->query("SELECT COUNT(*) AS count FROM restaurants")->fetch_assoc()['count'];

// Mengambil jumlah makanan (dishes)
$dishes = $conn->query("SELECT COUNT(*) AS count FROM food")->fetch_assoc()['count'];

// Mengambil jumlah pengguna
$users = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];

// Mengambil jumlah total pesanan (anggap tabelnya orders)
$total_orders = $conn->query("SELECT COUNT(*) AS count FROM orders")->fetch_assoc()['count'];

// Mengambil jumlah kategori restoran
$restro_categories = $conn->query("SELECT COUNT(*) AS count FROM categories")->fetch_assoc()['count'];

// Mengambil jumlah pesanan yang sedang diproses
$processing_orders = $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status = 'processing'")->fetch_assoc()['count'];

// Mengambil jumlah pesanan yang sudah diantar
$delivered_orders = $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status = 'delivered'")->fetch_assoc()['count'];

// Mengambil jumlah pesanan yang dibatalkan
$cancelled_orders = $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status = 'cancelled'")->fetch_assoc()['count'];

// Mengambil total penghasilan dari pesanan yang diantar
$total_earnings = $conn->query("SELECT SUM(total_price) AS total FROM orders WHERE status = 'delivered'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../admin/asset/css/dashboard.css">
</head>
<body>
    <?php include '../admin/sidebar.php'; ?>
    <div class="dashboard">
        <h1>Admin Dashboard</h1>
        <div class="dashboard-container">
            <!-- Dashboard Items -->
            <div class="dashboard-item">
                <div class="icon">
                    <img src="../admin/asset/images/restaurant.png" alt="Restaurant">
                </div>
                <div class="info">
                    <h3><?php echo $restaurants; ?></h3>
                    <p>Restaurants</p>
                </div>
            </div>
            <div class="dashboard-item">
                <div class="icon">
                    <img src="../admin/asset/images/cutlery.png" alt="Total Orders">
                </div>
                <div class="info">
                    <h3><?php echo $dishes; ?></h3>
                    <p>Dishes</p>
                </div>
            </div>
            <div class="dashboard-item">
                <div class="icon">
                    <img src="../admin/asset/images/group.png" alt="Users">
                </div>
                <div class="info">
                    <h3><?php echo $users; ?></h3>
                    <p>Users</p>
                </div>
            </div>
            <div class="dashboard-item">
                <div class="icon">
                    <img src="../admin/asset/images/trolley.png" alt="Total Orders">
                </div>
                <div class="info">
                    <h3><?php echo $total_orders; ?></h3>
                    <p>Total Orders</p>
                </div>
            </div>
            <div class="dashboard-item">
                <div class="icon">
                    <img src="../admin/asset/images/options.png" alt="Resto Categories">
                </div>
                <div class="info">
                    <h3><?php echo $restro_categories; ?></h3>
                    <p>Restro Categories</p>
                </div>
            </div>
            <div class="dashboard-item">
                <div class="icon">
                    <img src="../admin/asset/images/hourglass.png" alt="Processing Order">
                </div>
                <div class="info">
                    <h3><?php echo $processing_orders; ?></h3>
                    <p>Processing Orders</p>
                </div>
            </div>
            <div class="dashboard-item">
                <div class="icon">
                    <img src="../admin/asset/images/check-mark.png" alt="Delivered Orders">
                </div>
                <div class="info">
                    <h3><?php echo $delivered_orders; ?></h3>
                    <p>Delivered Orders</p>
                </div>
            </div>
            <div class="dashboard-item">
                <div class="icon">
                    <img src="../admin/asset/images/cross.png" alt="Cancelled Orders">
                </div>
                <div class="info">
                    <h3><?php echo $cancelled_orders; ?></h3>
                    <p>Cancelled Orders</p>
                </div>
            </div>
            <div class="dashboard-item">
                <div class="icon">
                    <img src="../admin/asset/images/money.png" alt="Total Earnings">
                </div>
                <div class="info">
                    <h3><?php echo $total_earnings; ?></h3>
                    <p>Total Earnings</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
