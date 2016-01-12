<?php 
include('config.inc.php');
include('functions.inc.php');
	$action = $_GET['action'];
	$id = $_GET['id'];
	$email = $_GET['email'];
	switch ($action){
		 case "delete":
		 	$sql = 'DELETE FROM users WHERE id = :id';
		 	$preparedStatement = $connexion->prepare($sql);
            $preparedStatement->bindValue(':id', $id);
            $preparedStatement->execute();
            header("Location: index.php?page=dashboard");
            break;
        case "edit":
        	if($_POST['edit_user']){
        		$honeyPot = trim(strip_tags($_POST['honeyPot']));
				$new_email = trim(strip_tags($_POST['new_email']));

				if($honeyPot != ''){
					die('Spammeur');
				}
				if($new_email == ''){
					$error['new_email'] = "Vous n\'avez pas entré d'adresse email";		
				}
		        if (valid_email($new_email) == ''){ 
		            $error['new_email'] = 'Merci d\'entrer une adresse email valide';
		        }else{
		        	$sql = 'UPDATE users SET userEmail = :userEmail WHERE id = :id';
                	$preparedStatement = $connexion->prepare($sql);
                	$preparedStatement->bindValue(':userEmail', $new_email);
                	$preparedStatement->bindValue(':id', $id);
                	$preparedStatement->execute();
                	header("Location: index.php?page=dashboard");
		        }
        	}
		 	echo '<div class="container"><h2>Adresse email actuelle de l\'utilisateur : '.$email;
		 	echo '<h2>Veuillez entrer la nouvelle adresse email de l\'utilisateur</h2>
		 		<form method="POST">
					<label for="new_email">Email</label>
					<input name="new_email" type="new_email" id="new_email" placeholder="Email de l utilisateur...">
					<?php echo error_message($error, "new_email"); ?>

					<label class="displayNone" for="honeyPot">honeyPot</label>
					<input name="honeyPot" type="text" id="honeyPot" class="displayNone">


					<input type="submit" value="Valider" name="edit_user"> 
				</form></div>'
		 	;
            break;

	}


 ?>

 <link rel="stylesheet" type="text/css" href="style.css">