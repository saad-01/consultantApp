<?php
require('connect.php');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        extract($_POST);
        if (!empty($name)) {
            $stmt = $conn->prepare("INSERT INTO universities (name) VALUES(:name)");
            $stmt->execute(['name' => $name]);
            $response = ['message' => 'Added university successfully'];
            http_response_code(200);
        } else {
            // Invalid request method
            $response = ['message' => 'Invalid request parameters'];
            http_response_code(400);
        }
    } else {
        // Invalid request method
        $response = ['message' => 'Invalid request method'];
        http_response_code(405);
    }

    // Return the response as JSON
    echo json_encode($response);
} catch (PDOException $e) {
    echo $e->getMessage();
}

$conn = null;
