// TODO: Add acknolegments after completed actions such as saving, deleting etc.
// 		 Remove the alert() in the some of the call back functions.
//		 Add some CSS styling to the jobList, add pointer, remove bullets, add uniform spacing for the trash cans



$(document).ready(function(){

	/* This code will be called when the user clicks on the
	** link in the navigation bar. It should be used to set
	** up the basic functionality of this specific page.
	*/
	var site = "/sites/employee/editor/jobEditor.php";
		positionList = $("#positionList");
		editingField = $("#editingField");
	
	getJobList();

	
	/* This code will be call when the user interacts with the
	** page that was created from the code above. This code 
	** should hanld post requests to send data back to the 
	** user's front end. 
	*/
	
	$("#rightSide").delegate(".jobPosting","click",function(){
		$.post(site,{
			getDetails: 1,
			id : $(this).attr('id')
		},
		function(html){
			editingField.html(html);
		});
	});
	
	$("#rightSide").delegate("#jobSubmit","click",function(e){
		e.preventDefault();
		
		$.post(site,{
			submitJob: 1,
			formData: $("#jobPostingForm").serialize()
		},
		function(html){
			alert(html);
		});
	});
	
	$("#rightSide").delegate("#newJob","click",function(e){
		e.preventDefault();
		$.post(site,{newJob:1},function(html){
			if(html == "OK"){
				getJobList();
			}		
		});		
	});
	
	$("#rightSide").delegate(".icon-trash","click",function(){
		$.post(site,{
			deleteJob: 1,
			jobId: $(this).attr('id')
		},
		function(html){
			getJobList();
			$("#editingField").html('');
		});
	});
	
	function getJobList(){
		$.post(site,{getPositions:1,},function(html){positionList.html(html);});
	}
})