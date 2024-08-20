<?php
require('connect.php');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        extract($_POST);
        if (!empty($id) && !empty($action)) {
            if ($action == 'accept') {
                $stmt = $conn->prepare(
                    "DELETE FROM students WHERE id=:id"
                );
                $stmt->execute(['id' => $id]);
                $stmt = $conn->prepare(
                    "DELETE FROM applications WHERE student_id=:id"
                );
                $stmt->execute(['id' => $id]);
                $stmt = $conn->prepare(
                    "DELETE FROM admissions WHERE student_id=:id"
                );
                $stmt->execute(['id' => $id]);
                $response = ['message' => 'Deleted'];
            } else {
                $stmt = $conn->prepare(
                    "UPDATE students SET delete_req = 'Rejected' WHERE id=:id"
                );
                $stmt->execute(['id' => $id]);
                $response = ['message' => 'Rejcted'];
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
