<?  include($_SERVER['DOCUMENT_ROOT']."/globalConfig.php");
    include(DOMS_FRAMEWORK.'/Database/Database.php');

	$db = new Database(FCNC_MAINDB,'fcncmaindb','FCnc915','fcncmaindb');
	$db->setTable('employment');
	$results = $db->retrieve();
	
	
	if(isset($_POST['getPositions'])){
		 $positions = $results->getRow();
         $result = "<ul><li id='newJob'><i class='icon icon-plus'></i> New Positon...</li>";
         foreach($positions as $position){
			 $result.= '<li class="jobPosting" id="'.$position['id'].'">' . $position['position'] .
			 '<i id="'.$position['id'].'" class="icon icon-trash"></i></li>';
         }
         $result= $result ."</ul>";
         echo $result;   
	}
	
	if(isset($_POST['getDetails'])){
		$array['id'] = $_POST['id'];
		$job = $db->retrieveStrict($array)->getRow(0);
		
		$result = "<br><h4>You are editing the ".$job['position']." position</h4><form id='jobPostingForm'><table>";
		$result .= "<p>If there are more that one shift available for a certain position, create <b>seperate</b> job postings for each shift that is available. </p>";
		$result .= '<tr><td>Position: </td><td><input id="jobId" type="hidden" name="id" value="'.$job['id'].'"></input><input type="text" name="position" value="'.$job['position'].'"></input></td><td><p class="muted"> Enter the positions title</p></td></tr>';
		$result .= '<tr><td>Shift: </td><td><input type="text" name="shift" value="'.$job['shift'].'"></input></td><td><p class="muted"> <b> Please format the time formally ex: 11:00pm - 7:00am</b></p></td></tr></td></tr>';
		$result .= '<tr><td>Description: </td><td><textarea name="description" rows="5" columns="500">'.$job['description'].'</textarea></td><td><p class="muted"> Enter <b>ONLY</b> the details of this position</td></tr>';
		$result .= '<tr><td>Contact Name: </td><td><input type="text" name="contactName" value="'.$job['contactName'].'"></input></td><td><p class="muted"> Employee to contact with regards to the position. <b>Leave blank if not applicable</b></p></td></tr>';
		$result .= '<tr><td style="width: 100px;">Contact Phone: </td><td><input type="text" name="contactPhone" value="'.$job['contactPhone'].'"></input></td><td><p class="muted"> Employee to contact with regards to the position <b>Use facility\'s number if not applicable</b></p></td></tr>';
		$result .= '<tr><td>Contact Email: </td><td><input type="text" name="contactEmail" value="'.$job['contactEmail'].'"></input></td><td><p class="muted"> Employee to contact with regards to the position <b>Leave blank if not applicable</b></p></td></tr>';
		$result .= '<tr><td></td><td><button id="jobSubmit" class="btn btn-primary" type="submit">Save Changes</button></td></tr>';

		
		echo $result."</table></form>";
	}
	
	
	if(isset($_POST['submitJob'])){
		
		parse_str($_POST['formData'],$input);
		$postID = $input['id'];
		unset($input['id']);
		
		$fieldNames = array();
		$fieldValues = array();
		
		foreach($input as $key => $value){
			array_push($fieldNames, $key);
			array_push($fieldValues, $value);
		}
		
		$db->update('id',$postID,$fieldValues,$fieldNames);
	
	}
	
	if(isset($_POST['newJob'])){
		$numEntries = $db->field_count -1 ;
		$array = array();
		$array = array_fill(0, $numEntries, ' ');
		$array[0] = "New Position";
		$db->insert($array);
		echo "OK";
	}
	
	if(isset($_POST['deleteJob'])){
		$db->remove('id',$_POST['jobId']);
		echo "OK";
	}
		
?>
