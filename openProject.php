<?php
session_start();

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


$app = new DropboxApp("taaptqh0xc0wgr4", "ims173lqdjshc85", 'bjU-U9k3ZVAAAAAAAAAAC6eVGOrmEuvnqSkRAnjngXfZCkxIJVwUpCbwRBsSVxZm');
$dropbox = new Dropbox($app);
//delete all the files in tempFiles folder
$files = array_slice(scandir('tempFiles/'), 2);

foreach($files as $i){
    $fileToUploadPath = __DIR__ . "/tempFiles/".$i; 
    unlink($fileToUploadPath) or die("Couldn't delete file");
}


if(isset($_SESSION['user'])){
?>


<body>
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
  <?php 
  $listFolderContents = $dropbox->listFolder("/Projects/".$_POST["titleProject"]);

  //Fetch Items
  $items = $listFolderContents->getItems();
  ?>
<div class="container">
  <h2>Content of <?php echo $_POST["titleProject"] ?></h2>
  <form method="post" action="addFileToProjectForm.php">
    <h4><span class="blue-text text-darken-2">Add Files   </span><button class="btn-floating btn-large waves-effect waves-light red" type="submit" name="btnAddFileToProject" value=<?php echo "/Projects/".$_POST["titleProject"] ?>>
          <i class="material-icons">add</i>
      </button></h4>
  </form>
  <ul class="collection">      
    <?php
    foreach($items as $item){ ?>
          <div class="card-panel blue-grey">
            <?php if($item->getName() == "Information_".$_POST["titleProject"].".txt"){ ?>
                <h4><span class="white-text text-darken-2">"<?php echo $item->getName(); ?> "</span></h4>
                    <?php $file = $dropbox->download("/Projects/".$_POST["titleProject"]."/".$item->getName());
                //File Contents
                $contents = $file->getContents();
                echo "<p>(".$contents.")</p>";
                ?><form method="post" action="downloadFile.php">
                <button type="submit" name="btnDownloadFile" value=<?php echo $_POST["titleProject"]."/".$item->getName(); ?> class="btn waves-effect waves-light">Download<i class="material-icons right">file_download</i></button>
              </form> <?php
            } 
            else{ ?>
              <div class="button-container">
                <form method="post" action="downloadFile.php">
                <h4><span class="white-text text-darken-2">"<?php echo $item->getName(); ?>"</span></h4>
                <button style="margin:1px;" type="submit" name="btnDownloadFile" value=<?php echo $_POST["titleProject"]."/".$item->getName(); ?> class="btn waves-effect waves-light"><i class="material-icons right">file_download</i>Download</button>
            </form> 
              <form method="post" action="deleteFile.php">
              <button style="margin:2px;" type="submit" name="btnDeleteFile" value=<?php echo $_POST["titleProject"]."/".$item->getName(); ?> class="btn waves-effect waves-light red"><i class="material-icons">delete</i></button>  	
            </form>
            </div>
            <?php } ?> 
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