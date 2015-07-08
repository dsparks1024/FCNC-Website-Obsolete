<? session_start(); 
?>
<!DOCTYPE html>
<html>

<head>
	<title>FCNC NEW WEBSITE Obsolete</title>
	
	<? include('globalConfig.php'); 
	   include(DOMS_FRAMEWORK.'/HTML/formBuilder.php');
	?>
	
	<link rel="stylesheet" type="text/css" href="/globalResources/css/index.css"/>

	<? include GENERAL_CSS ?>
	
</head>

<body>

	<!-- SLIDESHOW/BIG IMAGE GO HERE -->
	
	<? include TOP_NAV ?>	
		
	<? include INDEX_FOOTER ?>
	
	
	<div id="loginForm" class="form">
		<h3>Employee Login</h3>
		<? 
			$login = new formBuilder('/frameworks/DomsFramework/Login/secureLogin.php');
			$login->addTextInput('Username','Username','text','username','input-medium');
			$login->addTextInput('Password','Password','password','password','input-medium');
			$login->addLinkText("Forgot Password?","forgotPadssword","test");
			$login->addButton('Login','submit','login');
			$login->addButton('Create Account','','createAccount','btn-primary');
			$login->display();
		?>
	</div>

	<? include GENERAL_SCRIPTS ?>	
</body>



</html>