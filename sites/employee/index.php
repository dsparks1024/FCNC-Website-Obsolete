<?  session_start();
	if(!isset($_SESSION['username'])){
        header("Location: /sites/employee/login.php?errorCode=notValid");
    }
    if($_SESSION['auth']=='user'){
	    if(isset($_GET['action'])){
		    header("Location: /sites/employee/login.php?errorCode=auth");
	    }
    }
    
    $root = $_SERVER['DOCUMENT_ROOT'];
    $editor = $root."/sites/employee/editor/";
    $action ='';
    $editorName ='';
?>

<?
	include_once($root."/globalConfig.php");
	include(DOMS_FRAMEWORK.'/Database/Database.php');
	include(DOMS_FRAMEWORK.'/HTML/CMSNavigation.php');
	include(DOMS_FRAMEWORK.'/HTML/CMSPage.php');
	include(DOMS_FRAMEWORK.'HTML/formBuilder.php');
	
	if(!isset($_GET['page'])){
		$_GET['page'] = 'main';
		$db = new Database(FCNC_MAINDB,'fcncmaindb','FCnc915','fcncmaindb');
		$page = new CMSPage($db,$_GET['page'],'employee'); // BUG: pages with the same name are indistinguishable.
	}
	
	if(isset($_GET['action'])){
		$action = $_GET['action'];
		$editorName = $_GET['editorName'];		 
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Employee Website</title>
		<? include(GENERAL_CSS); 
		   include(GENERAL_SCRIPTS);
		?>
		<link rel="stylesheet" type="text/css" href="/sites/employee/resources/css/employeeStyle.css"/>
		<link rel="stylesheet" type="text/css" href="/sites/employee/editor/css/pageEditor.css"/>
		
		
	
	</head>
	<body>
	<div id="wrap">

      <!-- Begin page content -->
      <div class="container">
        <div class="page-header">
          <h1>Forest City Nursing & Rehab Center</h1>
          <h3>Employee Website</h3>
        </div>
        
		<div id="contentContainer">	
			
			<div class="navigation">
				<? include_once($root."/sites/employee/resources/php/employeeNavigation.php") ?>
			</div>	
			
			<div id="rightSide">				
				
				<div class='span9 well' id="content">
				
				<? if($action!='editor'){
						$page->getBody();
						echo "<h4 id='contentTitle' class='wellTitle muted'>Announcements</h4>";
					}
					if($action=='editor'){
						echo "<h4 id='contentTitle' class='wellTitle muted'>Page Editor</h4>";
					}
				?>
					
								
				</div>
				
			</div><!--End rightSide div-->
			
		<div class="clear"></div>
		</div>		
				
		
        
		</div><!-- End container div-->
    </div><!-- End wrap div-->

    <div id="footer">
      <div class="container">
        <p class="muted credit"><a href="http://www.forestcitynursingcenter.com">www.ForestCityNursingCenter.com</a></p>
      </div>
    </div>
	
	<script type="text/javascript" src="/sites/employee/resources/jQuery/actionHandler.js"></script>
	<script type="text/javascript" src="/frameworks/tinymce/js/tinymce/tinymce.min.js"></script>
	
	</body>
</html>
