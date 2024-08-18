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

// Ambil informasi pengguna dari database
try {
    $username = $_SESSION['username'];
    $sql_get_user_info = "SELECT * FROM users WHERE username = :username";
    $stmt = $conn->prepare($sql_get_user_info);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user_info = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <title>StudentBiteHunt</title>
    <link rel="stylesheet" href="../user/css/homepage.css">
    <link rel="stylesheet" href="../user/css/header.css">
    <link rel="stylesheet" href="../user/css/footer.css">
    <link rel="stylesheet" href="../user/css/card.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jost:wght@100..900&family=Poppins:wght@100..900&display=swap">
</head>
<body>
    <?php include '../user/header/header.php';?>
    <section class="hero">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-mdb-ride="carousel" data-mdb-interval="3000">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../user/images/icon/1.svg" class="d-block w-100" alt="Food Image 1">
                </div>
                <div class="carousel-item">
                    <img src="../user/images/icon/2.svg" class="d-block w-100" alt="Food Image 2">
                </div>
                <div class="carousel-item">
                    <img src="../user/images/icon/3.svg" class="d-block w-100" alt="Food Image 3">
                </div>
                <button class="carousel-control-prev custom-carousel-control" type="button" data-mdb-target="#heroCarousel" data-mdb-slide="prev">
                    <img src="../user/images/icon/before.png" alt="Previous" class="flip-vertical">
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next custom-carousel-control" type="button" data-mdb-target="#heroCarousel" data-mdb-slide="next">
                    <img src="../user/images/icon/next.png" alt="Next">
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        </div>
        <!-- Controls -->
        <!-- Controls -->
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-mdb-target="#heroCarousel" data-mdb-slide-to="0" class="active"></li>
            <li data-mdb-target="#heroCarousel" data-mdb-slide-to="1"></li>
            <li data-mdb-target="#heroCarousel" data-mdb-slide-to="2"></li>
        </ol>
    </div>
</section>

<div class="overlap-container">
        <div class="search-bar__container">
            <div class="search-bar__unclicked">
                <img src="../user/images/icon/search.png" class="icon" alt="Search Icon">
                <input type="text" class="input" placeholder="Search" id="searchInput">
                <img src="../user/images/icon/x.png" class="icon cross" alt="Cross Icon" id="crossIcon" style="display: none;">
                <button id="cameraButton" aria-label="Camera">
                    <img src="../user/images/icon/camera.png" class="icon" alt="Camera Icon">
                </button>
                <section class="camera-feed" id="cameraFeedSection" style="display: none;">
                    <h2>Camera Feed</h2>
                </section>
            </div>
            <button class="cancel" id="cancelButton" style="display: none;">Cancel</button>
        </div>
</div>


<section class="inspo">
    <h2>Looking for inspo? Start here</h2>
    <div class="inspo-cards">
        <div class="card">
            <a href="../user/fastest.php">
                <img src="../user/images/icon/clock.png" alt="Fastest Food" class="card-image">
                <p>Fastest</p>
            </a>
        </div>
        <div class="card">
            <img src="../user/images/icon/favorites.png" alt="Bestseller" class="card-image">
            <p>Best sellers</p>
        </div>
        <div class="card">
            <a href="../user/cheap.php">
                <img src="../user/images/icon/piggy-bank.png" alt="Budget Meal" class="card-image">
                <p>Budget meal</p>
            </a>
        </div>
        <div class="card">
            <img src="../user/images/icon/love.png" alt="Most Loved" class="card-image">
            <p>Most loved</p>
        </div>
        <div class="card">
            <img src="../user/images/icon/day-and-night.png" alt="24 Hours" class="card-image">
            <p>24 hours</p>
        </div>
        <div class="card">
            <a href="../user/diet.php">
                <img src="../user/images/icon/healthy-eating.png" alt="Healthy-eating" class="card-image">
                <p>For Diet</p>
            </a>
        </div>
        <div class="card">
            <img src="../user/images/icon/discount.png" alt="Discount" class="card-image">
            <p>Pasti Ada Promo</p>
        </div>
    </div>
</section>

<?php include '../user/footer/footer.php'; ?>

<!-- MD Bootstrap JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
<script src="../user/js/homepage.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/coco-ssd"></script>
</body>
</html>
