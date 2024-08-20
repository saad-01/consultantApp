<?php
require('connect.php');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        extract($_POST);
        $stmt = $conn->prepare("SELECT COUNT(*) AS count_students FROM students WHERE subproject_id = :id");
        $stmt->execute(['id' => $id]);
        $totalStudentsResult = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalStudents = $totalStudentsResult['count_students'];

        if ($stmt->rowCount() > 0) {

            $stmt = $conn->prepare(" SELECT COUNT(*) AS count_students FROM students
            WHERE subproject_id = :id AND NOT EXISTS (
            SELECT 1
            FROM admissions
            WHERE students.id = admissions.student_id)");
            $stmt->execute(['id' => $id]);
            $waitingResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $waiting = $waitingResult['count_students'];

            $stmt = $conn->prepare("SELECT COUNT(*) AS count_students
            FROM students WHERE subproject_id = :id AND EXISTS (
            SELECT 1
            FROM admissions
            WHERE students.id = admissions.student_id
                AND offer_availed = 'Yes')");
            $stmt->execute(['id' => $id]);
            $offerAvailedResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $offerAvailed = $offerAvailedResult['count_students'];

            $stmt = $conn->prepare(" SELECT COUNT(DISTINCT students.id) AS count_students FROM students JOIN admissions ON students.id = admissions.student_id WHERE students.subproject_id = :id
            AND 'Unconditional' IN (
            SELECT offer_type
            FROM admissions
            WHERE students.id = admissions.student_id)");
            $stmt->execute(['id' => $id]);
            $unconditionalOffersResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $unconditionalOffers = $unconditionalOffersResult['count_students'];
            $stmt = $conn->prepare("SELECT COUNT(*) AS count_students FROM students WHERE subproject_id = :id AND cas_applied = 'Yes'");
            $stmt->execute(['id' => $id]);
            $casAppliedResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $cas_applied = $casAppliedResult['count_students'];

            $stmt = $conn->prepare("SELECT COUNT(*) AS count_students FROM students WHERE subproject_id = :id AND cas_received = 'Yes'");
            $stmt->execute(['id' => $id]);
            $casReceivedResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $cas_received = $casReceivedResult['count_students'];

            $response = [
                'totalStudents' => $totalStudents,
                'waiting' => $waiting,
                'unconditional' => $unconditionalOffers,
                'offerAvailed' => $offerAvailed,
                'applied' => $cas_applied,
                'received' => $cas_received
            ];

            http_response_code(200);
        } else {
            // No record exist
            $response = ['message' => 'No students'];
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
