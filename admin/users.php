<?php
include '../admin/connect/connect.php'; // Sertakan file koneksi

// Query untuk mengambil data dari tabel users
$sql = "SELECT name, email, username, birthday, phone, room_number, area, created_at FROM users";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users Table</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../admin/asset/css/users.css" rel="stylesheet">
</head>
<body>
<?php include '../admin/sidebar.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php include '../admin/sidebar.php'; ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="container mt-5">
                <div class="table-header">
                    All Users
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Birthday</th>
                                <th>Phone</th>
                                <th>Room Number</th>
                                <th>Area</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                // Output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["birthday"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["room_number"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["area"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8'>No users found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>



<?php
// Tutup koneksi
mysqli_close($conn);
?>