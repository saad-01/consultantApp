<?php
require('connect.php');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $selectedFilters = $data['selectedFilters'];
        $columnNames = $selectedFilters;
        if ($selectedFilters !== null) {
            $query = "SELECT s.id, s.studentname FROM students s
          INNER JOIN applications a ON s.id = a.student_id
          WHERE a.university_id = $columnNames[0]";

            for ($i = 1; $i < count($columnNames); $i++) {
                $columnName = $columnNames[$i];
                $query .= " AND s.id IN (
                    SELECT student_id FROM applications
                    WHERE university_id = $columnName
                )";
            }
        } else {
            $query = "SELECT * FROM students";
        }
        $stmt = $conn->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Records found
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response = $result;
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
