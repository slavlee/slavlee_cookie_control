###############################################################
# PLUGIN: CONTACTS - START
###############################################################
plugin.tx_slavlee_cookie_control {
	settings {
	  	include {
	  		# cat=Slavlee Cookie Control: Includes/100/100; type=boolean; label=Check to include jQuery library
	  		jQuery = 1
	  		# cat=Slavlee Cookie Control: Includes/100/110; type=boolean; label=Check to include Popper library
	  		Popper = 1
	  		# cat=Slavlee Cookie Control: Includes/100/120; type=boolean; label=Check to include Bootstrap 4 library
	  		Bootstrap4 = 1
		}
		# cat=Slavlee Cookie Control: Settings/100/100; type=boolean; label=Enable: Check to enable plugin
	  	enable = 1	  	
	  	# cat=Slavlee Cookie Control: Settings/100/110; type=int+; label=Privacy Page: Page Id of your privacy page
	  	privacyPage = 
	  	# cat=Slavlee Cookie Control: Settings/100/120; type=boolean; label=Tracking Tool: If you use any kind of tracking tool, like Google Analytics or Piwik, then enable this checkbox
	  	showTrackingInfo = 0
	  	# cat=Slavlee Cookie Control: Settings/100/130; type=options[simple,advanced]; label=Mode: The simple mode is a plain alert that informs the user about the usage of cookies. In the advanced mode the user can decide, if he want to use cookies. You can also set categories, in TypoScript, for the advanced mode to distinct the cookies.
	  	mode = simple	  	
	  	
	  	# cat=Slavlee Cookie Control: Settings/100/140; type=options[bottom]; label=Position:Position of the cookie consent
	  	position = bottom
	}
}