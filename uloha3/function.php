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

function uploadFile($filename, $name) {
    $base_file = basename($_FILES[$name]['name']);
    $uploaddir = 'file/';
    $uploadfile = $uploaddir . $filename . ".csv";

    $file_upload = move_uploaded_file($_FILES[$name]['tmp_name'], $uploadfile);
    if ($_FILES[$name]["error"] !== 0) {
        http_response_code(400);
        die(json_encode(array('status_code' => 400, 'status_message' => 'Fail upload file', 'data' => array())));
    }
    return array('uploadfile' => $uploadfile, 'basefile' => $base_file);
}

function parseCSV($file, $delimiter = ';') {
    $row = 1;
    $result = array();
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
            array_push($result, $data);
            $num = count($data);
            //echo "<p> $num fields in line $row: <br /></p>\n";
            $row++;
            //for ($c = 0; $c < $num; $c++) {
            //echo $data[$c] . "<br />\n";
            //}
        }
        fclose($handle);
        $csv_headers = array_shift($result);
        return array('headers' => $csv_headers, 'data' => $result);
    }
}