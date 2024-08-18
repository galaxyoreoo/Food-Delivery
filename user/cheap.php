<?php
// Mulai session
session_start();

// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Periksa apakah session username sudah ada atau belum
if (!isset($_SESSION['username'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: ../user/login.php");
    exit;
}

// Lakukan koneksi ke database
require '../user/connect/connection.php';

// Ambil makanan dengan harga terendah dari database
try {
    $sql_get_cheapest_food = "SELECT * FROM food ORDER BY sell_price ASC LIMIT 10"; // Ambil 10 makanan termurah
    $stmt = $conn->prepare($sql_get_cheapest_food);
    $stmt->execute();
    $cheapest_food = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Meals</title>
    <link rel="stylesheet" href="../user/css/homepage.css">
    <link rel="stylesheet" href="../user/css/header.css">
    <link rel="stylesheet" href="../user/css/footer.css">
    <link rel="stylesheet" href="../user/css/card.css">
    <link rel="stylesheet" href="../user/css/cheap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jost:wght@100..900&family=Poppins:wght@100..900&display=swap">
</head>
<body>
    <?php include '../user/header/header.php';?>

    <section class="budget-meals">
        <h2>Budget Meals</h2>
        <div class="budget-cards">
            <?php foreach ($cheapest_food as $food): ?>
                <?php 
                    $image_url = '../user/images/' . htmlspecialchars($food['image_url']); // Sesuaikan path ke gambar
                ?>
                <div class="card">
                    <img src="<?php echo $image_url; ?>" alt="<?php echo htmlspecialchars($food['name']); ?>" class="card-image">
                    <p><?php echo htmlspecialchars($food['name']); ?></p>
                    <p>Price: <?php echo htmlspecialchars($food['sell_price']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php include '../user/footer/footer.php'; ?>

    <!-- MD Bootstrap JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
    <script src="../user/js/homepage.js"></script>
</body>
</html>
