<?php
require('connect.php');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        extract($_POST);
        if (!empty($student_id) && !empty($university_id) && !empty($offer_type)) {
            $sql = $conn->prepare("SELECT * FROM admissions WHERE student_id = :student_id AND university_id = :university_id");
            $sql->execute(['student_id' => $student_id, 'university_id' => $university_id]);
            if ($sql->rowCount() > 0) {
                $stmt = $conn->prepare("UPDATE admissions SET offer_type = :offer_type WHERE student_id = :student_id AND university_id = :university_id");
                $stmt->execute(['student_id' => $student_id, 'university_id' => $university_id, 'offer_type' => $offer_type]);
                $response = ['message' => 'Added with offer type'];
                http_response_code(200);
            } else {
                $stmt = $conn->prepare("INSERT INTO admissions (student_id,university_id,offer_type) VALUES(:student_id,:university_id,:offer_type)");
                $stmt->execute(['student_id' => $student_id, 'university_id' => $university_id, 'offer_type' => $offer_type]);
                $response = ['message' => 'Added Successfully'];
                http_response_code(200);
            }
        } else if (!empty($student_id) && !empty($university_id) && !empty($offer_availed)) {
            $stmt = $conn->prepare("UPDATE admissions SET offer_availed = :offer_availed WHERE student_id = :student_id AND university_id = :university_id");
            $stmt->execute(['student_id' => $student_id, 'university_id' => $university_id, 'offer_availed' => $offer_availed]);
            $response = ['message' => 'Added with offer avail'];
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
