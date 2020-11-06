###############################################################
# PLUGIN: CONTACTS - START
###############################################################
plugin.tx_slavlee_cookie_control {
  view {
    templateRootPaths.0 = EXT:slavlee_cookie_control/Resources/Private/Templates/
    templateRootPaths.1 = plugin.tx_slavlee_cookie_control.view.templateRootPath
    partialRootPaths.0 = EXT:slavlee_cookie_control/Resources/Private/Partials/
    partialRootPaths.1 = plugin.tx_slavlee_cookie_control.view.partialRootPath
    layoutRootPaths.0 = EXT:slavlee_cookie_control/Resources/Private/Layouts/
    layoutRootPaths.1 = plugin.tx_slavlee_cookie_control.view.layoutRootPath
  }
  persistence {
    storagePid = plugin.tx_slavlee_cookie_control.persistence.storagePid
    #recursive = 1
  }
  features {
    #skipDefaultArguments = 1
  }
  mvc {
    #callDefaultActionIfActionCantBeResolved = 1
  }
  settings {
  	include {
  		jQuery = {$plugin.tx_slavlee_cookie_control.settings.include.jQuery}
  		Popper = {$plugin.tx_slavlee_cookie_control.settings.include.Popper}
  		Bootstrap4 = {$plugin.tx_slavlee_cookie_control.settings.include.Bootstrap4}
	}
  	enable = {$plugin.tx_slavlee_cookie_control.settings.enable}  	
  	privacyPage = {$plugin.tx_slavlee_cookie_control.settings.privacyPage}
  	usingTrackingTool = {$plugin.tx_slavlee_cookie_control.settings.usingTrackingTool}
  	mode = {$plugin.tx_slavlee_cookie_control.settings.mode}
  	position = {$plugin.tx_slavlee_cookie_control.settings.position}
  	categories {
  		10 {  			
  			enable = 1
  			mandatory = 1
  			label = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:category.necessary.label
  			services = php
  		}
  		20 {
  			enable = 1
  			mandatory = 0
  			label = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:category.functional.label
  			services = typo3_felogin,typo3_belogin,youtube,vimeo
  		}
  		30 {
  			enable = 0
  			mandatory = 0
  			label = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:category.marketing.label
  			services = googleads
  		}
  		
  		40 {
  			enable = 0
  			mandatory = 0
  			label = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:category.statistics.label
  			services = googleanalytics
  		}
  	}
	cookies {
		PHPSESSID {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies.phpsessid
			type = session
			expiration {
				type = endofbrowser
			}
		}
		fe_typo_user {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies.fe_typo_user
			type = session
			expiration {
				type = endofbrowser
			}
		}	
		be_typo_user {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies.be_typo_user
			type = session
			expiration {
				type = endofbrowser
			}
		}
		be_lastLoginProvider {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies.be_lastLoginProvider
			type = session
			expiration {
				type = endofbrowser
			}
		}
		_ga {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies._ga
			type = permanent
			expiration {
				type = years
				value = 2
			}
		}
		_gat {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies._gat
			type = permanent
			expiration {
				type = years
				value = 2
			}
		}
		_gid {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies._gid
			type = permanent
			expiration {
				type = hours
				value = 24
			}
		}
		__utma {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies.__utma
			type = permanent
			expiration {
				type = years
				value = 2
			}
		}
		__utmt {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies.__utmt
			type = permanent
			expiration {
				type = minutes
				value = 10
			}
		}
		__utmb {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies.__utmb
			type = permanent
			expiration {
				type = minutes
				value = 30
			}
		}
		__utmc {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies.__utmc
			type = session
			expiration {
				type = endofbrowser
			}
		}
		__utmz {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies.__utmz
			type = permanent
			expiration {
				type = minutes
				value = 6
			}
		}
		__utmv {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies.__utmv
			type = permanent
			expiration {
				type = years
				value = 2
			}
		}
		__utmx {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies.__utmx
			type = permanent
			expiration {
				type = months
				value = 18
			}
		}
		__utmxx {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies.__utmxx
			type = permanent
			expiration {
				type = months
				value = 18
			}
		}
		_gaexp {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies._gaexp
			type = permanent
			expiration {
				type = days
				value = 9
			}
		}
		_opt_awcid {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies._opt_awcid
			type = permanent
			expiration {
				type = hours
				value = 24
			}
		}
		_opt_awmid {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies._opt_awmid
			type = permanent
			expiration {
				type = hours
				value = 24
			}
		}
		_opt_awgid {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies._opt_awgid
			type = permanent
			expiration {
				type = hours
				value = 24
			}
		}
		_opt_awkid {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies._opt_awkid
			type = permanent
			expiration {
				type = hours
				value = 24
			}
		}
		_opt_utmc {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies._opt_utmc
			type = permanent
			expiration {
				type = hours
				value = 24
			}
		}
		test_cookie {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies.test_cookie
			type = permanent
			expiration {
				type = minutes
				value = 15
			}
		}
		IDE {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies.IDE
			type = permanent
			expiration {
				type = months
				value = 12
			}
		}
		_gcl_au {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies._gcl_au
			type = permanent
			expiration {
				type = days
				value = 90
			}
		}
		_gcl_aw {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies._gcl_aw
			type = permanent
			expiration {
				type = days
				value = 2
			}
		}
		player {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies.player
			type = permanent
			expiration {
				type = months
				value = 12
			}
		}
		vuid {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies.vuid
			type = permanent
			expiration {
				type = years
				value = 2
			}
		}
		_abexps {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies._abexps
			type = permanent
			expiration {
				type = months
				value = 12
			}
		}
		continuous_play_v3 {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies.continuous_play_v3
			type = permanent
			expiration {
				type = months
				value = 12
			}
		}
		_fbp {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies._fbp
			type = permanent
			expiration {
				type = months
				value = 3
			}
		}
	}
	
	services {
		php {
			enable = 1
			name = PHP
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:services.php
			urls = 
			cookies = PHPSESSID
		}
		
		typo3_felogin {
			enable = 1
			name = TYPO3 Frontend
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:services.typo3_felogin
			urls = 
			cookies = fe_typo_user
		}
		
		typo3_belogin {
			enable = 1
			name = TYPO3 Backend
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:services.typo3_belogin
			urls = 
			cookies = be_typo_user
		}
		
		googleads {
			enable = 0
			name = Google Ads
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:services.googleads
			urls = googlesyndication.com,doubleclick.net			
			cookies = test_cookie,IDE,_gcl_au,_gcl_aw
		}
		
		googleanalytics {
			enable = 0
			name = Google Analytics
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:services.googleanalytics
			urls = googletagmanager.com
			cookies = _gaexp,_opt_utmc,_opt_awcid,_opt_awmid,_opt_awgid,_opt_awkid,_ga,_gid
		}
		
		googlefonts {
			enable = 0
			name = Google Fonts
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:services.googlefonts
			urls = fonts.googleapis.com,gstatic.com			
			cookies =
		}
		
		youtube {
			enable = 0
			name = YouTube
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:services.youtube
			urls = youtube.com,youtube-nocookie.com			
			cookies =
		} 
		
		vimeo {
			enable = 0
			name = Vimeo
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:services.vimeo
			urls = player.vimeo.com			
			cookies = player,vuid,_abexps,continuous_play_v3,_ga,_gcl_au,_fbp
		}
		
		
		
	}
  }
}
###############################################################
# PLUGIN: CONTACTS - END
###############################################################
###############################################################
# PAGE - START
###############################################################
# Include Slavlee Cookie Control
page.5 = USER
page.5 {
	userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
    extensionName = SlavleeCookieControl
    pluginName = Slavleecookiecontrol
    vendorName = Slavlee
    controller = SlavleeCookieControl
    action = show
    view < plugin.tx_slavlee_cookie_control.view
    persistence < plugin.tx_slavlee_cookie_control.persistence
    settings < plugin.tx_slavlee_cookie_control.settings
}
###############################################################
# PAGE - END
###############################################################
###############################################################
# RESOURCES - START
###############################################################
page.includeCSS.slavlee_cookie_control = EXT:slavlee_cookie_control/Resources/Public/Css/default.css
page.includeCSS.slavlee_cookie_control.media = screen

page.includeJSFooterlibs.slavlee_cookie_control = EXT:slavlee_cookie_control/Resources/Public/Js/jquery.cookiecontrol.js 
###############################################################
# RESOURCES - END
###############################################################