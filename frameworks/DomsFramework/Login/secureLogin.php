<?php
if(!session_start()){
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'].'/frameworks/DomsFramework/Database/Database.php';


/**
 * This script securly logs a user into the system.
 *
 * @author Dominick Sparks
 */

// 1. Obtain input
        
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    $db = new Database("fcncmaindb.db.6441590.hostedresource.com", "fcncmaindb","FCnc915", "fcncmaindb");


// 1.1 Sanitize input

// 2. Validate user credentials
    
    if($username =='' || $password==''){
        echo('no input');
    }else{
        validateUser($username,$password,$db);
    }
// 3. Log user in
    
    
    function validateUser($username,$password,$db){
       $query = $db->query("SELECT * FROM users WHERE `username`='$username'");
       
       if($query->num_rows != 1){
           echo('wrong');
       }else{
           $array = $query->fetch_assoc();
           if($password == $array['password']){
               $auth = $array['authorization'];
               logUserIn($username,$auth);
               echo'valid';
               //header("Location: /sites/employee/index.php");
           }else{
               echo 'notFound';
           }
       }
        
    }
    
    function logUserIn($username,$auth){
        $_SESSION['username'] = $username;
        $_SESSION['auth'] = $auth;
    }

?>
