jQuery(document).ready(function($) {
	 $(".add-bets-wrap form, .form-add-meta form").submit(function(e){
	    return false;
	});
    $(".add-bets-wrap form").validate({
	    //debug: true,
	    invalidHandler: function(event, validator) {
		    $('.error-msg').addClass('active');
		},
		submitHandler: function(form) {
			 $.ajax({
				 	async: false,
			        type: 'POST',
					url: myajax.url,
					data: {
						action: 'add_post_bets',
		                post_title: $("input[name='post_title']").val(),
		                post_content: $("textarea[name='post_content']").val(),
		                type_bets: $("select[name='type_bets']").val()
					},
			        beforeSend: function(){
				        //$(".add-bets-wrap form input[type=submit]").val('Обработка...');
			        },
			        success: function (data) {
			           console.log('пост добавлен');
			           $('.msg-ok').addClass('active');
			
			        },
			        error: function(jqXHR, textStatus, errorThrown) {
			           console.log(textStatus, errorThrown);
			        }
			
			
			    });
			return false;
		}
	 });
	 
	 $(".form-add-meta form").validate({
	    //debug: true,
	    invalidHandler: function(event, validator) {
		    $('.error-msg').addClass('active');
		},
		submitHandler: function(form) {
			if(!$.cookie('add_meta_bets')){
				 $.ajax({
					 	async: false,
				        type: 'POST',
						url: myajax.url,
						data: {
							action: 'add_meta_bets',
			                meta_value: $("input[name='meta_value']").val(),
			                post_id: $("input[name='post_id']").val()
						},
				        beforeSend: function(){},
				        success: function (data) {
				           $('.msg-ok').addClass('active');
				           //$.cookie('add_meta_bets', true);
				
				        },
				        error: function(jqXHR, textStatus, errorThrown) {
				           console.log(textStatus, errorThrown);
				        }
				
				
				    });
			    } else {
				    $('.disabled').addClass('active');
			    }
			return false;
		}
	 });
});
