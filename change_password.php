<?php
require('connect.php');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        extract($_POST);
        if (!empty($email)) {
            $stmt = $conn->prepare(
                "SELECT * FROM codes WHERE email =:email AND code =:code"
            );
            $stmt->execute(['email' => $email, 'code' => $code]);

            if ($stmt->rowCount() > 0) {
                $hashedPassword =
                    password_hash($password, PASSWORD_BCRYPT);
                $stmt = $conn->prepare(
                    "UPDATE users SET password =:hasshedPassword WHERE email=:email"
                );
                $stmt->execute(['email' => $email, 'hasshedPassword' => $hashedPassword]);
                $stmt = $conn->prepare(
                    "DELETE FROM codes WHERE email =:email AND code =:code"
                );
                $stmt->execute(['email' => $email, 'code' => $code]);
                $response = ['message' => 'Password changed'];
                http_response_code(200);
            } else {
                // User login failed
                $response = ['message' => 'Entered code is not valid'];
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
