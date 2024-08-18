<?php
// Start session
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
include '../user/connect/connection.php';

// Check if 'id' parameter is present in the URL
if (!isset($_GET['id'])) {
    die('Restaurant ID not specified.');
}

$restaurant_id = $_GET['id'];

try {
    // Fetch operational hours
    $sql_get_operational_hours = "
        SELECT day_of_week, open_time, close_time
        FROM operational_hours
        WHERE restaurant_id = :restaurant_id
    ";
    $stmt = $conn->prepare($sql_get_operational_hours);
    $stmt->bindParam(':restaurant_id', $restaurant_id);
    $stmt->execute();

    $operational_hours = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Operational Hours</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css">
        <link rel="stylesheet" href="../user/css/resto_info.css">
    </head>
<body>
    <!-- Bootstrap Modal -->
    <div class="modal fade" id="operationalHoursModal" tabindex="-1" aria-labelledby="operationalHoursModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="operationalHoursModalLabel">Operational Hours</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        <?php if (!empty($operational_hours)): ?>
                            <?php foreach ($operational_hours as $hours): ?>
                                <li><?php echo htmlspecialchars($hours['day_of_week']) . ": " . htmlspecialchars($hours['open_time']) . " - " . htmlspecialchars($hours['close_time']); ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>Operational hours not available</li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="modal-footer">
                    <a href="resto_menu.php" class="btn btn-secondary">Close</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap and MDB JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = new mdb.Modal(document.getElementById('operationalHoursModal'));
            modal.show();
        });
    </script>
</body>
</html>
