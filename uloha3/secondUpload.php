<?php

include "function.php";
require_once "../vendor/autoload.php";
require_once 'config.php';

function sendMail($login, $password, $data)
{
    try {
        $transport = (new Swift_SmtpTransport('mail.stuba.sk', 587, 'tls'))
            ->setUsername($login)
            ->setPassword($password);

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message($data['subject']))
            ->setTo($data['recipient']);

        if (isset($data['sender-name']))
            $message->setFrom([$data['sender-mail'] => $data['sender-name']]);
        else
            $message->setFrom($data['sender-mail']);

        if (isset($data['text']))
            $message->setBody($data['text']);
        elseif (isset($data['html']))
            $message->setBody($data['html'], 'text/html');

        if (isset($data['attachment']))
            $message->attach(Swift_Attachment::fromPath($data['attachment']['file'])
                                    ->setFilename($data['attachment']['name']));

        $result = $mailer->send($message);
        return ['accept' => true, 'data' => $result];
    } catch (Exception $e) {
        return ['accept' => false, 'data' => $e->getMessage()];
    }
}

function getMailPosition($csv) {
    for($i = 0; $i < count($csv); $i++) {
        if(strtolower($csv[$i]) === 'email')
            return $i;
    }
    return false;
}

function getNamePosition($csv) {
    for($i = 0; $i < count($csv); $i++) {
        if(strtolower($csv[$i]) === 'meno')
            return $i;
    }
    return false;
}

function sendMailAll($csv, $template, $type, $attachment, $conn){
    $type = $type === 'text/html' ? 'html' : 'text';
    $template_id = $type === 'text/html' ? 2 : 1;
    try {
        $mail = getMailPosition($csv['headers']);
        $name = getMailPosition($csv['headers']);
        $errors = [];
        if(!$mail) return false;
        for($i = 0; $i < count($csv['data']); $i++) {
            $body = $template['text'];
            for($j = 0; $j < count($csv['headers']); $j++) {
                $body = str_replace('{{'.$csv['headers'][$j].'}}', $csv['data'][$i][$j], $body);
            }
            $body = str_replace('{{sender}}', $_POST['sender-name'], $body);
            $result = sendMail($_POST['user'], $_POST['password'], array('subject' => $_POST['subject'], 'sender-name' => $_POST['sender-name'],
                'recipient' => $csv['data'][$i][$mail], $type => $body, 'sender-mail' => $_POST['sender-mail'], 'attachment' => $attachment));
            if(!$result['accept']) {
                $errors[] = [$csv['data'][$i][$mail], $result['data']];
            }
            else {
                $log = logMail($csv['data'][$i][$name], $template_id, $_POST['subject'], $conn);
                if(!$log['accept'])
                    $errors[] = $log['error'];
            }
        }
        return $errors;
    } catch (Exception $e) {
        return false;
    }
}

function logMail($recipient, $template_id, $subject, $conn) {
    try {
        $sql = "Insert Into mail_log (recipient, template_type_id, `subject`) VALUES(:recipient, :template_id, :subject)";
        $statement = $conn->prepare($sql);
//        $statement->execute(array($recipient, $template_id, $subject));
        $statement->bindParam(':recipient', $recipient, PDO::PARAM_STR);
        $statement->bindParam(':template_id', $template_id, PDO::PARAM_INT);
        $statement->bindParam(':subject', $subject, PDO::PARAM_STR);
        $statement->execute();
        return ['accept' => true, 'error' => []];
    } catch (PDOException $e) {
        return ['accept' => false, 'error' => $e->getMessage()];
    }
}

function getLogMail($conn) {
    try {
        $sql = "Select recipient, b.name as type, subject, created_at
            From mail_log a Inner Join mail_template_type b On a.template_type_id = b.id
            Order by created_at desc;";

        $statement = $conn->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll();
        if($data)
            return ['accept' => true, 'error' => [], 'data' => $data];
        else
            return ['accept' => false, 'error' => []];
    } catch (PDOException $e) {
        return ['accept' => false, 'error' => $e->getMessage()];
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */
/* --------------------------------------------- MAIN --------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------------------ */

//sendMail('xmarinic', 'Rip.4.zaq.ova', 'xmarinic@stuba.sk', array('subject' => 'Test Mail', 'sender' => 'xmarinic@stuba.sk', 'recipient' => 'dano.marinic@gmail.com', 'text' => 'Ahoj' .PHP_EOL. ' ako?' .PHP_EOL));
//echo json_encode(['status' => 200, 'data' => $_GET['type']]);
header('Content-Type: application/json; charset=utf-8');
//header('Content-Type: text/html; charset=utf-8');
if(!checkAuth()) {
    die(json_encode(['status' => 401, 'status_message' => 'Je potrebné prihlásenie ako admin!']));
}


if($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(getLogMail($conn));
    exit;
}
elseif ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(array('status_code' => 405, 'status_message' => 'Not allowed request method!', 'data' => array())));
}

$hash = bin2hex(random_bytes(16));

if (isset($_FILES['csv-second'])) {
    $uploadfile = uploadFile($hash, 'csv-second');
    $uploadfile['delimiter'] = $_POST['second-delimiter'];
    $logDB = logFile($uploadfile, 2, $conn);

    //TEST
    if ($logDB['accept']) {
        $uploadfile['fileId'] = getMaxId($conn);
        $uploadfile['fileDelimiter'] = $_POST['second-delimiter'];
        echo json_encode(['status' => 200, 'status_message' => 'OK', 'data' => $uploadfile]);
        http_response_code(200);
        exit;
    } else {
        echo json_encode(['status' => 400, 'status_message' => 'Fail log file', 'data' => $logDB]);
        http_response_code(400);
        exit;
    }
} else {
    if(empty($_POST['files-select']) || empty($_POST['template-select']))
        die(json_encode(['status' => 400, 'status_message' => 'File or template is empty', 'data' => array()]));

    $file = getFileById($_POST['files-select'], $conn);
    if(!$file)
        die(json_encode(['status' => 400, 'status_message' => 'File not found!', 'data' => array()]));

    $template = getTemplate($conn, $_POST['template-select']);
    if(!$template['accept'])
        die(json_encode(['status' => 400, 'status_message' => 'Template not found!', 'data' => $template]));
//    var_dump($template);
    $csv = parseCSV($file['filename'], $file['delimiter']);
    $attachment = file_exists($_FILES['attachment']['tmp_name']) ? ['file' => $_FILES['attachment']['tmp_name'], 'name' => basename($_FILES['attachment']['name'])] : null;
    $errors = sendMailAll($csv, $template['data'], $template['data']['type'], $attachment, $conn);
    echo json_encode(['status' => 200, 'errors' => $errors]);
}
