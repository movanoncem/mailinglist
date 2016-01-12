<?php 
	session_start();
	include('functions.inc.php');
	include('config.inc.php');

	ini_set('display_errors', 1);
	error_reporting(E_WARNING | E_ERROR);


//LECTEUR
	if($_POST['submit_email']){

		$honeyPot = trim(strip_tags($_POST['honetPot']));
		$email = trim(strip_tags($_POST['email']));
		$error = array();

		if($honeyPot != ''){
			die('Spammeur');
		}
		if($email == ''){
			$error['email'] = "Vous n\'avez pas entré votre adresse email";		
		}
        if (valid_email($email) == ''){ 
            $error['email'] = 'Merci d\'entrer une adresse email valide';
        }else{
        	$sql = 'SELECT * FROM users WHERE userEmail = :userEmail';
			$preparedStatement = $connexion->prepare($sql);
            $preparedStatement->bindValue(':userEmail', $email);
            $preparedStatement->execute();
            if($preparedStatement->fetch()) {
               $error['new_email'] = 'Erreur, il semble que ce mail soit déjà enregistré chez nous';
            }else{
            	//Je l'enregistre dans la base de données
            	$subscribtionTime = date("Y-m-d H:i:s"); 
            	$sql = 'INSERT INTO users(userEmail, subscribtionTime) VALUES(:userEmail, :subscribtionTime)';
                $preparedStatement = $connexion->prepare($sql);
                $preparedStatement->bindValue(':userEmail', $email);
                $preparedStatement->bindValue(':subscribtionTime', $subscribtionTime);
                $preparedStatement->execute();

					require 'PHPMailer-master/PHPMailerAutoload.php';

					$mail = new PHPMailer;
					
					$link = 'http://movanoncem.be/php/mailinglist/confirm_mail.view.php/?email='.$email."'";
					
					$mail->isSMTP();
					$mail->Host = 'smtp.mandrillapp.com';
					$mail->SMTPAuth = true;
					$mail->Username = 'alexandre@pixeline.be';
					$mail->Password = 'bDMUEuWn1H4r3FCGQjyO-g';                           
					$mail->SMTPSecure = 'tls';                            
					$mail->Port = 587;                                   

					$mail->setFrom('admin@admin.com', 'Mailer');
					$mail->addAddress($email);
					
					$mail->isHTML(true);

					$mail->Subject = 'Here is the subject';
					$mail->Body    = 'Veuillez cliquer sur le lien suivant: '.$link."'";
					$mail->AltBody = 'Veuillez cliquer sur le lien suivant: '.$link."'";

					if(!$mail->send()) {
					echo 'Oops, il semble qu\'il y a un problème, veuillez réessayer a nouveau';
					echo 'Mailer Error: ' . $mail->ErrorInfo;
					} else {
						$_GET['page'] = 'confirm_send_email';
					}
            }
        }
    }

  //ADMINISTRATEUR
    if($_POST['submit_admin']){

		$honeyPot = trim(strip_tags($_POST['honetPot']));
		$email = trim(strip_tags($_POST['email']));
		$password = trim(strip_tags($_POST['password']));
		$error = array();

		if($honeyPot != ''){
			die('Spammeur');
		}
		if($email == ''){
			$error['email'] = "Vous n\'avez pas entré votre adresse email";		
		}
		if($password == ''){
			$error['password'] = "Vous n\'avez pas entré votre mot de passe";		
		}
        if (valid_email($email) == ''){ 
            $error['email'] = 'Merci d\'entrer une adresse email valide';
        }else{
        	$sql = 'SELECT * FROM users WHERE userEmail = :userEmail AND userPassword = :userPassword';
			$preparedStatement = $connexion->prepare($sql);
            $preparedStatement->bindValue(':userEmail', $email);
            $preparedStatement->bindValue(':userPassword', $password);
            $preparedStatement->execute();
            if($preparedStatement->fetch()) {
            	$_SESSION['logged_in'] = 'ok';
            	$_SESSION['email'] = $email;
               	header("Location: index.php?page=dashboard");
            }else{
            	$error['admin_email'] = 'Erreur, il semble que le mail et le mot de passe introduits ne soient pas bons';
            }
        }
    }
 ?>
<!doctype html>
 <html>
 <head>
 	<title>Mailinglist</title>
 	<meta charset="UTF-8">
 	<link rel="stylesheet" type="text/css" href="style.css">
 </head>
 <body>
 <div class="container">
 <?php  
	$page = $_GET['page'];
	switch ($page){
		 case "login":
		 	include('login.view.php');
		 	break;
		 case "confirm_send_email":
			 echo '<div class="merci"><p>Merci votre email est enregistré!</p><p>Vous allez recevoir un email, et vous devrez cliquer sur le lien de confirmation d\'inscription. Si vous ne cliquez pas dans les 30minutes, ce lien ne sera plus valable.</p></div>';
			 break;
		 case "dashboard":
			 include('dashboard.view.php');
			 break;
		 default:
		 	include('subscribe.view.php');
		 	break;
	}
 ?>
</div>
 </body>
 </html>