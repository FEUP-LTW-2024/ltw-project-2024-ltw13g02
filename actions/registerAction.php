<?php
include_once('../database/connection_to_db.php');
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
$db = getDatabaseConnection();

// Set error handling
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Prepare SQL statement to insert user data
$db->exec("INSERT INTO User (firstName, lastName, phone, email, userPassword, city, userAddress, zipCode) VALUES ('$firstName', '$lastName', '$phone', '$email', '$userPassword', '$city', '$userAddress', '$zipCode')");


// Close the database connection
$db = null;

// Redirect user after successful registration
header("Location: ../pages");
exit;


