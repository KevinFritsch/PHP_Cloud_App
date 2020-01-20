<?php
session_start();


require __DIR__ . '/vendor/autoload.php';
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;
$app = new DropboxApp("taaptqh0xc0wgr4", "ims173lqdjshc85", 'bjU-U9k3ZVAAAAAAAAAAC6eVGOrmEuvnqSkRAnjngXfZCkxIJVwUpCbwRBsSVxZm');
$dropbox = new Dropbox($app);


$fileToDelete = $_POST["btnDeleteFile"];
//echo $projectToDelete;
$deletedFolder = $dropbox->delete("/Projects/".$fileToDelete);



header("Location: index.php");
exit;