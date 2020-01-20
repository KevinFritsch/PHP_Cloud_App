<?php
session_start();
include "connection/databaseConfig.php";


require __DIR__ . '/vendor/autoload.php';
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;
$app = new DropboxApp("taaptqh0xc0wgr4", "ims173lqdjshc85", 'bjU-U9k3ZVAAAAAAAAAAC6eVGOrmEuvnqSkRAnjngXfZCkxIJVwUpCbwRBsSVxZm');
$dropbox = new Dropbox($app);


$projectToDelete = $_POST["btnDeleteProject"];
//echo $projectToDelete;
$deletedFolder = $dropbox->delete("/Projects/".$projectToDelete);

//delete project from database
$query = $db->prepare('DELETE FROM projects WHERE nameProject = :projectName');
$query->bindvalue(':projectName', $projectToDelete, PDO::PARAM_STR);
$query->execute(); 


//Name
//echo $deletedFolder->getName();

header("Location: index.php");
exit;