<?php
// Menghubungkan ke database
include('../user/connect/connection.php');

session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Menyiapkan dan mengeksekusi query untuk mencari user
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Jika user ditemukan, verifikasi password
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            // Redirect ke halaman homepage
            header("Location: ../user/homepage.php");
            exit();
        } else {
            $error = "Username atau password salah.";
        }
    } catch(PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../user/css/login.css">
</head>
<body>
    <div class="outer-container">
        <div class="container">
            <div class="illustration">
                <div class="register-link">
                    <p>Not a member?</p>
                    <a href="../user/signup.php" class="register-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        Register Now!
                    </a>
                </div>
                <img src="../user/images/icon/login.svg" alt="Illustration">
            </div>
            <div class="login-form">
                <h2>Hello Again!</h2>
                <p>Welcome back you've been missed!</p>
                <?php if ($error): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>
                <form action="login.php" method="POST">
                    <div class="user-form">
                        <input type="text" id="username" name="username" required>
                        <label for="username">Enter Username</label>
                    </div>

                    <div class="user-form">
                        <input type="password" id="password" name="password" required>
                        <label for="password">Enter Password</label>
                    </div>
                    <button type="submit" class="sign-in-btn">Sign In</button>
                </form>
            </div>            
        </div>
    </div>
    <script src="..user/js/login.js"></script>
</body>
</html>
