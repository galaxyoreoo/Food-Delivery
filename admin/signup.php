<?php
// Menghubungkan ke database
include '../admin/connect/connect.php';

// Variabel untuk menampilkan notifikasi
$notification = '';

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi password
    if ($password !== $confirm_password) {
        $notification = "Passwords do not match.";
    } else {
        // Enkripsi password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Siapkan query SQL untuk memasukkan data ke tabel admin
        $sql = "INSERT INTO admin (email, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $email, $hashed_password);

        // Eksekusi query
        if (mysqli_stmt_execute($stmt)) {
            $notification = "New record created successfully";
        } else {
            $notification = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        // Tutup statement
        mysqli_stmt_close($stmt);
    }

    // Tutup koneksi
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap'>
    <link rel="stylesheet" href="../admin/asset/css/loginn.css">
    <script>
        // Function untuk menampilkan popup notifikasi
        function showNotification(message) {
            alert(message);
        }
    </script>
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
            <label for="email">Enter email</label>
            <div class="sec-2">
                <ion-icon name="mail-outline"></ion-icon>
                <input type="email" name="email" placeholder="Username@gmail.com" required/>
            </div>
        </div>
        <div class="password">
            <label for="password">Enter Password</label>
            <div class="sec-2">
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input class="pas" type="password" name="password" placeholder="············" required/>
                <ion-icon class="show-hide" name="eye-outline"></ion-icon>
            </div>
        </div>
        <div class="password">
            <label for="confirm_password">Confirm Password</label>
            <div class="sec-2">
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input class="pas" type="password" name="confirm_password" placeholder="············" required/>
                <ion-icon class="show-hide" name="eye-outline"></ion-icon>
            </div>
        </div>
        <button class="login" type="submit">Signup</button>
        <div class="footer" ><span><a href="loginn.php">Login</a></span></div>
    </form>
</div>

<?php
// Menampilkan popup notifikasi jika $notification tidak kosong
if (!empty($notification)) {
    echo '<script>showNotification("' . $notification . '")</script>';
}
?>

</body>
</html>
