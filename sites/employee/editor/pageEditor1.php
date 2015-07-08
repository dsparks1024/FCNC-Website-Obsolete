<?	include($_SERVER['DOCUMENT_ROOT']."/globalConfig.php");
    include(DOMS_FRAMEWORK.'/Database/Database.php');

    $db = new Database(FCNC_MAINDB,'fcncmaindb','FCnc915','fcncmaindb');
    $db->setTable('pages');
    $result = $db->retrieve();
    $array = $result->getRow();
    
    
	if(isset($_POST['first'])){
	    $cat = array();
	    foreach($array as $row){
			if(!in_array($row['category'],$cat)){
				array_push($cat,$row['category']);
			}
		}
		
		$pageList = array();
		$html['body'] = '<link rel="stylesheet" type="text/css" href="/sites/employee/editor/css/pageEditor.css"/>';
		
	    
	    $html['body'] .= "<div class='well module'><h4>Choose a page to edit.</h4>";
	    
	    $html['body'] .= "<table><tr><td><select id='pageCategory'>
	    					<option>Please Select a Category</option>";
	    
	    foreach($cat as $category){
			$html['body'] .= "<option value=".$category.">".clean($category)."</option>";
	    }
		
		$html['body'] .= "</select></td>";
		
		$html['body'] .= "<td><select class='input-xlarge' id='pageList'><option>Please Choose a Category First</option>";
		$html['body'] .= "</select></td></tr></table></div>";
		$html['title'] = "Page Editor";
		$html['body'] .= "<script type='text/javascript' src='/sites/employee/editor/jQuery/pageEditor.js'></script>";
	   	$html['body'] .= "<div id='editorContainer'></div>";
	   	echo json_encode($html); 
   	}
   	
   	
   	if(isset($_POST['getPages'])){
   	   	$category = $_POST['category'];
   	   	$result = '<option>Please Select a Page</option>';
   	   	foreach($array as $page){
   	   		if($page['category'] == $category){
	   	   		$result .= "<option value=".$page['pageName'].">".clean($page['pageName'])."</option>";
   	   		}
   	   	}
   	   	echo $result;
	}
   	
  	if(isset($_POST['getPageInfo'])){
	  	$page = null;
	  	$result = null;
	  	foreach($array as $pageObject){
		  	if($pageObject['pageName'] == $_POST['pageName'] && $pageObject['category'] == $_POST['category']){
			  	$page = $pageObject;
		  	}
	  	}
	  	
	  	/* Page Settings HTML */
	  	
	  	$result['html'] .= '<div class="well module" id="pageSettings"><h4 class="wellTitle">Page Settings</h4>
	  				<form>
		  				<div class="">
							<label>Page Name:</label><input type="text"/ value="'.$page['pageName'].'">
							<label>Category:</label><input type="text"/ value="'.$page['category'].'">
							<label>Tags:</label><input type="text"/ value="'.$page['tags'].'">
						</div>
						<div class=""></div>
						<div class="">
							<label>Page Type:</label><select><optgroup><option>'.$page['type'].'</option></optgroup><option>page</option><option>subPage</option></select>
							<label>Sub Category:</label><input type="text"/ value="'.$page['subCategory'].'">
							<label>Page Parent:</label><input type="text"/ value="'.$page['parent'].'">
						</div>
						<div class=""></div>
						<div class="">
							<label>Custom Page:</label><select><optgroup><option>'.$page['customPage'].'</option></optgroup><option>true</option><option>false</option></select>
							<label>Page Structure Type:</label><select><optgroup><option>'.$page['structureType'].'</option></optgroup><option>default</option><option>formCenter</option><option>employeeMain</option></select>
							<label>Authorization to Edit:</label><select><optgroup><option>'.$page['authorization'].'</option></optgroup><option>admin</option><option>editor</option></select>
						</div>
					</form>
	  				</div>';
	  				
	  	/* Page layout HTML */
	  	
	  	$result['html'] .= "<div class='module well'><h4 class='wellTitle'>Page Layout</h4>
	  					<a class='btn layoutBtn' id='pageLayout'><img src='/sites/employee/editor/media/defaultLayout.png'/></a>
	  					<a class='btn layoutBtn' id='pageLayout'><img src='/sites/employee/editor/media/noImageLayout.png'/></a>
	  					<a class='btn layoutBtn' id='pageLayout'><img src='/sites/employee/editor/media/formCenterLayout.png'/></a>
	  				</div>";
	  	
	  	/* Page body editor */
	  				
	  	$result['html'] .= '<div class="module well"><h4 class="wellTitle">Page Body</h4><textarea id="bodyText">'.$page['body'].'</textarea></div>';
	  				
	  	$result['layout'] = $page['structureType'];
	  	$result['image'] = $page['headImage'];
	  	
	  	echo json_encode($result);
  	} 	
   	
   
   	
   	function clean($text){
		return ucwords(str_replace('_',' ',$text));
	}