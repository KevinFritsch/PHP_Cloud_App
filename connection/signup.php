<?php
session_start();

include 'databaseConfig.php';

?>


<head>
  <title>ProjectManager</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="style/style.css">

</head>
<body>
	<nav class="nav-extended">
		<div class="container">
			<div class="nav-wrapper">
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="../index.php">Menu</a></li>
                </ul>
				<a href="index.php" class="brand-logo">ProjectManager: Sign Up</a>
			</div>
		</div>
    </nav>
    <div class="container">
         <div class="card-panel blue-grey">
           
            <div class="card-panel ">
                <form action="adduser.php" method="post">
                    <div class="row">
                        <div class="col s6">
                            <h5>First Name</h5>
                            <input placeholder="First Name" id="first_name" name="first_name_input" type="text" class="validate" required>
                        </div>
                        <div class="col s6">
                             <h5>Last Name</h5>
                            <input placeholder="Last Name" id="last_name" name="last_name_input" type="text" class="validate" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <h5>Username</h5>
                            <input placeholder="Username" id="username" name="username_input" type="text" class="validate" maxlength="100" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <h5>Password</h5>
                            <input id="password" placeholder="Password" name="password_input" type="password" class="validate" maxlength="100" required>
                        </div>
                        <div class="col s6">
                             <h5>Confirm Password</h5>
                            <input id="password_confirm" placeholder="Password Confirm" name="password_confirm_input" type="password" class="validate" maxlength="100" required>
                        </div>  

                    </div>
                    <button class="btn waves-effect waves-light" name="btn_createAccount" type="submit">Create Account</button>
                    <?php if(isset($_SESSION["message"])){
                        echo "<p style='color:red'>".$_SESSION["message"]."</p>"; 
                        unset($_SESSION['message']);
                   } ?>
                </form>
            </div>
            <div>
                <button class="btn waves-effect waves-light" name="btn_signin"><a class="white-text" href="connectionForm.php">Sign In</a></button>
                <button class="btn waves-effect waves-light red" name="btn_cancel"><a class="white-text" href="../index.php">Cancel</a></button>
            </div>
        </div>
    </div>
</body>


