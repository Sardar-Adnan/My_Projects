<?php
session_start();



// Only run if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = mysqli_connect("localhost", "root", "", "car_rental");

  

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            box-shadow: 0 0 10px #aaa;
        }
        h2 {
            text-align: center;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="box">
        <h2>Admin Login</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
