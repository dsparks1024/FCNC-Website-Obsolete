<?
	$user = $_SESSION['auth'];
	
	$nav = '<ul class="nav nav-pills nav-stacked well">
				<li class="nav-header"><i class="icon icon-file"></i> Useful Pages</li>
				<li><a id="home" href="/sites/employee/index.php">Home</a></li>
				<li><a id="#" href="#">View Calendar</a></li>
				<li><a id="#" href="#">Inservices</a></li>
				<li><a id="#" href="#">Maintenance Request</a></li>
				<li><a id="#" href="#">Downloads</a></li>';	
	
	if(($user=="editor")||($user=="admin")){
		$nav .= '<li class="nav-header"><i class="icon icon-pencil"></i> Content Management</li>
				 <li><a class="editor" id="pageEditor" href="/sites/employee/index.php?action=editor">Page Editor</a></li>
				 <li><a class="editor" id="jobEditor" href="?action=employment">Edit Job Openings</a></li>
				 <li><a class="editor" id="photoEditor" href="#">Edit Photo Galleries</a></li>
				 <li><a class="editor" id="fileEditor" href="#">Upload a File</a></li>
				 <li><a id="fileViewer" href="#">View Files</a></li>';
		$nav .= '<li class="nav-header"><i class="icon icon-search"></i> View Form Submissions</li>
				 <li><a href="#">Feedback</a></li>
				 <li><a href="#">Tour Appointments</a></li>
				 <li><a href="#">Contact</a></li>
				 <li><a href="#">Other Forms</a></li>';	
	}
	
	if($user=="admin"){
		$nav .= '<li class="nav-header"><i class="icon icon-cog"></i> Administration Functions</li>
			     <li><a href="#">Network Map</a></li>
			     <li><a href="#">User List</a></li>';
	}		
	
	$nav .= '</ul>';
	
	echo $nav;
?>