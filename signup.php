<?php
require('connect.php');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        extract($_POST); 
        if (!empty($username) && !empty($password) && !empty($email)) {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            if ($stmt->rowCount() > 0) {
                $response = ['message' => 'Email already exist'];
                http_response_code(401);
            } else {
                $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
                $stmt->execute(['username' => $username]);
                if ($stmt->rowCount() > 0) {
                    $response = ['message' => 'Username already taken'];
                    http_response_code(403);
                } else {
                    $hasshedpas = password_hash($password, PASSWORD_BCRYPT);
                    $stmt = $conn->prepare(
                        "INSERT INTO users (email, username, password) VALUES (:email, :username, :hasshedpas)"
                    );
                    $stmt->execute(array('username' => $username, 'hasshedpas' => $hasshedpas, 'email' => $email));
                    // Signup successful
                    $response = ['message' => 'Signup Successful'];
                    http_response_code(200);
                }
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
