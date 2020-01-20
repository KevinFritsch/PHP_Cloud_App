<?php session_start();
include 'databaseConfig.php';


if(isset($_POST["username_input"]) && !empty($_POST["username_input"]) && isset($_POST["password_input"]) && !empty($_POST["password_input"])){
	$user_name = htmlentities($_POST["username_input"]);
    $password = htmlentities($_POST["password_input"]);


	$tab_bdd = $db->query("SELECT * FROM users");

	while($results = $tab_bdd->fetch()){


		if($results["userName"] == $user_name){

			if(password_verify($password, $results["userPassword"])){

                $_SESSION["user"] = $results["idUser"];
                $_SESSION["firstName"] = $results["firstName"];
                $_SESSION["lastName"] = $results["lastName"];

				header("Location: ../index.php");
				exit;
			}
			else{
				$_SESSION["message"] = "Wrong password.";

				redirect();
			}

		}
		
	}
    $_SESSION["message"] = "Wrong user name.";
    redirect();	
}


function redirect(){
	//header("Location: connectionForm.php");
	exit;
}


?>
