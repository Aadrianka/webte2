<?php

include "function.php";

function generatePassword($csv) {
    $csv['headers'][] = 'heslo';
    for($i = 0; $i < count($csv['data']); $i++) {
        $csv['data'][$i][] = generateRandomString();
    }
    return $csv;
}

function generateCsv($filename, $list, $delimiter) {
    $filename = 'file/' . $filename;
    try {
        $fp = fopen($filename, 'w');
        fputcsv($fp, $list['headers'], $delimiter);

        foreach ($list['data'] as $fields) {
            fputcsv($fp, $fields, $delimiter);
        }

        fclose($fp);
        return $filename;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */
/* --------------------------------------------- MAIN --------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------------------ */

//header('Content-Type: application/json');
header('Content-Type: text/html; charset=utf-8');
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(array('status_code' => 405, 'status_message' => 'Not allowed request method!', 'data' => array())));
}

$hash = bin2hex(random_bytes(16));
$uploadfile = uploadFile($hash, 'csv-first');


$csv = parseCSV($uploadfile['uploadfile'], $_POST['delimiter']);
$csv = generatePassword($csv);
$out = generateCsv('output_' . $hash . '.csv', $csv, $_POST['delimiter']);
//var_dump($csv);

echo json_encode(array('status_code' => 200, 'status_message' => 'OK', 'data' => array('output_file' => array('first_upload' => $out))));
