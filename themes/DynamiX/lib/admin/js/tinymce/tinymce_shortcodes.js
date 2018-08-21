
/* :: acoda tinymce shortcodes							      
---------------------------------------------*/

(function() {
"use strict";   
 
	tinymce.PluginManager.add( 'acoda_shortcodes', function( editor, url ) {
     
		editor.addButton( 'acoda_shortcodes', { 
			type : 'menubutton',
			icon: 'acoda_shortcodes',
			onclick : function(e) {},
			menu: [
				{text: 'Button', icon: 'acoda_button', onclick: function() {editor.insertContent('[vc_btn title="VIEW" style="flat" align="left" shape="square" link="url:acoda.com"]');}},
				{text: 'Icon', icon: 'acoda_fonticon', onclick: function() {editor.insertContent('[vc_icon icon_fontawesome="fa fa-comment" background_style="boxed rounded rounded-less" size="lg" background_color="custom" custom_background_color="#ffd500" align="left"]');}},
				{text: 'Social Icons', icon: 'acoda_social_icons', onclick: function() {editor.insertContent('[socialwrap align="center"] \
								[socialicon name="fb" url="" ][/socialicon]\
								[socialicon name="linkedin" url="" ][/socialicon]\
								[socialicon name="twitter" url="" ][/socialicon]\
								[socialicon name="google" url="" ][/socialicon]\
								[socialicon name="rss" url="" ][/socialicon]\
								[socialicon name="youtube" url="" ][/socialicon]\
								[socialicon name="vimeo" url="" ][/socialicon]\
								[socialicon name="pinterest" url="" ][/socialicon]\
								[socialicon name="soundcloud" url="" ][/socialicon]\
								[socialicon name="instagram" url="" ][/socialicon]\
								[socialicon name="flickr" url="" ][/socialicon]\
								[socialicon name="email" url="" ][/socialicon]\
								[/socialwrap]');}},
				{text: 'Facebook Like', icon: 'acoda_facebook', onclick: function() {editor.insertContent('[vc_facebook type="standard,button_count,box_count"]');}},		
				{text: 'Tweet Me', icon: 'acoda_tweetme', onclick: function() {editor.insertContent('[vc_tweetmeme type="horizontal,vertical,none"]');}},	
				{text: 'Google +', icon: 'acoda_googleplus', onclick: function() {editor.insertContent('[vc_googleplus type="standard,small,medium,tall" annotation="inline,bubble,none"]');}},
				{text: 'Pinterest', icon: 'acoda_pinterest', onclick: function() {editor.insertContent('[vc_pinterest]');}},	
				{text: 'List', icon: 'acoda_list', onclick: function() {editor.insertContent('[list style="arrow,bullet,check,cross" color="blue-lite"] \
								<ul>\
								<li>List Item</li>\
								<li>List Item</li>\
								<li>List Item</li>\
								</ul>\
								[/list]');}},	
				{text: 'Toggle', icon: 'acoda_toggle', onclick: function() {editor.insertContent('[vc_toggle title="Toggle title" style="default" color="Default" size="md" open="false"]Toggle content goes here, click edit button to change this text.[/vc_toggle]');}},											
			]
		});
         
	});
        
})(jQuery);