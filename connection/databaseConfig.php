<?php
const SQL_DSN = 'mysql:host=db778611904.hosting-data.io;dbname=db778611904';
const SQL_USERNAME = 'dbo778611904';
const SQL_PASSWORD = 'projectManager11.';

try{
	$db = new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD);
}
catch(PDOException $e){
	echo 'Erreur : ' . $e->getMessage();
	exit;
}
