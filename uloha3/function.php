<?php

function generateRandomString($length = 15) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function logFile($uploadfile, $type, $conn) {
    try {
        $sql = "Insert Into files
                (basename, filename, delimiter, `type`)
            VALUES (:basename, :filename, :delimiter, :type)";

        $statement = $conn->prepare($sql);
        $statement->bindParam(':basename', $uploadfile['basename'], PDO::PARAM_STR);
        $statement->bindParam(':filename', $uploadfile['uploadfile'], PDO::PARAM_STR);
        $statement->bindParam(':delimiter', $_POST['delimiter'], PDO::PARAM_STR);
        $statement->bindParam(':type', $type, PDO::PARAM_INT);

        $statement->execute();
        return array('accept' => true, 'error' => '');
    } catch (PDOException $e) {
        return array('accept' => false, 'error' => $e->getMessage());
    }
}

function getFileById($id, $conn) {
    try {
        $sql = "Select * From files Where id = :id;";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetch();
        return $result;
    } catch (PDOException $e) {
        return false;
    }
}

function getMaxId($conn) {
    try {
        $sql = "Select Max(id) From files;";
        $statement = $conn->prepare($sql);

        $statement->execute();
        $result = $statement->fetch();
        if($result) $result = intval($result[0]);
        return $result;
    } catch (PDOException $e) {
        return false;
    }
}

function uploadFile($filename, $name) {
    $base_file = basename($_FILES[$name]['name']);
    $uploaddir = 'file/';
    $uploadfile = $uploaddir . $filename . ".csv";

    move_uploaded_file($_FILES[$name]['tmp_name'], $uploadfile);
    if ($_FILES[$name]["error"] !== 0) {
        http_response_code(400);
        die(json_encode(array('status_code' => 400, 'status_message' => 'Fail upload file', 'data' => array())));
    }
    return array('uploadfile' => $uploadfile, 'basename' => $base_file);
}

function parseCSV($file, $delimiter = ';') {
    $row = 1;
    $result = array();
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
            array_push($result, $data);
            $row++;
        }
        fclose($handle);
        $csv_headers = array_shift($result);
        return array('headers' => $csv_headers, 'data' => $result);
    }
    return false;
}