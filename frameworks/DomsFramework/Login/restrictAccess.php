<?php
    session_start();

    if(isset($_SESSION['username'])){
        echo 'ur good';
    }else{
        echo 'get out';
    }

?>
