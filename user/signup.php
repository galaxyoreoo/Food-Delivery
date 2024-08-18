<?php
// Menghubungkan ke database
include('../user/connect/connection.php');

session_start();

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $birthday = $_POST['birthday'];
    $phone = $_POST['phone'];
    $room_number = $_POST['room_number'];
    $area = $_POST['area'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        try {
            // Check if username already exists
            $stmt_check_username = $conn->prepare("SELECT * FROM users WHERE username = :username");
            $stmt_check_username->bindParam(':username', $username);
            $stmt_check_username->execute();

            if ($stmt_check_username->rowCount() > 0) {
                $error = "Username already taken. Please try another username.";
            } else {
                // Insert user into database
                $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Encrypt the password
                $stmt_insert_user = $conn->prepare("INSERT INTO users (name, email, username, password, birthday, phone, room_number, area) VALUES (:name, :email, :username, :password, :birthday, :phone, :room_number, :area)");
                $stmt_insert_user->bindParam(':name', $name);
                $stmt_insert_user->bindParam(':email', $email);
                $stmt_insert_user->bindParam(':username', $username);
                $stmt_insert_user->bindParam(':password', $hashed_password);
                $stmt_insert_user->bindParam(':birthday', $birthday);
                $stmt_insert_user->bindParam(':phone', $phone);
                $stmt_insert_user->bindParam(':room_number', $room_number);
                $stmt_insert_user->bindParam(':area', $area);

                if ($stmt_insert_user->execute()) {
                    // Registration successful, store login session
                    $_SESSION['username'] = $username;
                    $success = "Registration successful! Redirecting to homepage...";
                    header("Refresh: 3; url=../user/homepage/homepage.php");
                    exit();
                } else {
                    $error = "Error: Could not insert user data.";
                }
            }
        } catch(PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="../user/css/signup.css">
</head>
<body>
    <div class="outer-container">
        <div class="container">
            <div class="signup-form">
                <h2>Join Us Today!</h2>
                <p>Let's find your delicious food.</p>
                <?php if ($error): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>
                <?php if ($success): ?>
                    <p style="color: green;"><?php echo $success; ?></p>
                <?php endif; ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm();">
                    <div class="user-form">
                        <input type="text" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                        <label for="name">What's your name?</label>
                    </div>

                    <div class="user-form">
                        <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                        <label for="email">Enter your email</label>
                    </div>

                    <div class="user-form">
                        <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                        <label for="username">Enter Username</label>
                    </div>

                    <div class="user-form">
                        <input type="password" id="password" name="password" required>
                        <label for="password">Enter Password</label>
                    </div>

                    <div class="user-form">
                        <input type="password" id="confirm_password" name="confirm_password" required>
                        <label for="confirm_password">Confirm Password</label>
                    </div>

                    <div class="user-form">
                        <input type="date" id="birthday" name="birthday" value="<?php echo isset($_POST['birthday']) ? htmlspecialchars($_POST['birthday']) : ''; ?>" required>
                        <label for="birthday">Enter your birthday</label>
                    </div>

                    <div class="user-form">
                        <input type="text" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required>
                        <label for="phone">Enter your phone number</label>
                    </div>

                    <div class="user-form">
                        <input type="text" id="room_number" name="room_number" value="<?php echo isset($_POST['room_number']) ? htmlspecialchars($_POST['room_number']) : ''; ?>" required>
                        <label for="room_number">Enter your room number</label>
                    </div>

                    <div class="user-form">
                        <select id="area" name="area" required>
                            <option value="" disabled <?php echo !isset($_POST['area']) ? 'selected' : ''; ?>></option>
                            <option value="Building N" <?php echo (isset($_POST['area']) && $_POST['area'] == 'Building N') ? 'selected' : ''; ?>>Building N</option>
                            <option value="Building S" <?php echo (isset($_POST['area']) && $_POST['area'] == 'Building S') ? 'selected' : ''; ?>>Building S</option>
                            <option value="Building G" <?php echo (isset($_POST['area']) && $_POST['area'] == 'Building G') ? 'selected' : ''; ?>>Building G</option>
                            <option value="Building H" <?php echo (isset($_POST['area']) && $_POST['area'] == 'Building H') ? 'selected' : ''; ?>>Building H</option>
                            <option value="Paviliun" <?php echo (isset($_POST['area']) && $_POST['area'] == 'Paviliun') ? 'selected' : ''; ?>>Paviliun</option>
                            <option value="Landed House" <?php echo (isset($_POST['area']) && $_POST['area'] == 'Landed House') ? 'selected' : ''; ?>>Landed House</option>
                        </select>
                        <label for="area">Select Area</label>
                    </div>
                    <button type="submit" class="sign-up-btn">Sign Up</button>
                </form>
            </div> 
            
            <div class="signup-illustration">
                <div class="register-link">
                    <p>Already a member?</p>
                    <a href="../user/login.php" class="register-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        Sign In Now!
                    </a>
                </div>
                <img src="../user/images/icon/signup.svg" alt="Illustration">
            </div>
        </div>
    </div>

    <script src="..user/js/signup.js"></script>
</body>
</html>
