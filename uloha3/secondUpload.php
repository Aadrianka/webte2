<?php

include "function.php";
require_once "vendor/autoload.php";

function sendMail($login, $password, $mail, $data) {
    // Create the Transport
    $transport = (new Swift_SmtpTransport('mail.stuba.sk', 587, 'tls'))
        ->setUsername($login)
        ->setPassword($password);

// Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);

// Create a message
    $message = (new Swift_Message($data['subject']))
        ->setFrom($data['sender'])
        ->setTo($data['recipient']);

    if(isset($data['text']))
        $message->setBody($data['text']);
    elseif(isset($data['html']))
        $message->setBody($data['html'], 'text/html');

    if(isset($data['attachment']))
        $message->attach(Swift_Attachment::fromPath($data['attachment']));

// Send the message
    $result = $mailer->send($message);
}

/* ------------------------------------------------------------------------------------------------------------------ */
/* --------------------------------------------- MAIN --------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------------------ */
//sendMail('xmarinic', 'Rip.4.zaq.ova', 'xmarinic@stuba.sk', array('subject' => 'Test Mail', 'sender' => 'xmarinic@stuba.sk', 'recipient' => 'dano.marinic@gmail.com', 'text' => 'Ahoj' .PHP_EOL. ' ako?' .PHP_EOL));
//echo json_encode(['status' => 200, 'data' => $_GET['type']]);
//header('Content-Type: application/json; charset=utf-8');
header('Content-Type: text/html; charset=utf-8');
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(array('status_code' => 405, 'status_message' => 'Not allowed request method!', 'data' => array())));
}



//$hash = bin2hex(random_bytes(16));
//$uploadfile = uploadFile($hash, 'csv-second');
//
//
//$csv = parseCSV($uploadfile['uploadfile'], $_POST['delimiter']);