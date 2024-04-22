<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $city = $_POST['city'];
    $address = $_POST['address'];
    $zipCode = $_POST['zipCode'];

    // Connect to the SQLite database
    $db = new PDO('sqlite:../database/database.db');

    // Set error handling
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statement to insert user data
    $stmt = $db->prepare("INSERT INTO User (firstName, lastName, phone, email, userPassword, city, userAddress, zipCode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    // Execute the statement with the provided data
    $stmt->execute([$firstName, $lastName, $phone, $email, $password, $city, $address, $zipCode]);

    // Close the database connection
    $db = null;

    // Redirect user after successful registration
    header("Location: ../pages/index.php");
    exit;
} else {
    // If the request method is not POST, redirect to the registration form
    header("Location: ../pages/register.php");
    exit;
}


