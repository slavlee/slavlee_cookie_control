"use strict";

/**
 * Cookie Control
 * (c) 2017 Kevin Chileong Lee <support@slavlee.de>, Slavlee
 */
(function( $ ) { 
    // Plugin definition.
    $.fn.slavlee_cookie_control = function( options ) {
		var ssc = this;
		
    	// Toggle Plugin
    	$(this).find("#scc-cookiesettings").click(function(){
    		$(this).closest(".scc").removeClass("scc--minify");
			$(this).closest(".scc-overlay").removeClass("scc--minify");
    		$(this).siblings(".alert").removeClass("d-none");
    		$(this).addClass("d-none");
			
			// Add padding, when layout is bottom and cookie consent is shown
			setTimeout(function(){
				addPaddingBottom(ssc);
			}, 250);			
    	});    

		// Add padding, when layout is bottom and cookie consent is shown
		if ($(this).hasClass("scc-position--bottom") && !$(this).hasClass("scc--minify"))
		{
			addPaddingBottom(this);
		}
		
		// Observe modal
		if ($("#scc-moreinfo").length > 0)
		{
			// Hide scc-overlay, when modal is about to show
			$("#scc-moreinfo").on("show.bs.modal", function(e){
				var overlay = $("#scc-moreinfo").prev(".scc-overlay");
				
				if ($(overlay).length > 0)
				{
					$(overlay).css("background", "none");
				}
			});
			
			// Submit Form when closed to save changed
			$("#scc-moreinfo").on("hidden.bs.modal", function(e){
				// Submit form, when closed
				$(this).find("form").submit();
			});
			
			// if a service is unchecked, then uncheck category as well
			$("#scc-moreinfo").find(".scc-widget--categorysettings-content input[type='checkbox']").click(function(){
				var categoryCheckbox = $(this).closest(".scc-widget--categorysettings-content").prev(".scc-widget--categorysettings-header").find("input[type='checkbox']");
				
				if ($(categoryCheckbox).length > 0)
				{
					if (!$(this).is(":checked"))
					{
						$(categoryCheckbox).prop("checked", false);
					}else
					{
						// if service is checked, then check if all services are checked
						if (checkIfAllServicesAreChecked($(this)))
						{
							// If so, then check the category
							$(categoryCheckbox).prop("checked", true);
						}
					}
				}else
				{
					console.error("Category checkbox could not be found in the modal box for selected service.");
				}
			});
			
			// if the categoy is checked, then check all services as well
			$("#scc-moreinfo").find(".scc-widget--categorysettings-header input[type='checkbox']").click(function(){
				if (!$(this).is(":checked"))
				{
					$(this).closest(".scc-widget--categorysettings-header").next(".scc-widget--categorysettings-content").find("input[type='checkbox']").prop("checked", false);
				}else
				{
					$(this).closest(".scc-widget--categorysettings-header").next(".scc-widget--categorysettings-content").find("input[type='checkbox']").prop("checked", true);
				}
			});
		}
    };

	/**
	 * Add padding, when layout is bottom and cookie consent is shown
	 * @param jQuery cObj
	 * @return void
	 */
	function addPaddingBottom(cObj)
	{
		$("body").css("padding-bottom", $(cObj).outerHeight());
	}
	
	/**
	 * Check if all services of the category of given service is checked
	 * @param jQuery serviceCheckbox
	 * @return bool
	 */
	function checkIfAllServicesAreChecked(serviceCheckbox)
	{
		var parent = $(serviceCheckbox).closest(".scc-widget--categorysettings-content");
		var hasUncheckedServices = false;
		
		if ($(parent).length > 0)
		{
			$(parent).find("input[type='checkbox']").each(function(){
				if (!$(this).prop("checked"))
				{
					hasUncheckedServices = true;
					return false;	// end loop
				}
			});
		}
		
		return !hasUncheckedServices;
	}
        
    $(document).ready(function(){
    	/* Init memory Plugin */
		$(".scc").slavlee_cookie_control();
	});
})( jQuery );