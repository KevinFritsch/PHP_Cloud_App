<?php
session_start();


$fileName = $_FILES["file1"]["name"]; // The file name
$fileTmpLoc = $_FILES["file1"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["file1"]["type"]; // The type of file it is
$fileSize = $_FILES["file1"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["file1"]["error"]; // 0 for false... and 1 for true
if (!$fileTmpLoc) { // if file not chosen
    echo "ERROR: Please browse for a file before clicking the upload button.";
    exit();
}
if(move_uploaded_file($fileTmpLoc, "tempFiles/$fileName")){
    echo "<p style='color:#34e282'> ".$fileName." uploaded</p><br><p>Files: </p>";
    $files = array_slice(scandir('tempFiles/'), 2);
    ?>    
    <ul class="collection">  <?php    

        foreach($files as $i){ ?>
            <div class="card-panel">

                <p><?php echo $i; ?></p>
            </div><?php
        } 
    ?>
    </ul> <?php
    
} else {
    echo "move_uploaded_file function failed";
}
