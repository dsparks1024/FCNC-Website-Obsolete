<?  include($_SERVER['DOCUMENT_ROOT']."/globalConfig.php");
    include(DOMS_FRAMEWORK.'/Database/Database.php');


			ini_set('error_reporting', E_ALL ^ E_NOTICE); 
			ini_set('display_errors', 1);	

    $db = new Database(FCNC_MAINDB,'fcncmaindb','FCnc915','fcncmaindb');
    $db->setTable('pages');
    $result = $db->retrieve();
    $allPages = $result->getRow();

	// Query the DB and get the list of pages that are editable
	// Sort them into category, display them based on subcategory under their main category
	
	if(isset($_POST['getPageList'])){
	
		$mainCat = array();
		$subCat = array();
		
		foreach($allPages as $page){
			array_push($mainCat, $page['category']);
			array_push($subCat, $page['subCategory']);
		}
		
		$mainCat = array_unique($mainCat);
		$subCat = array_unique($subCat);
		
		foreach($allPages as $page){
			
		}
		
		$result = '<h3>Select a page to edit.</h3>';
		foreach($mainCat as $cat){
			$result .= "<div class='category'><h4>".clean($cat)."</h4>";
			
			foreach($allPages as $page){
				if($page['category'] == $cat){
					$result .= " <span class='pageName' id='".$page['id']."'>".clean($page['pageName'])."</span></br>";						
				}
			}
			$result .= "</div>";	
		}
		echo $result."<div class='clear'></div>";
	}
	
	// Return the requested page's details
	if(isset($_POST['getPageInfo'])){
		$page = $db->retrieve('id',$_POST['id'])->getRow(0);
		$result = "<h3>You are editing the ".clean($page['pageName'])." page.</h3><table>";
		$result .= "<tr><td><input name ='id' type='hidden' value='".$page['id']."'></input>";
		$result .= "Page Name:</td><td><input disabled name ='pageName' class='input-xlarge' type='text' value='".$page['pageName']."'></input></td></tr>";
		// Set up the page layout chooser
		$result .= "<tr><td>Page Layout: </td><td>
			<select name='structureType' id='structureType'>
				<option value='".$page['structureType']."'>".clean($page['structureType'])."</option>
				<optgroup>
				<option value='default'>Default</option>
				<option value='noImage'>No Image</option>
				<option value='formCenter'>Form Center</option>
				</optgroup>
			</select>
		<button id='showAdvancedSettigns'><i class='icon icon-cog'></i></button>    </td></tr>";
		
		// Advanced Page Settings
		$result .= "<tr class='advancedSettings'><td>Category</td><td><input name ='category' type='text' value='".$page['category']."'></td></tr>";
		$result .= "<tr class='advancedSettings'><td>Page Tags</td><td><input name ='tags' type='text' value='".$page['tags']."'></td></tr>";
		$result .= "<tr class='advancedSettings'><td>Page Parent</td><td><input name ='parent' type='text' value='".$page['parent']."'></td></tr>";
		$result .= "<tr class='advancedSettings'><td>Page Sub Category</td><td><input name ='subCategory' type='text' value='".$page['subCategory']."'></td></tr>";		
		$result .= "<tr class='advancedSettings'><td>Page Type</td><td><input name ='type' type='text' value='".$page['type']."'></td></tr>";	
		
		
		$result .= "<tr><td>Page Body</td><td><textarea rows='4' class='input-xlarge'>".$page['body']."</textarea></td></tr>";	
		
		$result.= "</table><div id='formEditor'/>";
		$response['form'] = $result;
		$response['pageInfo'] = $page;
		echo json_encode($response);
		
	}
	
	//


	function clean($text){
		return ucwords(str_replace('_',' ',$text));
	}
?>