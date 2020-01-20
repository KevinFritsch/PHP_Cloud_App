<?php

//************Add file******* */
/*$pathToLocalFile = __DIR__ . "/img3.jpg";
$dropboxFile = new DropboxFile($pathToLocalFile);
$file = $dropbox->simpleUpload($dropboxFile, "/Projects_Save/img3.jpg", ['autorename' => true]);

//Uploaded File
echo "file uploaded : ". $file->getName();


//***********Download file ***** */
/*$file = $dropbox->download("/img3.jpg");
//File Contents
$contents = $file->getContents();
echo $contents;
//Save file contents to disk
file_put_contents(__DIR__ . "/IMG3.jpg", $contents);
//Downloaded File Metadata
$metadata = $file->getMetadata();
//Name
echo $metadata->getName();
//********************************** */


//*****************Delete file/folder** */
/*$deletedFolder = $dropbox->delete("/Projects_Save");

//Name
//echo $deletedFolder->getName();
//************************************ */


//************List folder content***** */
/*$listFolderContents = $dropbox->listFolder("/");

//Fetch Items
$items = $listFolderContents->getItems();
//echo $items;

foreach($items as $item){
    echo $item->getName(). " -";
}

//Fetch Cusrsor for listFolderContinue()
$cursor = $listFolderContents->getCursor();

//If more items are available
$hasMoreItems = $listFolderContents->hasMoreItems();

//************************************* */



//****************Create folder */
/*$folder = $dropbox->createFolder("/Projects");

//Name
echo $folder->getName() . "  folder created";
//***************************** */
