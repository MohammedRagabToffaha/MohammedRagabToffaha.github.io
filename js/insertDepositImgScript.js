
$(document).ready(function (e) {
	$("#form").on('submit',(function(e) {
		e.preventDefault();
		$("body").addClass("loadingAddInv");
		$.ajax({
        	url: "inserDepositImage.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			beforeSend : function()
			{
				//$("#preview").fadeOut();
				$("#err").fadeOut();
			},
			success: function(data)
		    {
				if(data=='invalid')
				{
					$("body").removeClass("loadingAddInv");
					// invalid file format.
					$("#err").html("اختار صوره وليس ملف").fadeIn();
				}
				else
				{
					// view uploaded file.
					$("#preview").html(data).fadeIn();
					$("#form")[0].reset();
					$("body").removeClass("loadingAddInv");	
				}
		    },
		  	error: function(e) 
	    	{
				$("#err").html(e).fadeIn();
				$("body").removeClass("loadingAddInv");
	    	} 	        
	   });
	}));
});

