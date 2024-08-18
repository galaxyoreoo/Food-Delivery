<?php
// Start session
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
require '../user/connect/connection.php';

// Check if 'id' parameter is present in the URL
if (!isset($_GET['id'])) {
    die('Restaurant ID not specified.');
}

$restaurant_id = $_GET['id'];

try {
    // Fetch restaurant details
    $sql_get_restaurant_details = "
        SELECT r.resto_name, r.country, r.image_url, r.category_id, c.cat_name
        FROM restaurants r
        LEFT JOIN categories c ON r.category_id = c.category_id
        WHERE r.restaurant_id = :restaurant_id
    ";
    $stmt = $conn->prepare($sql_get_restaurant_details);
    $stmt->bindParam(':restaurant_id', $restaurant_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        die('Restaurant not found.');
    }
} catch (PDOException $e) {
    die('Error: ' . $e->getMessage());
}

// Fetch operational hours
try {
    $sql_get_operational_hours = "
        SELECT day_of_week, open_time, close_time
        FROM operational_hours
        WHERE restaurant_id = :restaurant_id
    ";
    $stmt = $conn->prepare($sql_get_operational_hours);
    $stmt->bindParam(':restaurant_id', $restaurant_id);
    $stmt->execute();

    $operational_hours = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error: ' . $e->getMessage());
}

// Fetch menu items for the restaurant
try {
    $sql_get_menu_items = "
        SELECT f.food_id, f.name, f.image_url, f.sell_price, f.description, f.calories, f.protein, f.carbohydrate
        FROM food f
        WHERE f.restaurant_id = :restaurant_id
    ";
    $stmt = $conn->prepare($sql_get_menu_items);
    $stmt->bindParam(':restaurant_id', $restaurant_id);
    $stmt->execute();

    $menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($restaurant['resto_name']); ?></title>
        <link rel="stylesheet" href="../user/css/resto_menu.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jost:wght@100..900&family=Poppins:wght@100..900&display=swap">
    </head>
<body>
    <?php require '../user/header/header.php'; ?>
    <div class="restaurant-details">
        <div class="breadcrumb">
            Home / <?php echo htmlspecialchars($restaurant['country']); ?> / <?php echo htmlspecialchars($restaurant['resto_name']); ?>
        </div>
        <div class="restaurant-header">
            <img src="../user/images/<?php echo htmlspecialchars($restaurant['image_url']); ?>" alt="<?php echo htmlspecialchars($restaurant['resto_name']); ?>">
            <div class="restaurant-info">
                <h1><?php echo htmlspecialchars($restaurant['resto_name']); ?></h1>
                <span class="super-partner">Super Partner</span>
                <p class="category"><?php echo htmlspecialchars($restaurant['cat_name']); ?></p>
                <div class="ratings">
                    <span>
                        <div class="icon-wrapper">
                            <img class="star-icon" src="../user/images/icon/star.png" alt="Rating">
                            <div>4.9</div>
                        </div>
                    </span>
                    <span>
                        <div class="icon-wrapper">
                            <img class="location-icon" src="../user/images/icon/location.png" alt="Distance">
                            <div>0.49 km</div>
                        </div>
                    </span>
                    <span>
                        <div class="icon-wrapper">
                            <img class="price-icon" src="../user/images/icon/price.png" alt="Price">
                            <div>$$$</div>
                        </div>
                    </span>
                    <span>
                        <div class="icon-wrapper">
                            <img class="taste-icon" src="../user/images/icon/taste.png" alt="Great taste">
                            <div>100+ ratings</div>
                        </div>
                    </span>
                    <span>
                        <div class="icon-wrapper">
                            <img class="fresh-icon" src="../user/images/icon/fresh.png" alt="Freshly made">
                            <div>100+ ratings</div>
                        </div>
                    </span>
                    <span>
                        <div class="icon-wrapper">
                            <img class="packaging-icon" src="../user/images/icon/packaging.png" alt="Proper packaging">
                            <div>100+ ratings</div>
                        </div>
                    </span>
                </div>
            </div>
        </div>
        <div class="operational-hours">
            <h2>Operational Hours</h2>
            <ul>
                <?php if (!empty($operational_hours)): ?>
                    <?php foreach ($operational_hours as $hours): ?>
                        <li><?php echo htmlspecialchars($hours['day_of_week']) . ": " . htmlspecialchars($hours['open_time']) . " - " . htmlspecialchars($hours['close_time']); ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Operational hours not available</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="menu-container">
        <?php if (!empty($menu_items)): ?>
            <?php foreach ($menu_items as $item): ?>
                <div class="menu-card">
                    <img src="../user/images/<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                    <div class="menu-info">
                        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p><?php echo htmlspecialchars($item['description']); ?></p>
                        <p>Calories: <?php echo htmlspecialchars($item['calories']); ?> kcal</p>
                        <p>Protein: <?php echo htmlspecialchars($item['protein']); ?> g</p>
                        <p>Carbohydrates: <?php echo htmlspecialchars($item['carbohydrate']); ?> g</p>
                        <div class="price-add">
                            <span><?php echo htmlspecialchars(number_format($item['sell_price'], 0, ',', '.')); ?> IDR</span>
                            <button>Add</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No menu items available for this restaurant.</p>
        <?php endif; ?>
    </div>

    <?php require '../user/footer/footer.php'; ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
</body>
</html>
