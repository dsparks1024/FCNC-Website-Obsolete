$(document).ready(function(){
	// Login Releated Stuff //
	$('#loginLink').fancybox();
	
	
		
	$('#login').click(function(e){
		e.preventDefault();
		username = $("#username");
		password = $("#password");
		login = $("#login");
		errorMsg = $('#'+password.attr('id')+'Help');
		
		username.parent().parent().removeClass("error");
		password.parent().parent().removeClass("error");
		errorMsg.html(' ');
		errorMsg.removeClass('error');
		
		
		dataString = 'username=' + username.val() + '&password=' + password.val() + '&login=' + login.val();

		$.ajax({
			type: "POST",
			url: "/frameworks/DomsFramework/Login/secureLogin.php",
			data: dataString,
			success: function(response){
				if (response == "valid"){
					window.location.replace("/sites/employee/index.php");
				}else{
					username.parent().parent().addClass("error");
					password.parent().parent().addClass("error");
					errorMsg.html('Invalid Username/Password').addClass('error');
				}
			}
		});
	});
	// End of Login 
	
	
	
	function getUrlVar(variable){
		var query = window.location.search.substring(1);
		var vars = query.split("&");
		for (var i=0;i<vars.length;i++) {
			var pair = vars[i].split("=");
			if(pair[0] == variable){return pair[1];}
		}
		return(false);
	}
	
	

})