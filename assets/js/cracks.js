jQuery(document).ready(function($){
	var searchValue = $("#s").val();
	var commentValue = $("#comment").val();
	var authorValue = $("#author").val();
	var emailValue = $("#email").val();
	var urlValue = $("#url").val();
        var menu = $("#menu");

        //dropdown menu
        menu.supersubs({
                minWidth: 8,
                maxWidth: 27,
                speed:  'fast'
            }
        ).superfish({
                speed:  'fast',
                animation:  {opacity:'show',height:'show'},
                delay:  0,
                dropShadows:    false,
                autoArrows: false
        });

	//search
	$("#s").focus(function () {
		if($(this).val() == searchValue)
			$(this).val("");
	});	
	$("#s").blur(function () {
		if($(this).val() == "")
			$(this).val(searchValue);
	});
	
	//comments textarea focus / blur
	$("#commentform #comment").focus(function () {
		if($(this).val() == commentValue)
			$(this).val("");
	});	
	$("#commentform #comment").blur(function () {
		if($(this).val() == "")
			$(this).val(commentValue);
	});
	$("#commentform #author").focus(function () {
		if($(this).val() == authorValue)
			$(this).val("");
	});	
	$("#commentform #author").blur(function () {
		if($(this).val() == "")
			$(this).val(authorValue);
	});
	$("#commentform #email").focus(function () {
		if($(this).val() == emailValue)
			$(this).val("");
	});	
	$("#commentform #email").blur(function () {
		if($(this).val() == "")
			$(this).val(emailValue);
	});
	$("#commentform #url").focus(function () {
		if($(this).val() == urlValue)
			$(this).val("");
	});	
	$("#commentform #url").blur(function () {
		if($(this).val() == "")
			$(this).val(urlValue);
	});
	
	//test fields
	$("#commentform #submit").click(function(){
		if($("#comment").val() == "" || $("#author").val() == "" || $("#email").val() == "" || $("#comment").val() == "Write your message here..." || $("#author").val() == "Name" || $("#email").val() == "Email"){
			//highlight wrong fields
			if($("#comment").val() == "" || $("#comment").val() == "Write your message here...")
				$("#comment").css('border-color','#252525');
			if($("#author").val() == "" || $("#author").val() == "Name")
				$("#author").css('border-color','#252525');
			if($("#email").val() == "" || $("#email").val() == "Email")
				$("#email").css('border-color','#252525');

			return false;
		}
	});
});