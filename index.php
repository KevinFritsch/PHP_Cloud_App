<?php
session_start();
include 'connection/databaseConfig.php';

?>


<head>
  <title>ProjectManager</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="style/style.css">

</head>


<?php
require __DIR__ . '/vendor/autoload.php';
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;


//https://github.com/kunalvarma05/dropbox-php-sdk/wiki/Configuration
//https://www.dropbox.com/developers/apps/info/taaptqh0xc0wgr4

$app = new DropboxApp("taaptqh0xc0wgr4", "ims173lqdjshc85", 'bjU-U9k3ZVAAAAAAAAAAC6eVGOrmEuvnqSkRAnjngXfZCkxIJVwUpCbwRBsSVxZm');
$dropbox = new Dropbox($app);

//delete all the files in tempFiles folder
$files = array_slice(scandir('tempFiles/'), 2);

foreach($files as $i){
    $fileToUploadPath = __DIR__ . "/tempFiles/".$i; 
    unlink($fileToUploadPath) or die("Couldn't delete file");
}
$files = array_slice(scandir('Download/'), 2);

foreach($files as $i){
    $fileToUploadPath = __DIR__ . "/Download/".$i; 
    unlink($fileToUploadPath) or die("Couldn't delete file");
}




?>
<body>
	
    <?php if(isset($_SESSION['user'])){ ?>
        <nav class="nav-extended">
		<div class="container">
			<div class="nav-wrapper">
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="logout.php">Log Out (<?php echo $_SESSION['firstName']." ".$_SESSION['lastName'] ?>) </a></li>
                </ul>
				<a href="index.php" class="brand-logo">ProjectManager</a>
			</div>
		</div>
    </nav>
        <div class="container">
        <h2>Welcome <?php echo $_SESSION['firstName'] ?>.</h2>
        <h3>List of Projects <a class="btn-floating btn-large waves-effect waves-light red" href="newProjectForm.php"><i class="material-icons">add</i></a></h3>
        <?php
            $listFolderContents = $dropbox->listFolder("/Projects");
            //Fetch Items
            $items = $listFolderContents->getItems();
            //echo $items;
        ?>
        <ul class="collection">
            <?php
            foreach($items as $item){
                $creator = $db->prepare('SELECT * FROM users  WHERE iduser = (SELECT creatorProject FROM projects WHERE nameProject = :projectName)');
                $creator->bindvalue(':projectName', $item->getName(), PDO::PARAM_STR);
                $creator->execute(); 
                $row = $creator->fetch();

                $firstName = $row['firstName'];
                $lastName = $row['lastName'];

                


                ?>
                <div class="card-panel blue-grey">
                    <div class="card-panel">
                    <div class="button-container">
                        <form method="post" action="openProject.php">
                            <h4 style='color:#2b99d8'><i class="material-icons">folder</i><span class="text-darken-2">"<?php echo $item->getName(); ?>"</span></h4>
                            <h6 class="right"><i class="material-icons">account_circle</i><?php echo $firstName." ".$lastName ?></h6>
                            <button style="margin:1px;" class="btn waves-effect waves-light" type="submit" name="titleProject" value=<?php echo $item->getName(); ?>>Open
                                <i class="material-icons right">launch</i>
                            </button>
                        </form>
                        <form method="post" action="downloadFolder.php">
                            <button style="margin:1px;" type="submit" name="btnDownloadFolder" value=<?php echo $item->getName(); ?> class="btn waves-effect waves-light">Download Manager<i class="material-icons right">file_download</i></button>
                        </form> 
                        <form method="post" action="deleteProject.php">
                            <button style="margin:5px;" type="submit" name="btnDeleteProject" value=<?php echo $item->getName(); ?> class="btn waves-effect waves-light red"><i class="material-icons">delete</i></button>  	
                        </form>
                    </div>
                    </div>
                </div>
            <?php } ?>
        </ul>
    </div>
    <?php }
    else{ ?>

<nav class="nav-extended">
		<div class="container">
			<div class="nav-wrapper">
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="connection/connectionForm.php">Sign In</a></li>
                </ul>
				<a href="index.php" class="brand-logo">ProjectManager</a>
			</div>
		</div>
    </nav>
    <div class="container">
        <div class="card-panel blue-grey">
            <div class="card-panel">
                <h4>Please <a href="connection/connectionForm.php">sign in</a> or <a href="connection/signup.php">sign up</a> to manage projects.</h4>
            </div>
        </div>
    </div>
    <?php } ?>
    
</body>
