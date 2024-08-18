<?php
// Start session
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
require '../user/connect/connection.php';

try {
    // Fetch restaurants ordered by opening time
    $sql_get_restaurants_by_opening = "
        SELECT r.resto_name, r.country, r.image_url, r.category_id, c.cat_name, o.open_time
        FROM restaurants r
        LEFT JOIN categories c ON r.category_id = c.category_id
        LEFT JOIN operational_hours o ON r.restaurant_id = o.restaurant_id
        WHERE o.day_of_week = 'Monday'  -- Assumption: Filtering by Monday for example
        ORDER BY o.open_time ASC
    ";
    $stmt = $conn->prepare($sql_get_restaurants_by_opening);
    $stmt->execute();

    $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fastest Opening Restaurants</title>
    <link rel="stylesheet" href="../user/css/fastest.css">
    <link rel="stylesheet" href="../user/css/resto_menu.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jost:wght@100..900&family=Poppins:wght@100..900&display=swap">
</head>
<body>
    <?php require '../user/header/header.php'; ?>
    <div class="menu-container">
        <?php if (!empty($restaurants)): ?>
            <?php foreach ($restaurants as $restaurant): ?>
                <div class="menu-card">
                    <img src="../user/images/<?php echo htmlspecialchars($restaurant['image_url']); ?>" alt="<?php echo htmlspecialchars($restaurant['resto_name']); ?>">
                    <div class="menu-info">
                        <h3><?php echo htmlspecialchars($restaurant['resto_name']); ?></h3>
                        <p class="category"><?php echo htmlspecialchars($restaurant['cat_name']); ?></p>
                        <p>Opens at: <?php echo htmlspecialchars($restaurant['open_time']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No restaurants available.</p>
        <?php endif; ?>
    </div>
    <?php require '../user/footer/footer.php'; ?>
</body>
</html>
