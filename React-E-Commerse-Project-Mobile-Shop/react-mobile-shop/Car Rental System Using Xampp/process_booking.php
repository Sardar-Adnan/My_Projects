<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);



// Get form data
$name = $_POST['name'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$car = $_POST['car'];
$pickupDate = $_POST['pickupDate'];
$returnDate = $_POST['returnDate'];
$payment = $_POST['payment'];




?>