<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu</title>
    <link rel="stylesheet" href="../user/css/add_menu.css">
    <script src="../user/js/add_menu.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
</head>
<body>
    <h1>Tambah Menu Baru</h1>
    <?php
    include '../user/connect/connection.php';

    // Fetch restaurant list from database
    $stmt = $conn->prepare("SELECT restaurant_id, resto_name FROM restaurants");
    $stmt->execute();
    $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $restaurant_id = $_POST['restaurant_id'];
        $name = $_POST['name'];
        $calories = $_POST['calories'];
        $description = $_POST['description'];
        $protein = $_POST['protein'];
        $carbohydrate = $_POST['carbohydrate'];
        $real_price = $_POST['real_price'];
        $sell_price = $_POST['sell_price'];

        // Handle file upload
        $target_dir = "C:/xampp/htdocs/ProjekNLUG/user/images/";
        $target_file = $target_dir . basename($_FILES["image_url"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image_url"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "<script>showNotification('File is not an image.');</script>";
            $uploadOk = 0;
        }

        // Check if file already exists and create a unique name if it does
        if (file_exists($target_file)) {
            $target_file = $target_dir . uniqid() . '.' . $imageFileType;
        }

        // Check file size
        if ($_FILES["image_url"]["size"] > 500000) {
            echo "<script>showNotification('Sorry, your file is too large.');</script>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "<script>showNotification('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "<script>showNotification('Sorry, your file was not uploaded.');</script>";
        } else {
            if (move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file)) {
                echo "<script>showNotification('The file " . htmlspecialchars(basename($_FILES["image_url"]["name"])) . " has been uploaded.');</script>";
            } else {
                echo "<script>showNotification('Sorry, there was an error uploading your file.');</script>";
            }
        }

        // Save the form data into the database
        $stmt = $conn->prepare("INSERT INTO food (restaurant_id, name, calories, image_url, description, protein, carbohydrate, real_price, sell_price)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$restaurant_id, $name, $calories, basename($target_file), $description, $protein, $carbohydrate, $real_price, $sell_price])) {
            echo "<script>showNotification('New menu added successfully');</script>";
        } else {
            echo "<script>showNotification('Error: " . implode(" ", $stmt->errorInfo()) . "');</script>";
        }
    }
    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <div>
            <label for="restaurant_id">Nama Restaurant</label>
            <select id="restaurant_id" name="restaurant_id" required>
                <option value="">Pilih Restaurant</option>
                <?php foreach ($restaurants as $restaurant): ?>
                    <option value="<?php echo htmlspecialchars($restaurant['restaurant_id']); ?>">
                        <?php echo htmlspecialchars($restaurant['resto_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="name">Nama Menu</label>
            <input type="text" id="name" name="name" oninput="updateForm()" required>
        </div>
        <div>
            <label for="calories">Kalori (cal)</label>
            <input type="number" id="calories" name="calories" required>
        </div>
        <div>
            <label for="protein">Protein (g)</label>
            <input type="number" id="protein" name="protein" step="0.1" required>
        </div>
        <div>
            <label for="carbohydrate">Karbohidrat (g)</label>
            <input type="number" id="carbohydrate" name="carbohydrate" step="0.1" required>
        </div>
        <div>
            <label for="real_price">Harga Asli (IDR)</label>
            <input type="number" id="real_price" name="real_price" required>
        </div>
        <div>
            <label for="sell_price">Harga Jual (IDR)</label>
            <input type="number" id="sell_price" name="sell_price" required>
        </div>
        <div>
            <label for="image_url">Gambar</label>
            <input type="file" id="image_url" name="image_url" accept="image/*" required>
        </div>
        <div>
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <div>
            <button type="submit">Tambah Menu</button>
        </div>
    </form>

    <!-- The notification element -->
    <div id="notification"></div>
</body>
</html>
