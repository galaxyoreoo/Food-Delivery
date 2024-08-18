<?php
// Enable detailed error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../user/connect/connection.php'; // Connect to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get data from form
        $seller_name = htmlspecialchars($_POST['seller_name']);
        $contact_info = htmlspecialchars($_POST['contact_info']);
        $resto_name = htmlspecialchars($_POST['restaurant_name']);
        $country = htmlspecialchars($_POST['country']);

        // Handle image upload
        $image_url = null;
        if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "C:/xampp/htdocs/ProjekNLUG/user/images"; // Directory for storing images
            $image_name = uniqid() . '_' . basename($_FILES["image_url"]["name"]);
            $target_file = $target_dir . $image_name;
            if (move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file)) {
                $image_url = $image_name; // Store only the filename
            } else {
                throw new Exception("Failed to upload image.");
            }
        }

        // Insert seller if not exists and get seller_id
        $stmt = $conn->prepare("SELECT seller_id FROM seller WHERE seller_name = :seller_name");
        $stmt->bindParam(':seller_name', $seller_name);
        $stmt->execute();
        $seller = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($seller) {
            $seller_id = $seller['seller_id'];
        } else {
            // Insert new seller and get seller_id
            $stmt = $conn->prepare("INSERT INTO seller (seller_name, contact_info) VALUES (:seller_name, :contact_info)");
            $stmt->bindParam(':seller_name', $seller_name);
            $stmt->bindParam(':contact_info', $contact_info);
            $stmt->execute();
            $seller_id = $conn->lastInsertId();
        }

        // Insert restaurant data into 'restaurants' table
        $sql = "INSERT INTO restaurants (seller_id, resto_name, country, image_url) VALUES (:seller_id, :resto_name, :country, :image_url)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':seller_id', $seller_id);
        $stmt->bindParam(':resto_name', $resto_name);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':image_url', $image_url);
        $stmt->execute();

        // Get the ID of the newly added restaurant
        $restaurant_id = $conn->lastInsertId();

        // Insert operational hours into 'operational_hours' table
        if (isset($_POST['operational_hours'])) {
            foreach ($_POST['operational_hours'] as $hour) {
                if (isset($hour['day_of_week']) && isset($hour['open_time']) && isset($hour['close_time'])) {
                    $day_of_week = htmlspecialchars($hour['day_of_week']);
                    $open_time = htmlspecialchars($hour['open_time']);
                    $close_time = htmlspecialchars($hour['close_time']);

                    $sql = "INSERT INTO operational_hours (restaurant_id, day_of_week, open_time, close_time) VALUES (:restaurant_id, :day_of_week, :open_time, :close_time)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':restaurant_id', $restaurant_id);
                    $stmt->bindParam(':day_of_week', $day_of_week);
                    $stmt->bindParam(':open_time', $open_time);
                    $stmt->bindParam(':close_time', $close_time);
                    $stmt->execute();
                }
            }
        }

        echo "Restaurant successfully added!";
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Restaurant</title>
    <link rel="stylesheet" href="../user/css/add_resto.css"> <!-- Link to the external CSS file -->
    <script src="../user/js/add_resto.js" defer></script> <!-- Link to the external JavaScript file -->
</head>
<body>
    <h1>Add Restaurant</h1>
    <form action="../user/add_resto.php" method="POST" enctype="multipart/form-data">
        <!-- Restaurant Information -->
        <fieldset>
            <legend>Restaurant Information</legend>
            
            <label for="seller_name">Restaurant Owner Name:</label>
            <input type="text" id="seller_name" name="seller_name" required>

            <label for="contact_info">Contact Information:</label>
            <input type="text" id="contact_info" name="contact_info" required>

            <label for="restaurant_name">Restaurant Name:</label>
            <input type="text" id="restaurant_name" name="restaurant_name" required>

            <label for="image">Restaurant Image:</label>
            <input type="file" id="image" name="image_url" accept="image/*">

            <label for="country">Country:</label>
            <input type="text" id="country" name="country" required>
        </fieldset>

        <!-- Operational Hours -->
        <fieldset>
            <legend>Operational Hours</legend>

            <div id="operational_hours">
                <!-- Form input for operational hours (day and time) -->
                <div class="operational_hour" id="hour_template" style="display: none;">
                    <label>Day:</label>
                    <select name="operational_hours[][day_of_week]" required>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>

                    <label>Open Time:</label>
                    <input type="time" name="operational_hours[][open_time]" required>

                    <label>Close Time:</label>
                    <input type="time" name="operational_hours[][close_time]" required>

                    <!-- Delete Button -->
                    <button type="button" class="delete_hour">Delete</button>
                </div>
                <!-- The new hours will be added here -->
            </div>
            <button type="button" id="add_more_hours">Add More Hours</button>
        </fieldset>

        <button type="submit">Add Restaurant</button>
    </form>
</body>
</html>
