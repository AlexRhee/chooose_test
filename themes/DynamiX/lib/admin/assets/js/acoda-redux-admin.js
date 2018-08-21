(function($){
	
        'use strict';
	
		$(document).ready(function(e) {
            $( '#skin_select-select' ).select2();
        });
		
		
        $( '#skin_select-select' ).on(
            'change', function( e ) {
				e.preventDefault();	
        
       	        window.onbeforeunload = null;
				var skin = $(this).val();
				
				if( $(this).val() !== '' )
				{
					$( '.button.load-skin' ).removeClass('disabled').addClass('button-primary');
				}
					
									                
            }
        );	

        $( '.button.load-skin' ).on(
            'click', function( e ) {
				e.preventDefault();	
        
       	        window.onbeforeunload = null;
				var skin = $( '#skin_select-select' ).val(),
					optionName	= acoda_redux.opt_name.replace("_options", ""),
					ajax_url	= $( '#skin_select-select' ).attr('data-ajaxurl');
				
				$.ajax({
					  url: ajax_url,
					  type:'POST',
					  data:{
							action			: 'acoda_skin_update',
							skin			: skin,
					  },
					  success:function(data)
					  {
						window.onbeforeunload = null;
						//$('#redux_save').trigger('click');
						window.location.assign('themes.php?page='+ optionName +'_'+ skin );	
						$('body').addClass('skin-loading');	
					  }
				});						                
            }
        );

        $( '.button.delete-skin' ).on(
            'click', function( e ) {
				e.preventDefault();	
        
       	        window.onbeforeunload = null;
				var skin = $( '#skin_select-select' ).val(),
					optionName	= acoda_redux.opt_name.replace("_options", ""),
					ajax_url	= $( '#skin_select-select' ).attr('data-ajaxurl');

    			if (confirm("Are you sure you want to delete the "+ skin +" Skin?" ) == true) 
				{
					$.ajax({
						  url: ajax_url,
						  type:'POST',
						  data:{
								action			: 'acoda_skin_delete',
								skin			: skin,
						  },
						  success:function(skin)
						  {
							window.onbeforeunload = null;
							//$('#redux_save').trigger('click');
							window.location.assign('themes.php?page='+ optionName +'_'+ skin );	
							$('body').addClass('skin-loading');	
						  }
					});		
				}
            }
        );			

        $( '.button.new-skin' ).on(
            'click', function( e ) {
				e.preventDefault();	
        
       	        window.onbeforeunload = null;
				var skin = $( '#skin_select-select' ).val(),
					optionName	= acoda_redux.opt_name.replace("_options", ""),
					ajax_url	= $( '#skin_select-select' ).attr('data-ajaxurl');
				
				$('.acoda-new-skin').removeClass('hidden');
				$('.button.create-skin.duplicate').addClass('hidden');
				$('.button.create-skin.new').removeClass('hidden');
				$('.skin-select tr.skin-editor-row').removeClass('disable-border');				                
            }
        );

        $( '.button.duplicate-skin' ).on(
            'click', function( e ) {
				e.preventDefault();	
        
       	        window.onbeforeunload = null;
				var skin = $( '#skin_select-select' ).val(),
					optionName	= acoda_redux.opt_name.replace("_options", ""),
					ajax_url	= $( '#skin_select-select' ).attr('data-ajaxurl');
				
				$('.acoda-new-skin').removeClass('hidden');
				$('.button.create-skin.new').addClass('hidden');
				$('.button.create-skin.duplicate').removeClass('hidden');
				$('.skin-select tr').removeClass('disable-border');				                
            }
        );			

        $( '.button.create-skin.new' ).on(
            'click', function( e ) {
				e.preventDefault();	
        		
				if( $('#acoda-new-skin').val() !== '' )
				{		
					window.onbeforeunload = null;
					var skin = $( '#acoda-new-skin' ).val(),
						optionName	= acoda_redux.opt_name.replace("_options", ""),
						ajax_url	= $( '#skin_select-select' ).attr('data-ajaxurl');

					
					$.ajax({
						  url: ajax_url,
						  type:'POST',
						  data:{
								action			: 'acoda_skin_new',
								skin			: skin,
						  },
						  success:function(data)
						  {
							window.onbeforeunload = null;
							$('#redux_save').trigger('click');
							window.location.assign('themes.php?page='+ optionName +'_'+ skin );	
							$('body').addClass('skin-loading');	
						  }
					});	
				}
				else
				{
					$('#acoda-new-skin').attr('placeholder','Please enter a Skin name.');
				}
            }
        );	

        $( '.button.create-skin.duplicate' ).on(
            'click', function( e ) {
				e.preventDefault();	
        		
				if( $('#acoda-new-skin').val() !== '' )
				{		
					window.onbeforeunload = null;
					var skin = $( '#acoda-new-skin' ).val(),
						optionName	= acoda_redux.opt_name.replace("_options", ""),
						ajax_url	= $( '#skin_select-select' ).attr('data-ajaxurl');

					
					$.ajax({
						  url: ajax_url,
						  type:'POST',
						  data:{
								action			: 'acoda_skin_duplicate',
								skin			: skin,
						  },
						  success:function(data)
						  {
							window.onbeforeunload = null;
							$('#redux_save').trigger('click');
							window.location.assign('themes.php?page='+ optionName +'_'+ skin );	
							$('body').addClass('skin-loading');	
						  }
					});	
				}
				else
				{
					$('#acoda-new-skin').attr('placeholder','Please enter a Skin name.');
				}
            }
        );			

				
		
		$( '#acoda-new-skin' ).live('keypress', function (event)
		{
			var regex = new RegExp("^[a-zA-Z0-9]+$"),
				key = String.fromCharCode(!event.charCode ? event.which : event.charCode),
				inputStr = $( this ).val();
				
			if ( !regex.test(key) )
			{
			   event.preventDefault();
			   return false;
			}
		});		

        $( '.button.cancel' ).on(
            'click', function( e ) {
				e.preventDefault();	
     
				$('.acoda-new-skin,.button.create-skin.new,.button.create-skin.duplicate').addClass('hidden');
				$('.skin-select tr.skin-editor-row').addClass('disable-border');		
								                
            }
        );							

	
		$.fn.acodaImportDemo = function() {

			$("a.import-demo").delegate(this, "click", function() {
				var id = $(this).attr('href').replace( '#', '' ),
					message,
					pluginArr;

				message = acoda_redux.demo_data.message.replace(/[|]/g, '\n');

				pluginArr = acoda_redux.demo_data.demos[id].reqplugins.split("|");

				$.each(pluginArr, function( index, value )
				{
					message += '* ' + value + '\n';
				});


				if ( confirm( message ) == true) 
				{
					triggerImport(id);
				} 
				else 
				{
					return false;
				}  
			});


			var triggerImport = function(demoID) {
				var d = {
						action: "acoda_options_import_demo",
						demo_name: demoID,
						_ajax_nonce: $("#_ajax_nonce").val()
				};
				$('body').css('cursor', 'wait');

				 $('.ajax-message').html( acoda_redux.demo_data.wait ).fadeIn('fast');		




				$.ajax({
					url: ajaxurl,
					type:'POST',
					data:{
							action			: 'acoda_options_import_demo',
							demo_name		: demoID,
							_ajax_nonce	: $("#_ajax_nonce").val()
					},
					timeout: 60000,				
					success:function(data) {
						if (data == null)
						{
							var r = '<div class="message warning"><span>&nbsp;</span>The demo data could not be imported.</div>';

							$('.ajax-message').fadeIn('fast').html(r).delay(3000, function()
							{
								$('.ajax-message').fadeOut();
							});			
						} 
						else 
						{
							$('.ajax-message').html('<span class="dashicons dashicons-info"></span> The demo has been successfully installed. Please wait for the page to reload.<br /></br /><span class="dashicons dashicons-info"></span> If the menu doesn\'t display correctly, click Install once more to fix.' ).fadeIn('fast');

							setTimeout(function() {
								var general_tab = $('.group.general').attr('id');
								localStorage.setItem("activetab", '#'+ general_tab );
								window.location.reload();
							}, 5000);							
						}
					},
					error: function (xhr, ajaxOptions, thrownError) 
					{
						triggerImport( demoID );
					}				 
				});		

			}
		};

		$(document).ready(function () {
			$('.import-demo').acodaImportDemo();
		});	
		
  
})(jQuery);