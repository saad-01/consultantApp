<?php
require('connect.php');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        extract($_POST);
        if (!empty($id) && !empty($action)) {
            if ($action == 'accept') {
                $stmt = $conn->prepare(
                    "UPDATE users SET status = :status WHERE id=:id"
                );
                $stmt->execute(['status' => 'Approved', 'id' => $id,]);
                $response = ['message' => 'Approval granted'];
            } else {
                $stmt = $conn->prepare(
                    "DELETE FROM users WHERE id=:id"
                );
                $stmt->execute(['id' => $id,]);
                $response = ['message' => 'Approval rejcted'];
            }
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
