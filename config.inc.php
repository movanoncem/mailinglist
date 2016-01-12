<?php 
ob_start();
//Connexion a la base de données 
	$host = 'localhost';
	$dbname = 'mailinglist';
	$user = 'root';
	$password = 'root';
	try{
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
    $connexion = new PDO($dsn, $user, $password);
    }catch(PDOException $e){
    echo $e->getMessage();
    exit;
    }

?>