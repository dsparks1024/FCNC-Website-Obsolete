<?php
	
	 $PORT = 20222; //the port on which we are connecting to the "remote" machine
	 $HOST = "134.198.169.3"; //the ip of the remote machine (in this case it's the same machine)
	 
	 $sock = socket_create(AF_INET, SOCK_STREAM, 0) //Creating a TCP socket
	        or die("error: could not create socket\n");
	 $succ = socket_connect($sock, $HOST, $PORT) //Connecting to to server using that socket
	         or die("error: could not connect to host\n");
	  
	 $text = "Hello, Java!"; //the text we want to send to the server
	 echo "Connected to Server...";
	 socket_write($sock, $_POST['submit'] . "\n", strlen($text) + 1) //Writing the text to the socket
	         or die("error: failed to write to socket\n");
	 echo "Command wrote";
	 //$reply = socket_read($sock, 10000, PHP_NORMAL_READ) //Reading the reply from socket
	   //      or die("error: failed to read from socket\n");
	 
	 	 //echo $reply;

 ?>
