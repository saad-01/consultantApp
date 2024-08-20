<?php
require('connect.php');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        extract($_POST);
        if (!empty($studentname) && !empty($subproject_id)) {
            $stmt = $conn->prepare("INSERT INTO students(assignee, studentname, subproject_id, tags, reference, lastdegree, engtst, tbtst, unifee, consltfee, cas_applied, cas_received, docsurl, missingdocs, note, email, proceeding_uni, number, priority, unitst, bankstatement, visa) VALUES (:assignee, :studentname, :subproject_id, :tags, :reference, :lastdegree, :engtst, :tbtst, :unifee, :consltfee, :cas_applied,:cas_received, :docsurl, :missingdocs, :note, :email, :proceeding_uni, :number, :priority, :unitst, :bankstatement, :visa)");
            $stmt->execute(['assignee' => $assignee, 'studentname' => $studentname, 'subproject_id' => $subproject_id, 'tags' => $tags, 'reference' => $reference, 'lastdegree' => $lastdegree, 'engtst' => $engtst, 'tbtst' => $tbtst, 'unifee' => $unifee, 'consltfee' => $consltfee, 'cas_applied' => $cas_applied, 'cas_received' => $cas_received, 'docsurl' => $docsurl, 'missingdocs' => $missingdocs, 'note' => $note, 'email' => $email, 'proceeding_uni' => $proceeding_uni, 'number' => $number, 'priority' => $priority, 'unitst' => $unitst, 'bankstatement' => $bankstatement, 'visa' => $visa]);
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
