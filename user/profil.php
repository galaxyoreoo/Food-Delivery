<?php
session_start(); // Mulai session untuk menyimpan informasi login

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../login.html"); // Redirect ke halaman login jika belum login
    exit();
}

// Parameter koneksi database
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "food_app";

// Buat koneksi ke database
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data pengguna dari database
$username = $_SESSION['username'];
$sql = "SELECT username, name, email, birthdate, phone, area, room_number FROM users WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
    $birthdate = $row['birthdate'];
    $phone = $row['phone'];
    $area = $row['area'];
    $room_number = $row['room_number'];
} else {
    echo "User not found";
    exit();
}

// Handle update profil lainnya termasuk username, name, phone, area, dan nomor kamar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $name = $_POST['name'];
    $birthdate = $_POST['birthdate'];
    $phone = $_POST['phone'];
    $area = $_POST['area'];
    $room_number = $_POST['room_number'];

    // Validasi data
    $errors = [];
    if (empty($new_username) || empty($name) || empty($birthdate) || empty($phone) || empty($area) || empty($room_number)) {
        $errors[] = "Oh snap! You missed a few things.";
    }

    // Jika terdapat error, tampilkan pesan dan hentikan proses
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger error-msg'>
                    <i class='fa fa-times-circle start-icon'></i> $error
                  </div>";
        }
    } else {
        // Lakukan update profil jika tidak ada error
        $sql_update_profile = "UPDATE users SET username=?, name=?, birthdate=?, phone=?, area=?, room_number=? WHERE username=?";
        $stmt_update_profile = $conn->prepare($sql_update_profile);
        if ($stmt_update_profile === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt_update_profile->bind_param("sssssss", $new_username, $name, $birthdate, $phone, $area, $room_number, $username);
        if (!$stmt_update_profile->execute()) {
            die("Execute failed: " . $stmt_update_profile->error);
        }
        $stmt_update_profile->close();

        // Update session username
        $_SESSION['username'] = $new_username;

        // Tampilkan pesan sukses dan arahkan ke homepage
        echo "<div class='alert alert-success success-msg'>
                <i class='fa fa-check start-icon'></i> Well done! Your profile successfully updated.
              </div>";
        echo "<script>window.location.href = 'homepage.php';</script>";
        exit();
    }
}

// Tutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="profil.css">
    <script src="../js/profil.js" defer></script>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <div class="profile-pic">
                <!-- Profile picture display removed -->
            </div>
            <nav>
                <ul>
                    <!-- Navigation links -->
                </ul>
            </nav>
        </div>
        <div class="main-content">
            <h2>Profil Saya</h2>
            <p>Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun</p>
            <form action="profile.php" method="post" id="profile-form">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">

                <label for="name">Your name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" disabled>

                <label for="phone">Telephone</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">

                <p>Area</p>
                <div class="custom-select">
                    <button class="select-button" type="button" aria-haspopup="listbox" aria-expanded="false"
                        aria-controls="select-dropdown">
                        <span class="selected-value"><?php echo htmlspecialchars($area); ?></span>
                        <span class="arrow"></span>
                    </button>
                    <ul class="select-dropdown" id="select-dropdown" role="listbox">
                        <li role="option">
                            <input type="radio" id="GedungN" name="area" value="Gedung N"
                                <?php if ($area === "Gedung N") echo "checked"; ?>>
                            <label for="GedungN">Gedung N</label>
                        </li>
                        <li role="option">
                            <input type="radio" id="GedungS" name="area" value="Gedung S"
                                <?php if ($area === "Gedung S") echo "checked"; ?>>
                            <label for="GedungS">Gedung S</label>
                        </li>
                        <li role="option">
                            <input type="radio" id="GedungH" name="area" value="Gedung H"
                                <?php if ($area === "Gedung H") echo "checked"; ?>>
                            <label for="GedungH">Gedung H</label>
                        </li>
                        <li role="option">
                            <input type="radio" id="GedungG" name="area" value="Gedung G"
                                <?php if ($area === "Gedung G") echo "checked"; ?>>
                            <label for="GedungG">Gedung G</label>
                        </li>
                        <li role="option">
                            <input type="radio" id="Pavillion" name="area" value="Pavillion"
                                <?php if ($area === "Pavillion") echo "checked"; ?>>
                            <label for="Pavillion">Pavillion</label>
                        </li>
                        <li role="option">
                            <input type="radio" id="LandedHouse" name="area" value="Landed House"
                                <?php if ($area === "Landed House") echo "checked"; ?>>
                            <label for="LandedHouse">Landed House</label>
                        </li>
                    </ul>
                </div>

                <label for="room_number">Nomor Kamar</label>
                <input type="text" id="room_number" name="room_number" value="<?php echo htmlspecialchars($room_number); ?>">

                <div class="error-messages">
                    <?php
                    if (!empty($errors)) {
                        foreach ($errors as $error) {
                            echo "<p>$error</p>";
                        }
                    }
                    ?>
                </div> <!-- Container untuk pesan kesalahan -->

                <button type="submit">Simpan</button>
            </form>
        </div>
    </div>

    <script>
        // JavaScript untuk menu pilihan kustom
        const customSelect = document.querySelector(".custom-select");
        const selectBtn = document.querySelector(".select-button");
        const selectedValue = document.querySelector(".selected-value");
        const optionsList = document.querySelectorAll(".select-dropdown li");

        // Tambahkan event click ke tombol pilihan
        selectBtn.addEventListener("click", () => {
            customSelect.classList.toggle("active");
            selectBtn.setAttribute("aria-expanded", customSelect.class.contains("active") ? "true" : "false");
        });

        // Tambahkan event listener untuk setiap pilihan
        optionsList.forEach((option) => {
            option.addEventListener("click", function() {
                selectedValue.textContent = this.textContent.trim(); // Perbarui teks nilai yang dipilih
                customSelect.classList.remove("active");

                // Perbarui nilai input tersembunyi (jika diperlukan)
                const radioInput = this.querySelector('input[type="radio"]');
                if (radioInput) {
                    radioInput.checked = true;
                }

                // Lakukan tindakan tambahan jika diperlukan, seperti mengirimkan formulir
                // Contoh: document.querySelector("form").submit();
            });
        });
    </script>
</body>

</html>
