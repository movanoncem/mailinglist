<h1>Bienvenue, administrateur, veuillez entrer vos identifiants.</h1>
<form method="POST">
	<label for="email">Email</label>
	<input type="email" name="email" id="email" placeholder="Rentre ton email ici...">
	<?php echo error_message($error, 'email'); ?>

	<label for="password">Votre mot de passe</label>
	<input type="password" name="password" id="password" placeholder="Rentre ton mot de passe ici...">
	<?php echo error_message($error, 'password'); ?>

	<label for="honeyPot" class="displayNone">HoneyPot</label>
	<input type="text" name="honeyPot" class="displayNone" id="honeyPot">

	<input type="submit" name="submit_admin" value="Envoyer">
	<?php echo error_message($error, 'admin_email'); ?>
</form>