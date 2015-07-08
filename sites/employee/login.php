<?	
	session_start();
	include($_SERVER['DOCUMENT_ROOT'].'/globalConfig.php'); 
	include(DOMS_FRAMEWORK.'/HTML/formBuilder.php');	
	
	$login = new formBuilder('/frameworks/DomsFramework/Login/secureLogin.php');
	$login->addTextInput('Username','Username','text','username','input-medium');
	$login->addTextInput('Password','Password','password','password','input-medium');
	$login->addLinkText("Forgot Password?","forgotPadssword","test");
	$login->addButton('Login','submit','login');
	$login->addButton('Create Account','','createAccount','btn-primary');
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		
		<link rel="stylesheet" type="text/css" href="/frameworks/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/globalResources/css/general.css"/>
		
		<style type="text/css">
			#loginContainer{
				width: 390px;
				margin: auto;
				margin-top: 15%;
				border: thin solid gray;
				border-radius: 5px;
				box-shadow: 5px 5px 5px 1px gray;
			}
		</style>
	</head>
	<body>
		<div id="loginContainer" class="form">
			<h3>Employee Login</h3>
			<? $login->display(); ?>
		</div>
		<? include GENERAL_SCRIPTS ?>
	</body>
</html>
