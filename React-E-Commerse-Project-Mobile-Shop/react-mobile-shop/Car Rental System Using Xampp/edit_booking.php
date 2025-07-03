<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental";

$conn = new mysqli($servername, $username, $password, $dbname);



// Fetch booking details
$booking = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM bookings WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $email = $conn->real_escape_string($_POST['email']);
    $car = $conn->real_escape_string($_POST['car']);
    $pickupDate = $conn->real_escape_string($_POST['pickupDate']);
    $returnDate = $conn->real_escape_string($_POST['returnDate']);
    $payment = $conn->real_escape_string($_POST['payment']);

    $sql = "UPDATE bookings SET name=?, contact=?, email=?, car=?, pickup_date=?, return_date=?, payment_method=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $name, $contact, $email, $car, $pickupDate, $returnDate, $payment, $id);
    
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?success=1");
        exit();
    } else {
        $error = "Error updating booking: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #2c3e50;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn-group {
            margin-top: 20px;
        }
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background-color: #3498db;
            color: white;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #7f8c8d;
        }
        .error {
            color: #e74c3c;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Booking</h2>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($booking): ?>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $booking['id']; ?>">
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($booking['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($booking['contact']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($booking['email']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="car">Car</label>
                <select id="car" name="car" required>
                    <option value="">-- Select a Car --</option>
                    <option value="Suzuki Alto" <?php echo $booking['car'] === 'Suzuki Alto' ? 'selected' : ''; ?>>Suzuki Alto (Economy)</option>
                    <option value="Toyota Vitz" <?php echo $booking['car'] === 'Toyota Vitz' ? 'selected' : ''; ?>>Toyota Vitz (Economy)</option>
                    <option value="Honda Fit" <?php echo $booking['car'] === 'Honda Fit' ? 'selected' : ''; ?>>Honda Fit (Economy)</option>
                    <option value="Hyundai i10" <?php echo $booking['car'] === 'Hyundai i10' ? 'selected' : ''; ?>>Hyundai i10 (Economy)</option>
                    <option value="Toyota Corolla" <?php echo $booking['car'] === 'Toyota Corolla' ? 'selected' : ''; ?>>Toyota Corolla (Sedan)</option>
                    <option value="Honda Civic" <?php echo $booking['car'] === 'Honda Civic' ? 'selected' : ''; ?>>Honda Civic (Sedan)</option>
                    <option value="Volkswagen Passat" <?php echo $booking['car'] === 'Volkswagen Passat' ? 'selected' : ''; ?>>Volkswagen Passat (Sedan)</option>
                    <option value="Hyundai Sonata" <?php echo $booking['car'] === 'Hyundai Sonata' ? 'selected' : ''; ?>>Hyundai Sonata (Sedan)</option>
                    <option value="Mercedes-Benz S-Class" <?php echo $booking['car'] === 'Mercedes-Benz S-Class' ? 'selected' : ''; ?>>Mercedes-Benz S-Class (Luxury)</option>
                    <option value="BMW 7 Series" <?php echo $booking['car'] === 'BMW 7 Series' ? 'selected' : ''; ?>>BMW 7 Series (Luxury)</option>
                    <option value="Audi A8" <?php echo $booking['car'] === 'Audi A8' ? 'selected' : ''; ?>>Audi A8 (Luxury)</option>
                    <option value="Lexus LS 500" <?php echo $booking['car'] === 'Lexus LS 500' ? 'selected' : ''; ?>>Lexus LS 500 (Luxury)</option>
                    <option value="Toyota Land Cruiser" <?php echo $booking['car'] === 'Toyota Land Cruiser' ? 'selected' : ''; ?>>Toyota Land Cruiser (SUV)</option>
                    <option value="Honda CR-V" <?php echo $booking['car'] === 'Honda CR-V' ? 'selected' : ''; ?>>Honda CR-V (SUV)</option>
                    <option value="Hyundai Tucson" <?php echo $booking['car'] === 'Hyundai Tucson' ? 'selected' : ''; ?>>Hyundai Tucson (SUV)</option>
                    <option value="Ford Everest" <?php echo $booking['car'] === 'Ford Everest' ? 'selected' : ''; ?>>Ford Everest (SUV)</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="pickupDate">Pickup Date</label>
                <input type="date" id="pickupDate" name="pickupDate" value="<?php echo $booking['pickup_date']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="returnDate">Return Date</label>
                <input type="date" id="returnDate" name="returnDate" value="<?php echo $booking['return_date']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="payment">Payment Method</label>
                <select id="payment" name="payment" required>
                    <option value="">-- Select Payment Method --</option>
                    <option value="Credit Card" <?php echo $booking['payment_method'] === 'Credit Card' ? 'selected' : ''; ?>>Credit Card</option>
                    <option value="Bank Transfer" <?php echo $booking['payment_method'] === 'Bank Transfer' ? 'selected' : ''; ?>>Bank Transfer</option>
                    <option value="Cash on Pickup" <?php echo $booking['payment_method'] === 'Cash on Pickup' ? 'selected' : ''; ?>>Cash on Pickup</option>
                </select>
            </div>
            
            <div class="btn-group">
                <button type="submit" name="update" class="btn btn-primary">Update Booking</button>
                <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
        <?php else: ?>
            <p>Booking not found.</p>
            <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        <?php endif; ?>
    </div>
</body>
</html>
<?php $conn->close(); ?>