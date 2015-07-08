$(document).ready(function(){
	
	var previousLink = null;
		windowBody = $("#content");
		windowTitle = $("#contentTitle");
	
	$(".navigation a").click(function(e){
		e.preventDefault();
		if(previousLink != null)
			previousLink.parent().removeClass("active");
		$(this).parent().addClass("active");
		previousLink = $(this);
	})
	
	$("#pageEditor").click(function(e){
		windowBody.html("");	
		windowBody.prepend(createTitle("Page Editor"));
		
		var script = '/sites/employee/editor/jQuery/pageEditor.js';
		$.getScript(script,function(){;});
		windowBody.append("<div id='pageList'/><div id='editingField'/>");
	})
	
	$("#jobEditor").click(function(e){
		windowBody.html("");
		windowBody.prepend(createTitle("Edit Job Openings"));
		
		var script = '/sites/employee/editor/jQuery/jobEditor.js';
		$.getScript(script,function(){;});
		windowBody.append("<div id='positionList'/><div id='editingField'/>");
		
	})
	
	
	
	
	
	/*
	$(".editor").click(function(e){
		
		if($(this).attr('id').indexOf('Editor') != -1){
			var script = $(this).attr('id');
			$.post("/sites/employee/editor/"+script+"1.php",{
				first: "first"
				},
				function(data){
					windowTitle.html(data.title);
					windowBody.html(data.body);
				},'json');
		}else{
			windowContainer.html("not an editor");
			
		}
	})
	*/
	
})

function createTitle(titleName){
	var title = "";
	title = "<h4 id='contentTitle' class='wellTitle muted'>"+ titleName +"</h4>";
	return title;
}