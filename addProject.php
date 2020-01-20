<?php
session_start();
include 'connection/databaseConfig.php';


require __DIR__ . '/vendor/autoload.php';
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;
$app = new DropboxApp("taaptqh0xc0wgr4", "ims173lqdjshc85", 'bjU-U9k3ZVAAAAAAAAAAC6eVGOrmEuvnqSkRAnjngXfZCkxIJVwUpCbwRBsSVxZm');
$dropbox = new Dropbox($app);



if(isset($_POST["project_title"]) && isset($_POST["project_description"]) &&
isset($_POST["subject_mrn"]) && isset($_POST["dob"]) && 
isset($_POST["pathology_number"]) && isset($_POST["comment"])  ){
    

    $project_title = $_POST["project_title"];
    $project_title = str_replace(' ', '_', $project_title);

    $project_description = $_POST["project_description"];
    $subject_mrn = $_POST["subject_mrn"];
    $dob = $_POST["dob"];
    $pathology_number = $_POST["pathology_number"];
    $comment = $_POST["comment"];

    $projectFolderName = $project_title."_".$dob;

    $tab_bdd = $db->query("SELECT * FROM projects");
    $unique_project = true;
    
	while($results = $tab_bdd->fetch()){
		if($results['nameProject'] == $projectFolderName){
            $unique_project = false;
            break;
        }
    }
    if(!$unique_project){
        $_SESSION['message'] = "The project name already exists.";
        header("Location: newProjectForm.php");
        exit;
    }


    //create folder
    $folder = $dropbox->createFolder("/Projects/".$projectFolderName);
    //display success of upload

    //create an information textfile
    $projectFileName = "tempFiles/Information_".$projectFolderName.".txt";
    $myfile = fopen($projectFileName, "w") or die("Unable to open file!");
    $txt = "Project Title:  ".$project_title."\n\n
    Project Description:  ".$project_description."\n
    Subject MRN:  ".$subject_mrn."\n
    Date of Birth:  ".$dob."\n
    Pathology Number:  ".$pathology_number."\n\n
    Comment:  ".$comment;
    fwrite($myfile, $txt);
    fclose($myfile);

    $pathToLocalFile = __DIR__ . "/".$projectFileName;
    $dropboxFile = new DropboxFile($pathToLocalFile);
    $file = $dropbox->simpleUpload($dropboxFile, "/Projects/".$projectFolderName."/Information_".$projectFolderName.".txt", ['autorename' => true]);
   
    

    unlink($projectFileName) or die("Couldn't delete file");


    //upload the files in the tempFiles folder
    $files = array_slice(scandir('tempFiles/'), 2);

    foreach($files as $i){
        $fileToUploadPath = __DIR__ . "/tempFiles/".$i;
        $dropboxFile = new DropboxFile($fileToUploadPath);
        $file = $dropbox->simpleUpload($dropboxFile, "/Projects/".$projectFolderName."/".$i, ['autorename' => true]);   
        unlink($fileToUploadPath) or die("Couldn't delete file");

    }


    //add the project in the database
    $insert_project = $db->prepare( "INSERT INTO projects (nameProject, creatorProject) VALUES (:project_title, :creator )");
		$insert_project->bindValue(':project_title', $projectFolderName, PDO::PARAM_STR);
        $insert_project->bindValue(':creator', (int)$_SESSION['user'], PDO::PARAM_INT);
       

		$insert_project->execute();

		

}

header("Location: index.php");
exit;


