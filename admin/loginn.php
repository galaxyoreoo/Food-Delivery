<?php
session_start(); // Start session, pastikan ini berada di atas

// Include the database connection file
include '../admin/connect/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk mengambil data pengguna berdasarkan email
    $sql = "SELECT * FROM admin WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        // Verifikasi password
        if (password_verify($password, $hashed_password)) {
            // Password benar, inisialisasi session
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $row['id']; // Ganti 'id' dengan nama kolom yang sesuai di tabel admin

            // Redirect ke halaman dashboard setelah login berhasil
            header("Location: ../admin/dashboard.php");
            exit;
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "Account not found";
    }

    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Page</title>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap'>
  <link rel="stylesheet" href="../admin/asset/css/loginn.css">
</head>
<body>
<div class="screen-1">
  <svg class="logo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="300" height="300" viewbox="0 0 640 480" xml:space="preserve">
    <g transform="matrix(3.31 0 0 3.31 320.4 240.4)">
      <circle style="stroke: rgb(0,0,0); stroke-width: 0; fill: rgb(61,71,133);" cx="0" cy="0" r="40"></circle>
    </g>
    <g transform="matrix(0.98 0 0 0.98 268.7 213.7)">
      <circle style="stroke: rgb(0,0,0); stroke-width: 0; fill: rgb(255,255,255);" cx="0" cy="0" r="40"></circle>
    </g>
    <g transform="matrix(1.01 0 0 1.01 362.9 210.9)">
      <circle style="stroke: rgb(0,0,0); stroke-width: 0; fill: rgb(255,255,255);" cx="0" cy="0" r="40"></circle>
    </g>
    <g transform="matrix(0.92 0 0 0.92 318.5 286.5)">
      <circle style="stroke: rgb(0,0,0); stroke-width: 0; fill: rgb(255,255,255);" cx="0" cy="0" r="40"></circle>
    </g>
    <g transform="matrix(0.16 -0.12 0.49 0.66 290.57 243.57)">
      <polygon style="stroke: rgb(0,0,0); stroke-width: 0; fill: rgb(255,255,255);" points="-50,-50 -50,50 50,50 50,-50 "></polygon>
    </g>
    <g transform="matrix(0.16 0.1 -0.44 0.69 342.03 248.34)">
      <polygon style="stroke: rgb(0,0,0); stroke-width: 0; fill: rgb(255,255,255);" points="-50,-50 -50,50 50,50 50,-50 "></polygon>
    </g>
  </svg>
  <form action="" method="post">
    <div class="email">
      <label for="email">Email Address</label>
      <div class="sec-2">
        <ion-icon name="mail-outline"></ion-icon>
        <input type="email" name="email" placeholder="Username@gmail.com" required/>
      </div>
    </div>
    <div class="password">
      <label for="password">Password</label>
      <div class="sec-2">
        <ion-icon name="lock-closed-outline"></ion-icon>
        <input class="pas" type="password" name="password" placeholder="············" required/>
        <ion-icon class="show-hide" name="eye-outline"></ion-icon>
      </div>
    </div>
    <button class="login" type="submit" href="dashboard.php">Login</button>
    <div class="footer" ><span><a href="signup.php">Signup</a></span></div>
  </form>
</div>
</body>
</html>
