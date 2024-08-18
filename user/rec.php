<?php
// Start session
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if session username is set
if (!isset($_SESSION['username'])) {
    header("Location: ../Login/login.php");
    exit;
}

// Database connection
require '../user/connect/connection.php';

// Get user info from database
$username = $_SESSION['username'];
$sql_get_user_info = "SELECT * FROM users WHERE username = :username";
$stmt = $conn->prepare($sql_get_user_info);
$stmt->bindParam(':username', $username);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = $row['name'];
    $email = $row['email'];
    $phone = $row['phone'];
} else {
    echo "No user data found.";
}

// Get restaurants data from database with operational hours info
$sql_get_restaurants = "
    SELECT r.restaurant_id, r.resto_name, r.country, r.image_url,
           oh.day_of_week, oh.open_time, oh.close_time
    FROM restaurants r
    LEFT JOIN operational_hours oh ON r.restaurant_id = oh.restaurant_id
";
$stmt = $conn->prepare($sql_get_restaurants);
$stmt->execute();
$restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($restaurants)) {
    echo "No restaurants found.";
}

// Close database connection
$conn = null;
?>
<?php require '../user/header/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentBiteHunt</title>
    <link rel="stylesheet" href="../user/css/rec.css">
    <link rel="stylesheet" href="../user/css/header.css">
    <link rel="stylesheet" href="../user/css/footer.css">
    <link rel="stylesheet" href="../user/css/card.css">
    <!-- MD Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jost:wght@100..900&family=Poppins:wght@100..900&display=swap">
</head>
<body>
    <div class="container">
        <h1>See All Resto</h1>
        <div class="restaurants">
            <?php if (!empty($restaurants)): ?>
                <?php 
                // Initialize an empty array to store processed restaurant data
                $processed_restaurants = [];
                
                foreach ($restaurants as $restaurant): 
                    // Check if this restaurant has already been processed
                    if (!isset($processed_restaurants[$restaurant['resto_name']])) {
                        // Add the restaurant to the processed array
                        $processed_restaurants[$restaurant['resto_name']] = [
                            'restaurant_id' => $restaurant['restaurant_id'],
                            'resto_name' => htmlspecialchars($restaurant['resto_name']),
                            'country' => htmlspecialchars($restaurant['country']),
                            'image_url' => htmlspecialchars($restaurant['image_url']),
                            'hours' => []
                        ];
                    }
                    
                    // Add the operational hours for this restaurant
                    if (!empty($restaurant['day_of_week'])) {
                        $processed_restaurants[$restaurant['resto_name']]['hours'][] = htmlspecialchars($restaurant['day_of_week']) . ": " .
                            htmlspecialchars($restaurant['open_time']) . " - " .
                            htmlspecialchars($restaurant['close_time']);
                    }
                endforeach;
                
                // Display the processed restaurants
                foreach ($processed_restaurants as $restaurant):
                ?>
                <a href="resto_menu.php?id=<?php echo $restaurant['restaurant_id']; ?>">
                    <div class="card">
                        <img class="card-image" src="../user/images/<?php echo $restaurant['image_url']; ?>" alt="<?php echo $restaurant['resto_name']; ?>">
                        <div class="info">
                            <h2><?php echo $restaurant['resto_name']; ?></h2>
                            <p><?php echo $restaurant['country']; ?></p>
                            <p>
                                <?php
                                if (!empty($restaurant['hours'])) {
                                    echo implode(' • ', $restaurant['hours']);
                                } else {
                                    echo "Operational hours not available";
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No restaurants available.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php require '../user/footer/footer.php'; ?>
    <!-- MD Bootstrap JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
    <script src="../user/js/homepage.js"></script>
</body>
</html>
