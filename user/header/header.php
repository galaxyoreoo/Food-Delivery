<?php
// Start session
require '../user/connect/connection.php';

// Check if session username exists
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to login page
    header("Location: ../user/Login/login.php");
    exit;
}

// Include connection.php for database connection
$username = $_SESSION['username'];
$sql_get_user_info = $conn->prepare("SELECT * FROM users WHERE username=:username");
$sql_get_user_info->bindParam(':username', $username);
$sql_get_user_info->execute();

$user = $sql_get_user_info->fetch(PDO::FETCH_ASSOC);
if ($user) {
    $name = $user['name'];
    $email = $user['email'];
    $phone = $user['phone'];
} else {
    echo "No user data found.";
}

// Determine the active page
$activePage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../user/css/header.css">
    <title>Header</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="../user/images/icon/logo.png" alt="SBH Logo">
        </div>
        <nav>
            <ul>
                <li><a href="../user/homepage.php" <?php if ($activePage == 'homepage.php') echo 'class="active"'; ?>>Home</a></li>
                <li><a href="../user/rec.php" <?php if ($activePage == 'rec.php') echo 'class="active"'; ?>>Recommendations</a></li>
            </ul>
        </nav>
        <div class="icons">
            <img src="../user/images/icon/trolley.png" class="icon trolley-icon" alt="Trolley">
            <img src="../user/images/icon/user.png" class="icon user-icon" alt="User" id="user-icon">
            <div class="dropdown-menu" id="dropdown-menu">
                <div class="user-info">
                    <p><?php echo htmlspecialchars($name); ?></p>
                    <div class="user-data">
                        <p><?php echo htmlspecialchars($email); ?></p>
                        <p><?php echo htmlspecialchars($phone); ?></p>
                    </div>
                </div>
                <div class="dropdown-links">
                    <a href="#">Orders</a>
                    <a href="../user/add_resto.php">Open your resto</a>
                    <a href="../user/add_menu.php">Add Menu</a>
                    <a href="../user/login.php">Log out</a>
                </div>
            </div>
        </div>
    </header>
    <script src="../user/js/header.js"></script>
</body>
</html>

