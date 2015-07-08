<!DOCTYPE html>
<html>
<meta charset="utf-8">

<head>

	<?  include ($_SERVER['DOCUMENT_ROOT'].'/globalConfig.php');
		include(DOMS_FRAMEWORK.'/Database/Database.php');
		include(DOMS_FRAMEWORK.'/HTML/CMSNavigation.php');
		include(DOMS_FRAMEWORK.'/HTML/CMSPage.php');
		include(DOMS_FRAMEWORK.'/HTML/formBuilder.php');
		
		if(!isset($_GET['page'])){
			$_GET['page'] = 'main';
		}
		/*if(!isset($_GET['category'])){
			$_GET['category']= 'info';
		}*/
		
		$db = new Database(FCNC_MAINDB,'fcncmaindb','FCnc915','fcncmaindb');
		
		$nav = new CMSNavigation($db,$_GET['category']);
		$page = new CMSPage($db,$_GET['page'],$_GET['category']); // BUG: pages with the same name are indistinguishable.	 
		$form = new formBuilder('nowhere');
	?>

	<title>Nursing Center Home Page</title>
	
	<? include GENERAL_CSS;?>
	<link rel="stylesheet" type="text/css"  href="resources/css/main.css"/>
	
</head>

<body>

<div id="container">

   <div id="header">
   		<? include TOP_NAV ?>
   </div>
   
   <div id="body">
	   
	   <div id="content">   	   
	   	   
	   <div id="leftNav">
	   		<? $nav->display(); ?>
	   </div>
	   
	   	  <? $page->getImageAndText(300,700);?>

	   <div id="pageContent">
	   	<? $page->getBody() ?>
	   </div> 
	   	
	   <div class="clear"></div>
	   </div> <!-- End Content -->
   </div> <!-- End body div -->
   
   <? include FOOTER ?>
</div>
	<? include(GENERAL_SCRIPTS) ?>
</body>

</html>