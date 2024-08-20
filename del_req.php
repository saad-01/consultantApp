<?php
require('connect.php');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $stmt = $conn->prepare("SELECT id, studentname FROM students WHERE delete_req = :delete_req");
        $stmt->execute(['delete_req' => 'Pending']);

        if ($stmt->rowCount() > 0) {
            // Records found
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response = $result;
            http_response_code(200);
        } else {
            // No record exist
            $response = ['message' => 'No users'];
            http_response_code(401);
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
