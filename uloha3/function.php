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
        $statement->bindParam(':delimiter', $uploadfile['delimiter'], PDO::PARAM_STR);
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

function getFilesByType($type, $conn) {
    try {
        $sql = "Select * From files Where `type` = :type Order by created_at desc;";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':type', $type, PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetchAll();
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

function getTemplate($conn, $id = NULL) {
    try {
        if($id) {
            $sql = "Select a.id, a.text, a.name, b.name as `type`, a.created_at
                    From mail_template a
                    Inner JOIN mail_template_type b
                        On a.type = b.id 
                    Where a.id = :id;";
            $statement = $conn->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_STR);
        }
        else {
            $sql = "Select a.id, b.name as type, a.name, a.text, a.created_at From mail_template a INNER JOIN mail_template_type b On a.type = b.id ORDER BY created_at desc;";
            $statement = $conn->prepare($sql);
        }
        $statement->execute();

        $data = $id ? $statement->fetch() : $statement->fetchAll();

        if($data)
            $result = $data;
        else
            $result = array();

        return array('accept' => true, 'error' => '', 'data' => $result);
    } catch (PDOException $e) {
        return array('accept' => false, 'error' => $e->getMessage());
    }
}