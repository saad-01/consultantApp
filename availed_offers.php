<?php
require('connect.php');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        extract($_POST);
        $stmt = $conn->prepare("SELECT u.name FROM universities u JOIN admissions a ON u.id = a.university_id WHERE a.student_id = :id AND a.offer_availed = :offer_availed");
        $stmt->execute(['id' => $id, 'offer_availed' => 'Yes']);

        if ($stmt->rowCount() > 0) {
            // Records found
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response = $result;
            http_response_code(200);
        } else {
            // No record exist
            $response = ['message' => 'No record'];
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
