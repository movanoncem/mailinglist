
<h1>Hello</h1>
<?php  
	include('functions.inc.php');
	include('config.inc.php');

	ini_set('display_errors', 1);
	error_reporting(E_WARNING | E_ERROR);

	$email = $_GET['email'];

	//Get subscibtion time
    $sql = 'SELECT * FROM users WHERE userEmail = :userEmail';
    $preparedStatement = $connexion->prepare($sql);
    $preparedStatement->bindValue(':userEmail', $email);
	$preparedStatement->execute();
	$user = $preparedStatement->fetch();
	$subscribtionTime = $user['subscribtionTime'];

	//Translate subscibtion time
	$subscribtionTime = strtotime($subscribtionTime);
	$subscribtionTime = $subscribtionTime + (60 * 30);
	
	//Get and translate currenttime
	$currentTime = date('Y-m-d H:i:s');
	$currentTime = strtotime($currentTime) ;

	//Check if curretTime is begger than subscribtionTime
   if ($currentTime > $subscribtionTime){
		echo "<p>Ce lien est maintenant invalide, veuillez <a href='index.php'>vous réinscrire</a>.</p>";
	} else {
		echo "<p>Vous êtes inscrits !</p>";
		$sql = 'UPDATE users SET userValid = "Valid" WHERE userEmail = :userEmail';
        $preparedStatement = $connexion->prepare($sql);
        $preparedStatement->bindValue(':userEmail', $email);
        $preparedStatement->execute();
}
 ?>

