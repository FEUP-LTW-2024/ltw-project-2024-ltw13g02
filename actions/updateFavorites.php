<?php
// updateFavorites.php

// Include necessary files and classes
require_once '../database/userClass.php';
require_once '../sessions/session.php';

// Initialize session
$session = new Session();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the action and product ID are set in the request
    if (isset($_POST['action'], $_POST['idProduct'])) {
        $action = $_POST['action'];
        $idProduct = $_POST['idProduct'];

        // Get the current user
        $user = $session->getUser();

        // Perform the action based on the request
        switch ($action) {
            case 'add':
                $user->addToFavorites($idProduct);
                break;
            case 'remove':
                $user->removeFromFavorites($idProduct);
                break;
            default:
                // Invalid action
                http_response_code(400);
                echo 'Invalid action.';
                exit;
        }

        // Send a success response
        http_response_code(200);
        echo 'Favorites updated successfully.';
        exit;
    } else {
        // Missing action or product ID
        http_response_code(400);
        echo 'Action or product ID is missing.';
        exit;
    }
} else {
    // Invalid request method
    http_response_code(405);
    echo 'Method Not Allowed';
    exit;
}
