$(document).ready(function(){

	windowBody = $("#content");
	windowTitle = $("#contentTitle");
	editor = $('#editorContainer');
		
	/* Set up the initial editor */
	
	
	$('body').on("click",'input#mce_66-inp',function(){
		alert("test");
	})

		
	/* Get the list of pages of the selected category */
	
	$("#pageCategory").change(function(){
		$("#pageList").attr('disabled','true');
		$.post("/sites/employee/editor/pageEditor1.php",{
			getPages: 'getPages',
			category:  $(this).val()
		},
		function(html){
			$("#pageList").html(html);
			$("#pageList").removeAttr('disabled');	// Check to make sure that this works in all browsers!!!
		});
	});
	
	/* Initialize the editor with the values from that page */
	
	$("#pageList").change(function(){
		$.post("/sites/employee/editor/pageEditor.php",{
			getPageInfo: 'getPageInfo',
			pageName: $(this).val(),
			category: $("#pageCategory").val()
		},
		function(data){
		
			editor.html(data.html);
			tinymce.init({
				selector: "textarea",
				plugins: [
					"advlist autolink lists link image charmap print preview anchor",
					"searchreplace visualblocks code fullscreen",
					"insertdatetime media table contextmenu paste textcolor"
					],
				toolbar1: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
				toolbar2: "print preview media | forecolor backcolor emoticons",
			});
			
			if(data.layout == 'default'){
				editor.append("<div class='well module' id='headImageEditor'><h4 class='wellTitle'>Head Image</h4><div id='imageEditorContainer'><img id='headImage' src='" + data.image + "'/></div></div>");
			}
			
			$(".layoutBtn").bind('click','a',function(){
				$("#pageLayout").val('default');
			});
			
			//$("#pageSettings").slideUp();
			
			/* Image Manipulator */
	
									
		},'json');
	});
	
	
	
	
	
	/* Data manipulation stuff */
	
	/* Page operations and actions */
	
	
	
	
})