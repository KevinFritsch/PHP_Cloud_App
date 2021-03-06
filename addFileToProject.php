<?php
session_start();

require __DIR__ . '/vendor/autoload.php';
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;


//COMPLETE CONNECTION INFO////////////////////////////
$app = new DropboxApp("client_id", "client_secret", "access_token");
/////////////////////////////////////////////////////

$dropbox = new Dropbox($app);

//upload the files in the tempFiles folder
$files = array_slice(scandir('tempFiles/'), 2);

foreach($files as $i){
    $fileToUploadPath = __DIR__ . "/tempFiles/".$i;
    $dropboxFile = new DropboxFile($fileToUploadPath);
    $file = $dropbox->simpleUpload($dropboxFile, $_POST["btnAddFiles"]."/".$i, ['autorename' => true]);   
    unlink($fileToUploadPath) or die("Couldn't delete file");

}

header("Location: index.php");
exit;
