<?php
require('connect.php');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        extract($_POST);
        if (!empty($username) && !empty($password)) {
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND status = :status");
            $stmt->execute(array('username' => $username, 'status' => 'Approved'));
            $row = $stmt-> fetch();
            if ($stmt->rowCount() > 0 && password_verify($password, $row['password'])) {
                // User login successful
                $name = $row['username'];
                $role = $row['role'];
                $str = rand();
                $token = md5($str);
                $response = ['token' => $token, 'message' => 'Login Successfull', 'name' => $name, 'role' => $role];
                http_response_code(200);
            } else {
                // User login failed
                $response = ['message' => 'Invalid credentials or unapproved account'];
                http_response_code(401);
            }
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
