<?php
require('connect.php');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        extract($_POST);
        if (!empty($studentname)) {
            $stmt = $conn->prepare("UPDATE students SET assignee = :assignee, studentname = :studentname, tags = :tags, reference = :reference, lastdegree = :lastdegree, engtst = :engtst, tbtst = :tbtst, unifee = :unifee, consltfee = :consltfee, cas_applied = :cas_applied, cas_received = :cas_received, docsurl = :docsurl, missingdocs = :missingdocs, note = :note, email = :email, proceeding_uni = :proceeding_uni, number = :number, priority = :priority, unitst = :unitst, bankstatement = :bankstatement, visa = :visa, status =:status WHERE id = :id");
            $stmt->execute(['assignee' => $assignee, 'studentname' => $studentname, 'tags' => $tags, 'reference' => $reference, 'lastdegree' => $lastdegree, 'engtst' => $engtst, 'tbtst' => $tbtst, 'unifee' => $unifee, 'consltfee' => $consltfee, 'cas_applied' => $cas_applied, 'cas_received' => $cas_received, 'docsurl' => $docsurl, 'missingdocs' => $missingdocs, 'note' => $note, 'email' => $email, 'proceeding_uni' => $proceeding_uni, 'number' => $number, 'priority' => $priority, 'unitst' => $unitst, 'bankstatement' => $bankstatement, 'visa' => $visa, 'status' => $status, 'id' => $id]);
            $response = ['message' => 'Updated Successfully'];
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
