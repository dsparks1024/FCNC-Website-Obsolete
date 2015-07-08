<?  session_start();
	
	$users = array('admin','editor');
	
	if((isset($_SESSION['username'])) && (in_array($_SESSION['auth'], $users))){
       echo "your good and authorized";       
    }else{
    	header("Location: /sites/employee/login.php?errorCode=auth");
    }
?>
