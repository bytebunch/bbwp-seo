(function( $ ){
  $.fn.bytebunchTabbedMenu = function(options) {
	  var settings = $.extend( {
		  active : 0,
		  active_link_class : "current-menu-item",
		  active_container_class : "current-content-cantainer"
		}, options);
		
		this.find("li").slice(settings.active,settings.active+1).addClass(settings.active_link_class);
		var current_tab = this.find("li").slice(settings.active,settings.active+1).find("a").attr("href");
		$(current_tab).addClass(settings.active_container_class);
		
	  this.find("li a").click(function(e){
        
		  $(this).parent().parent().find("li").removeClass(settings.active_link_class);
		  $(this).parent("li").addClass(settings.active_link_class);
		  $("."+settings.divclass).removeClass(settings.active_container_class);
		  var current_tab = $(this).attr("href");
		  $(current_tab).addClass(settings.active_container_class);
	   	  e.stopPropagation(); e.preventDefault();
	  });
  };
})( jQuery );
jQuery(document).ready(function($){
   
   $("ul.tabbed_menu").bytebunchTabbedMenu({divclass: "tab_menu_content",active:0});
});








/* *********************** */
/* wordpress image uploader */
/* *********************** */

jQuery(document).ready(function($) {
   var bytebunch_seo_wp_uploader;
    $(".bytebunch_seo_image_upload_button").on("click",function(e){
			inputobject = $(this).parent().find("input[type='text']");
			e.preventDefault();
			
			if (bytebunch_seo_wp_uploader) {
				bytebunch_seo_wp_uploader.open();
				return;
			}
			
			
			//Extend the wp.media object
			bytebunch_seo_wp_uploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose File',
				button: {
					text: 'Choose File'
				},
				multiple: false
			});
			
			//When a file is selected, grab the URL and set it as the text field's value
			bytebunch_seo_wp_uploader.on('select', function() {
				attachment = bytebunch_seo_wp_uploader.state().get('selection').first().toJSON();
				inputobject.val(attachment.url);
			});
	 
			//Open the uploader dialog
			bytebunch_seo_wp_uploader.open();
			return false;
	});
});