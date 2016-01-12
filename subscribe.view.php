<h1>Bonjour, veuillez entrer votre email pour vous inscrire a la newsletter</h1>
<form method="POST">
	<label for="email">Email</label>
	<input type="email" name="email" id="email" placeholder="Rentre ton email ici...">
	<?php echo error_message($error, 'email'); ?>

	<label for="honeyPot" class="displayNone">HoneyPot</label>
	<input type="text" name="honeyPot" class="displayNone" id="honeyPot">

	<input type="submit" name="submit_email" value="Envoyer mon email" class="submit_button">
	<?php echo error_message($error, 'new_email'); ?>
</form>

<a class="admin_link" href="?page=login">Administrateur</a>