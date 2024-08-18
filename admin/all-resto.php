<?php
include '../admin/connect/connect.php';

$sql = "
    SELECT
        r.name AS restaurant_name,
        r.country AS country,  -- Menggunakan kolom country
        r.image_url,
        s.contact_info,
        GROUP_CONCAT(DISTINCT CONCAT(oh.day_of_week, ': ', oh.open_time, ' - ', oh.close_time) SEPARATOR '; ') AS open_hours
    FROM
        restaurants r
    JOIN
        seller s ON r.seller_id = s.seller_id
    JOIN
        operational_hours oh ON r.restaurant_id = oh.restaurant_id
    GROUP BY
        r.restaurant_id
";

echo "<pre>$sql</pre>";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Query Error: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Restaurants Table</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../admin/asset/css/all-resto.css" rel="stylesheet">
</head>
<body>
<?php include '../admin/sidebar.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php include '../admin/sidebar.php'; ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="container mt-5">
                <div class="table-header">
                    All Restaurants
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Country</th> <!-- Kolom Country -->
                                <th>Name</th>
                                <th>Contact Info</th>
                                <th>Open Hours</th>
                                <th>Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['country']); ?></td> <!-- Menampilkan country -->
                                        <td><?php echo htmlspecialchars($row['restaurant_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['contact_info']); ?></td>
                                        <td><?php echo htmlspecialchars($row['open_hours']); ?></td>
                                        <td><img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Restaurant Image" style="width: 100px;"></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">No records found</td> <!-- Mengubah colspan untuk mencocokkan jumlah kolom -->
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Tutup koneksi
mysqli_close($conn);
?>
