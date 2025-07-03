<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Connect to database
$conn = mysqli_connect("localhost", "root", "", "car_rental");


// Delete booking if requested
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM bookings WHERE id = $id");
    header("Location: admin_dashboard.php");
    exit();
}

// Get all bookings
$result = mysqli_query($conn, "SELECT * FROM bookings ORDER BY booking_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; margin: 0; }
        header { background: #2c3e50; color: white; padding: 15px; display: flex; justify-content: space-between; }
        .container { width: 90%; margin: 20px auto; }
        table { width: 100%; border-collapse: collapse; background: white; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; }
        th { background: #34495e; color: white; }
        .edit-btn, .delete-btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 3px;
        }
        .edit-btn { background: #3498db; }
        .delete-btn { background: #e74c3c; }
    </style>
</head>
<body>
    <header>
        <h2>Car Rental Admin</h2>
        <div>
            
            <a href="logout.php" style="color:white; background:#e74c3c; padding:8px; border-radius:4px;">Logout</a>
        </div>
    </header>

    <div class="container">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Car</th>
                <th>Pickup</th>
                <th>Return</th>
                <th>Payment</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['contact']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['car']; ?></td>
                <td><?php echo $row['pickup_date']; ?></td>
                <td><?php echo $row['return_date']; ?></td>
                <td><?php echo $row['payment_method']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td>
                    <a class="edit-btn" href="edit_booking.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a class="delete-btn" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this booking?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>

<?php mysqli_close($conn); ?>
