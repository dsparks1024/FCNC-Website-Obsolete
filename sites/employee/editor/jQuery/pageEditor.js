$(document).ready(function(){
	
	var script = "/sites/employee/editor/pageEditor.php";
		pageList = $("#pageList");
		editingField = $("#editingField");
		pageInfo = null;
	getPageList();
	
	
	// Set up the page editor
	$("#rightSide").delegate(".pageName","click",function(){
		$.post(script,{getPageInfo:1,id:$(this).attr('id')},function(data){
			editingField.html(data.form);
			loadEditor($('#structureType').val());
			pageInfo = data.pageInfo;
		},'json');
	});
	// Update the editor based on the page layout
	$("#rightSide").delegate("#structureType","change",function(){
		loadEditor($('#structureType').val());
	})
	
	// Toggle the display of the advanced page settings
	$('#rightSide').delegate('#showAdvancedSettigns',"click",function(){
		$('.advancedSettings').fadeToggle();
	})
	


/************************************************
 ************ Utility Funcitons *****************
 ************************************************/

	function getPageList(){
		$.post(script,{getPageList:1},function(html){
			pageList.html(html);
		});
	}
	
	function loadEditor(editorType){
		console.log(pageInfo);
		var editor = $("#formEditor");
		
		if(editorType == 'default'){
			
		}
		if(editorType == 'noImage'){
			$.post(script,{noImage:1},function(html){
				editor.html(html);
			});
		}
		if(editorType == 'formCenter'){
			
		}
	}

})