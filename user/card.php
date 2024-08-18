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
    // Fetch menu items for the restaurant
    $sql_get_menu_items = "
        SELECT f.food_id, f.name, f.image_url, f.sell_price, f.description
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
    <title>Menu</title>
    <link rel="stylesheet" href="../user/css/card.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jost:wght@100..900&family=Poppins:wght@100..900&display=swap">
</head>
<body>
    <?php require '../user/header/header.php'; ?>
    <div class="menu-container">
        <?php if (!empty($menu_items)): ?>
            <?php foreach ($menu_items as $item): ?>
                <div class="menu-card">
                    <img src="../user/images/<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                    <div class="menu-info">
                        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p><?php echo htmlspecialchars($item['description']); ?></p>
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
