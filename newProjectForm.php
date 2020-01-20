<?php
session_start();


?>
<head>
  <title>ProjectManager</title>
  <link rel="stylesheet" type="text/css" href="style/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

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
            <div class="card-panel">
                <form action="addProject.php" id="addProject" class="project_informationForm" method="post">
                    <div >
                    <?php 
                    if(isset($_SESSION['message'])){
                        echo "<h6 style='color:red'>".$_SESSION['message']."</h6>";
                        unset($_SESSION['message']);
                    } ?>
                        <h5>Project Title</h5>
                        <input placeholder="Project Title" name="project_title" type="text" class="validate" maxlength="100" required>
                    </div>
                    <div class="input-field">
                        <h5>Project Description</h5>
                        <input placeholder="Project Description" name="project_description" type="text" class="validate" maxlength="100" required>
                    </div>
                    <div class="input-field">
                        <h5>Subject MRN</h5>
                        <input placeholder="Subject MRN" name="subject_mrn" type="text" class="validate" maxlength="100" required>
                    </div>
                    <div>
                        <h5>DoB</h5>
                        <input type="date" class="datepicker" value="<?php echo date('Y-m-d'); ?>" name="dob" required>
                    </div>
                    <div class="input-field">
                        <h5>Pathology Number</h5>
                        <input placeholder="Pathology Number" name="pathology_number" type="text" class="validate" maxlength="100" required>
                    </div>
                    <div class="input-field">
                        <h5>Comment</h5>
                        <input placeholder="Comment" name="comment" type="text" class="validate" maxlength="100" required>
                    </div>
                    <div>
                    
		  			<p>
			  			<button class="btn waves-effect waves-light" type="submit">Add Project
				    	<i class="material-icons right">send</i>
				    	</button>
				    	<a href="index.php" class="modal-close waves-effect waves-light btn red">Cancel</a>
				    </p>
                    </div>
                    <div class="card-panel blue-grey">
                        <h4 style="color:white">File Upload:</h4>
                        <p>(Please make sure there is no space in the file path)</p>
                        <form id="upload_form" enctype="multipart/form-data" method="post">
                            <div class="container">
                                <input style="margin:3px;" type="file" name="file1" id="file1" ><br>
                            </div>
                            <div class="container">    
                                <input style="margin:3px;" class="btn waves-effect waves-light" type="button" value="Upload File" onclick="uploadFile()">
                                <progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
                            </div>
                            <h5 id="status"></h5>
                            <p id="loaded_n_total"></p><br>
                        </form>
                    </div>
                </form>  
                <script>
                    function _(el){
                        return document.getElementById(el);
                    }
                    function uploadFile(){
                        var file = _("file1").files[0];
                        // alert(file.name+" | "+file.size+" | "+file.type);
                        var formdata = new FormData();
                        formdata.append("file1", file);
                        var ajax = new XMLHttpRequest();
                        ajax.upload.addEventListener("progress", progressHandler, false);
                        ajax.addEventListener("load", completeHandler, false);
                        ajax.addEventListener("error", errorHandler, false);
                        ajax.addEventListener("abort", abortHandler, false);
                        ajax.open("POST", "file_upload_parser.php");
                        ajax.send(formdata);
                    }
                    function progressHandler(event){
                        _("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
                        var percent = (event.loaded / event.total) * 100;
                        _("progressBar").value = Math.round(percent);
                        _("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
                    }
                    function completeHandler(event){
                        _("status").innerHTML = event.target.responseText;
                        _("progressBar").value = 0;
                    }
                    function errorHandler(event){
                        _("status").innerHTML = "Upload Failed";
                    }
                    function abortHandler(event){
                        _("status").innerHTML = "Upload Aborted";
                    }
                </script>  
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

