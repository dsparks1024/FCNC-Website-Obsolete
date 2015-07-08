<?

ini_set('error_reporting', E_ALL ^ E_NOTICE); 
ini_set('display_errors', 1);

if($_POST['submit'] != ''){

	 $PORT = 20222; //the port on which we are connecting to the "remote" machine
	 $HOST = "192.168.2.14"; //the ip of the remote machine (in this case it's the same machine)
	 
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
 
 }
 ?>

 <html>
 	<head>
 		<title>Garage Door Opener</title>
 		
 	<style>
	 	button{
		 	width: 85%;
		 	height: 100px;
		 	color: white;
		 	text-shadow: 1px 1px 3px black;
		 	font-weight: 700;
		 	background: -webkit-linear-gradient(#ffffff 0%, #c6c6c6 100%);
		 	font-size: 20pt;
		 	border-radius: 40px;
		 	margin:25px auto 0px auto;	 	
		}
		#btnContainer{
			margin-top: 75px;
			width: 100%;
			text-align: center;
		}
	 </style>
 	
 	</head>
 	<body>
	 	
	 	<meta name = "viewport" content = "width = device-width">
 		
 		<form action="client.php" method="post" accept-charset="utf-8">
	 		<div id="btnContainer">
	 			<button name="submit" value="houseLeft" type="submit">House Left Door</button></br>
	 			<button name="submit" value="houseMiddle" type="submit">House Middle Door</button></br>
	 			<button name="submit" value="houseRight" type="submit">House Right Door</button></br>
 			</div>
 		</form>
 	</body>
 </html>
 