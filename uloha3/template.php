<?php

function addTemplate($name, $type, $text, $conn) {
    require_once 'config.php';

    try {
        $sql = "Insert Into mail_template
                (`name`, `type`, `text`)
            Values (:name, :type, :text);";

        $statement = $conn->prepare($sql);
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
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

function deleteTemplate($id, $conn) {
    try {
        $sql = "Delete From mail_template Where id = :id;";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_STR);
        $statement->execute();
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */
/* --------------------------------------------- MAIN REST API ------------------------------------------------------ */
/* ------------------------------------------------------------------------------------------------------------------ */

require_once 'config.php';
include 'function.php';

if(!checkAuth()) {
    die(json_encode(['status' => 401, 'status_message' => 'Je potrebné prihlásenie ako admin!']));
}

header('Content-Type: application/json');
//header('Content-Type: text/html; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];

if($method === 'GET') {
    if(isset($_SERVER['PATH_INFO'])) { //ID
        $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
        $param = array_shift($request);
        if($param === 'files') {
            $result_files = getFilesByType(2, $conn);
//            var_dump($result_files);
            $result_templates = getTemplate($conn);
//            var_dump($result_templates);
            echo json_encode(['data' => array('files' => $result_files, 'templates' => $result_templates['data'])]);
        }
        else {
            $result = getTemplate($conn, $param);
            echo json_encode(['data' => $result['data']]);
        }
    }
    else { // ALL
        $result = getTemplate($conn);
        echo json_encode(['data' => $result['data']]);
    }
}
elseif ($method === 'POST') {
    if(isset($_POST['template-type']) && isset($_POST['template-text'])) {
        $result = addTemplate($_POST['template-name'], $_POST['template-type'], $_POST['template-text'], $conn);
        $code = $result['accept'] ? 201 : 400;
        http_response_code($code);
        echo json_encode(['status_code' => $code]);
    }
}
elseif ($method === 'DELETE') {
    if(isset($_SERVER['PATH_INFO'])) {
        $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
        $param = array_shift($request);
        $result = deleteTemplate($param, $conn);
        if($result) {
            $result = getTemplate($conn);
            echo json_encode(['status' => 200, 'data' => $result['data']]);
            http_response_code(200);
            exit;
        }
    }
    echo json_encode(['status' => 400, 'data' => array()]);
    http_response_code(400);
}