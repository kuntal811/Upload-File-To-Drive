<?php

session_start();

require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';

$credential = file_get_contents('token.json');
$credential = json_decode($credential,true);
$credential = $credential['web']; 

$client = new Google_Client();
$client->setClientId($credential['client_id']);
$client->setClientSecret($credential['client_secret']);
$client->setRedirectUri($credential['redirect_uris'][0]);
$client->setScopes(array('https://www.googleapis.com/auth/drive'));

if (isset($_GET['code'])) {
    $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
    header('location:'.$credential['redirect_uris'][0]);exit;
} elseif (!isset($_SESSION['accessToken'])) {
    $client->authenticate();
}

if (!empty($_POST)) {
    $client->setAccessToken($_SESSION['accessToken']);
    $service = new Google_DriveService($client);
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file = new Google_DriveFile();
    
        $file_path = $_FILES['file']['tmp_name'];
        $file_name = $_FILES['file']['name'];
        $mime_type = finfo_file($finfo, $file_path);
        $file->setTitle($file_name);
        $file->setDescription('This is a '.$mime_type.' document');
        $file->setMimeType($mime_type);
        
        $service->files->insert(
            $file,
            array(
                'data' => file_get_contents($file_path),
                'mimeType' => $mime_type
            )
        );
    finfo_close($finfo);
    //header('location:'.$url);exit;
}
include 'form.php';

?>