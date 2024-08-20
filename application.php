<?php
require('connect.php');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        extract($_POST);
        if (!empty($student_id) && !empty($university_id)) {
            $stmt = $conn->prepare("INSERT INTO applications(student_id, university_id) VALUES (:student_id, :university_id)");
            $stmt->execute(['student_id' => $student_id, 'university_id' => $university_id]);
            $response = ['message' => 'Added Successfully'];
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
