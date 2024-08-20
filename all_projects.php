<?php
require('connect.php');
try {
    $stmt = $conn->prepare("SELECT * FROM projects");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Records found
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response = ['projects' => $result];
        http_response_code(200);
    } else {
        // No record exist
        $response = ['message' => 'No projects'];
        http_response_code(401);
    }


    // Return the response as JSON
    echo json_encode($response);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
