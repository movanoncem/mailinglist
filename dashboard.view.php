<?php 
	if($_POST['submit_new_user']){
		$honeyPot = trim(strip_tags($_POST['honeyPot']));
		$email_new = trim(strip_tags($_POST['email_new']));

		if($honeyPot != ''){
			die('Spammeur');
		}
		if($email_new == ''){
			$error['email_new'] = "Vous n\'avez pas entré d'adresse email";		
		}
        if (valid_email($email_new) == ''){ 
            $error['email_new'] = 'Merci d\'entrer une adresse email valide';
        }else{
        	$sql = 'SELECT * FROM users WHERE userEmail = :userEmail';
			$preparedStatement = $connexion->prepare($sql);
            $preparedStatement->bindValue(':userEmail', $email_new);
            $preparedStatement->execute();
            if($preparedStatement->fetch()) {
               $error['email_new'] = 'Erreur, il semble que ce mail soit déjà enregistré chez nous';
            }else{
            	$sql = 'INSERT INTO users(userEmail, subscribtionTime) VALUES(:userEmail, :subscribtionTime)';
	        	$subscribtionTime = date("Y-m-d H:i:s"); 
	            $preparedStatement = $connexion->prepare($sql);
	            $preparedStatement->bindValue(':userEmail', $email_new);
	            $preparedStatement->bindValue(':subscribtionTime', $subscribtionTime);
	            $preparedStatement->execute();
        	}
        }
	}
 ?>
<a class="logout" href="index.php?page=logout">Logout</a>

<h1>Bienvenue sur l'interface de gestion des utilisateurs</h1>
<h2>Créer un utilisateur - CREATE</h2>
<h3>Veuillez entrer l'adresse email de l'utilisateur à ajouter</h3>
<form method="POST">
	<label for="email_new">Email</label>
	<input name="email_new" type="email_new" id="email_new" placeholder="Email de l'utilisateur...">
	<?php echo error_message($error, 'email_new'); ?>
	
	<label class="displayNone" for="honeyPot">honeyPot</label>
	<input name="honeyPot" type="text" id="honeyPot" class="displayNone">

	<input type="submit" value="Ajouter l'utilisateur" name="submit_new_user" class="submit_button"> 
</form>

<h2>Liste des personnes ayant validé leur lien - READ, UPDATE, DELETE</h2>
<?php
	$sql = 'SELECT * FROM users WHERE userValid = "Valid"';
	$query = $connexion->prepare($sql);
	$query->execute();
	$donnee = $query->fetchAll();
	$validUser = array_reverse($donnee);
?>

<ul>
<?php 
	//Et je l'affiche sous forme de ul
	foreach($validUser as $m){ 
		$email = $m['userEmail'];
		?>

    <li>
        <p><?php echo $email; ?></p><a class="edit_button" href="user_management.view.php?action=edit&email=<?php echo $m['userEmail'] ?>&id=<?php echo $m['id'] ?>">Modifier</a></p> <a class="edit_button" href="user_management.view.php?action=delete&id=<?php echo $m['id'] ?>">Supprimer </a></p> 
    </li>
    
<?php } ?>
</ul>
