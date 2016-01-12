<?php 

	function error_message($error, $key){
		if($error[$key] != ''){
			return '<p class="error">'.$error[$key].'</p>';
		}else{
			return false;
		}
	}
	function valid_email($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
 ?>
