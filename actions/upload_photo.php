<?php
declare(strict_types=1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

$user = $session->getUser();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user) {
    $productId = $_POST['product_id'] ?? null;

    // Check if productId is provided
    if (!$productId) {
        http_response_code(400);
        echo json_encode(["success" => false, "error" => "Product ID is required"]);
        exit;
    }

    // Check if the user is authorized to add a photo for this product
    // You may want to implement additional authorization logic here
    // For example, checking if the user is the seller of the product
    // or has appropriate permissions
    // For simplicity, assuming any authenticated user can add a photo for any product
    //$rawPostData = file_get_contents('php://input');
    $files = $_FILES['photo'] ?? null;

    if ($files && is_array($files) && isset($files['name'])) {
        $result = uploadPhoto($files, $productId);
        echo json_encode($result);
    } else {
        http_response_code(400);
        echo json_encode(["success" => false, "error" => "No file uploaded"]);
    }
} else {
    http_response_code(403);
    echo json_encode(["success" => false, "error" => "Unauthorized"]);
}



// Assuming you have a function to validate and move uploaded files
// Adjust the logic as per your application's requirements
function uploadPhoto($file, $productId) {
    // Check if file is uploaded successfully
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ["success" => false, "error" => "Failed to upload file"];
    }

    // Validate file type (assuming only image files are allowed)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        return ["success" => false, "error" => "Only JPEG, PNG, and GIF files are allowed"];
    }

    // Move the uploaded file to the desired directory
    $uploadDir = __DIR__ . '/../images/products/';
    $filename = $file['name'];
    $destination = $uploadDir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        return ["success" => false, "error" => "Failed to move uploaded file"];
    }

    // Assuming you have a function to add the photo information to the database
    // Adjust this function as per your database schema
    if (addPhotoToDatabase($filename, $productId)) {
        return ["success" => true];
    } else {
        unlink($destination); // Delete the uploaded file if database insertion fails
        return ["success" => false, "error" => "Failed to add photo information to database"];
    }
}

// Assuming you have a function to add photo information to the database
// Adjust the logic as per your application's requirements
function addPhotoToDatabase($filename, $productId) {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('INSERT INTO Photo (idProduct, photo) VALUES (?, ?)');

    return $stmt->execute([$productId, $filename]);
}

?>


