<?php session_start();
?>

<head>
  <title>ProjectManager</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<?php
require __DIR__ . '/vendor/autoload.php';
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;

$app = new DropboxApp("taaptqh0xc0wgr4", "ims173lqdjshc85", 'bjU-U9k3ZVAAAAAAAAAAC6eVGOrmEuvnqSkRAnjngXfZCkxIJVwUpCbwRBsSVxZm');
$dropbox = new Dropbox($app);


$files = array_slice(scandir('Download/'), 2);

foreach($files as $i){
    $fileToUploadPath = __DIR__ . "/Download/".$i; 
    unlink($fileToUploadPath) or die("Couldn't delete file");
}

$file = $dropbox->download("/Projects/".$_POST["btnDownloadFile"]);
//File Contents
$contents = $file->getContents();

//Save file contents to disk

$filename = substr($_POST["btnDownloadFile"], strpos($_POST["btnDownloadFile"], "/") + 1); 
file_put_contents(__DIR__ . "/Download/".$filename, $contents);
?>

<body>
<?php
if(isset($_SESSION['user'])){
?>    
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
        <div class="card-panel blue-grey">               
            <h4 style="color:white">File Download:</h4><br>
            <div class="card-panel">
                <p class="flow-text">File name: <?php echo "<p style='color:#1d8caf' class='flow-text'>".$filename.".</p>"; ?></p>
                <?php $fileSizeBytes = filesize("Download/".$filename);
                        $fileSizeKiloBytes = $fileSizeBytes / 1000; ?>
                <p class="flow-text">File size: <?php echo "<p style='color:#1d8caf' class='flow-text'>".$fileSizeKiloBytes." KB.</p>"; ?> </p>
                <a onclick="location.href = 'javascript:history.back()'" class="waves-effect waves-light btn" href=<?php echo "Download/".$filename; ?> download= <?php echo $filename ?> >Download</a> 
             </div>
        </div>
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





