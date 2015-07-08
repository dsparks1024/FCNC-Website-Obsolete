<?	$user = $_SESSION['auth'];

	$panel = '<div class="span6 offset2 well">
			  	<h4 class="wellTitle muted">Control Panel</h4>
			  </div>';

	if($user =="editor" || $user=="admin"){
		echo $panel;
	}


?>