<?php

function addTemplate($type, $text) {
    require_once 'config.php';

    try {
        $sql = "Insert Into mail_template
                (`type`, `text`)
            Values (:type, :text);";

        $statement = $conn->prepare($sql);
        $statement->bindParam(':type', $type, PDO::PARAM_INT);
        $statement->bindParam(':text', $text, PDO::PARAM_STR);
        $statement->execute();

        $sql = "Select * From mail_template ORDER BY created_at desc;";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        return array('accept' => true, 'error' => '', 'data' => $result);
    } catch (PDOException $e) {
        return array('accept' => false, 'error' => $e->getMessage(), 'data' => array());
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */
/* --------------------------------------------- MAIN --------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------------------ */

header('Content-Type: application/json');
//header('Content-Type: text/html; charset=utf-8');
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(array('status_code' => 405, 'status_message' => 'Not allowed request method!', 'data' => array())));
}

$result = addTemplate($_POST['type'], $_POST['text']);
if($result && $result['accept']) {
    echo json_encode(['status_code' => 200, 'status_message' => 'OK', 'data' => $result['data']]);
    http_response_code(200);
}
else {
    echo json_encode(['status_code' => 400, 'status_message' => 'Fail insert to DB', 'data' => $result]);
    http_response_code(400);
}

