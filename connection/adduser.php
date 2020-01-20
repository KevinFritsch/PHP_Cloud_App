<?php session_start();
include "databaseConfig.php";

if(isset($_POST["first_name_input"]) && !empty($_POST["first_name_input"]) 
&& isset($_POST["last_name_input"]) && !empty($_POST["last_name_input"]) 
&& isset($_POST["username_input"]) && !empty($_POST["username_input"]) 
&& isset($_POST["password_input"]) && !empty($_POST["password_input"]) 
&& isset($_POST["password_confirm_input"]) && !empty($_POST["password_confirm_input"])){

    $first_name = htmlentities($_POST["first_name_input"]);
    $last_name = htmlentities($_POST["last_name_input"]);
    $user_name = htmlentities($_POST["username_input"]);
    $password = htmlentities($_POST["password_input"]);
    $password_confirm = htmlentities($_POST["password_confirm_input"]);

    //check passwords
    if($password != $password_confirm){
        $_SESSION['message'] = "The 2 passwords are different.";
        redirect();
    }

    //check that new user
    $tab_bdd = $db->query("SELECT * FROM users");
    $unique_user = true;
    
	while($results = $tab_bdd->fetch()){
		if($results['userName'] == $user_name){
            $unique_user = false;
            break;
        }
    }
    if(!$unique_user){
        $_SESSION['message'] = "The user name already exists.";
        redirect();
    }

    //insert data
    $insert_user = $db->prepare( "INSERT INTO users (userName, userPassword, firstName, lastName) VALUES (:user_name, :password, :first_name, :last_name)");
		$insert_user->bindValue(':user_name', $user_name, PDO::PARAM_STR);
        $insert_user->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $insert_user->bindValue(':first_name', $first_name, PDO::PARAM_STR);
		$insert_user->bindValue(':last_name', $last_name, PDO::PARAM_STR);

		$ok = $insert_user->execute();

		if($ok){
            $_SESSION['message'] = "Account created.";
            header("Location: connectionForm.php");
            exit;
		}
		else{
            $_SESSION["message"] = "Account creation failed.";
            redirect();
		}

}
	
function redirect(){
	header("Location: signup.php");
	exit;

}

?>
