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

// Ambil makanan dengan kalori terendah
try {
    $sql_get_lowest_calories = "SELECT * FROM food ORDER BY calories ASC LIMIT 10";
    $stmt = $conn->prepare($sql_get_lowest_calories);
    $stmt->execute();
    $diet_foods = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>For Diet - StudentBiteHunt</title>
    <link rel="stylesheet" href="../user/css/homepage.css">
    <link rel="stylesheet" href="../user/css/diet.css">
    <link rel="stylesheet" href="../user/css/fastest.css">
    <link rel="stylesheet" href="../user/css/card.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jost:wght@100..900&family=Poppins:wght@100..900&display=swap">
</head>
<body>
    <?php include '../user/header/header.php';?>
    <section class="diet">
        <div class="container">
            <h2>Low-Calorie Foods for Your Diet</h2>
            <div class="food-list">
                <?php foreach ($diet_foods as $food): ?>
                    <div class="food-card">
                    <img src="../user/images/<?php echo htmlspecialchars($food['image_url']); ?>" alt="<?php echo htmlspecialchars($food['name']); ?>" class="food-image">
                        <div class="food-info">
                            <h3><?php echo htmlspecialchars($food['name']); ?></h3>
                            <p>Calories: <?php echo htmlspecialchars($food['calories']); ?></p>
                            <p>Price: <?php echo htmlspecialchars($food['sell_price']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php include '../user/footer/footer.php'; ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
</body>
</html>
