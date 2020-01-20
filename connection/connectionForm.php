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
				<a href="index.php" class="brand-logo">ProjectManager: Sign In</a>
			</div>
		</div>
    </nav>
    <div class="container">
         <div class="card-panel blue-grey">
           
            <div class="card-panel ">
                <form action="authenticate.php" method="post">
                        <div>
                            <h5>Username</h5>
                            <input placeholder="Username" id="username" name="username_input" type="text" class="validate" maxlength="100" required>
                        </div>
                        <div>
                            <h5>Password</h5>
                            <input id="password" placeholder="Password" name="password_input" type="password" class="validate" maxlength="100" required>
                        </div>
                        <button class="btn waves-effect waves-light" name="btn_signin" type="submit">Sign In</button>
                        <?php if(isset($_SESSION["message"])){
                        echo "<p style='color:red'>".$_SESSION["message"]."</p>"; 
                        unset($_SESSION['message']);
                   } ?>
                </form>
                </form>
            </div>
            <div>
                <button class="btn waves-effect waves-light" name="btn_signup"><a class="white-text" href="signup.php">Create Account</a></button>
                <button class="btn waves-effect waves-light red" name="btn_cancel"><a class="white-text" href="../index.php">Cancel</a></button>
            </div>
        </div>
    </div>
</body>


