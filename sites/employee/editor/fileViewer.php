<?  session_start();
	
	$users = array('admin','editor');
	
	if(!((isset($_SESSION['username'])) && (in_array($_SESSION['auth'], $users)))){
    	header("Location: /sites/employee/login.php?errorCode=auth");      
    }
?>

<div class='span9 well'>
	<h4 class="wellTitle muted">File Viewer</h4>
</div>