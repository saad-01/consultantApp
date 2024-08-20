<?php
require('connect.php');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        extract($_GET);
        extract($_POST);
        if (!empty($name) && !empty($color)) {
            $stmt = $conn->prepare(
                "INSERT INTO subprojects (name, color,project_id) VALUES (:name, :color, :id)"
            );
            $stmt->execute(['name' => $name, 'color' => $color, 'id' => $id]);


            // Project Created successfully
            $response = ['message' => 'Project Created Successfully'];
            http_response_code(200);
        } else {
            // Invalid request parameters
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
