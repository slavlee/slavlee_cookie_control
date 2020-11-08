.. include:: ../Includes.txt

.. _for-administrators:

===========
For Administrators
===========

The complete configuration is set up in TypoScript. This includes:
* categories
* services
* cookies
* urls

**How Slavlee Cookie Control is embedded in your page**
Slavlee Cookie Control has a frontend plugin that needs to be embeded on your website on every page.
You don't need to to it manually, on default the frontend plugin set itself up on page.5.
If you have for any reasons something on that number already in your TYPO3 installation, then you better
move your typoscript object to another number or you can define Slavlee Cookie Control on
a different number as well.
If you decide to move Slavlee Cookie Control, then you have to set this:

.. code-block:: typoscript

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

somewhere else.

General
^^^^^^^
Slavlee Cookie Control has some default settings, which means some example categories and services.
You can change anything in TypoScript on yourself, if you want to adjust the default settings. 
Every setting is below:

.. code-block:: typoscript

page.5.settings {
	
}

Categories
^^^^^^^^^^
The categories are configured below

.. code-block:: typoscript

page.5.settings {
	categories {
	
	}
}

Categories is a Content Object Array (COA). A category needs to be set on a number. The default numbers
are on

* 10 - Essential
* 20 - Functional
* 30 - Marketing
* 40 - Statistic

These categories are only examples and can be changed as you wish. Just do it in the TypoScript.

A category is structured like so:

.. code-block:: typoscript

page.5.settings {
	categories {
		10 {  			
  			enable = 1
  			mandatory = 1
  			label = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:category.necessary.label
  			services = php
  		}
  	}
}


.. t3-field-list-table::
 :header-rows: 1
 - :Field:
 		Field:
   :Datatype:
 		Datatype:
   :Description:
		Description:
 - :Field:
		enable
   :Datatype:
		boolean	
   :Description:
		This is a boolean value, which triggers the appearance of this category and all assigned services.
 - :Field:
		mandatory
   :Datatype:
		boolean
   :Description:
		If enable, then this category can't be denied by the frontend user. Only recommended for essential services.
 - :Field:
		label
   :Datatype:
		string
   :Description:
		The label of this field
 - :Field:
		services
   :Datatype:
		string
   :Description:
		Comma seperated string of name of services. Each service has to exist below settings.services

Services
^^^^^^^^^^

The services are below

.. code-block:: typoscript

page.5.settings {
	services {

  	}
}

Services is normal TypoScript object and contains other TypoScript objects with their names as index, like:

.. code-block:: typoscript

page.5.settings {
	services {
		php {
			enable = 1
			name = PHP
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:services.php
			urls = 
			cookies = PHPSESSID
		}
  	}
}

.. t3-field-list-table::
	:header-rows: 1
		- :Field:
 				Field:
 		  :Datatype:
 		  		Datatype:
		  :Description:
				Description:
		- :Field:
			enable
		  :Datatype:
		  	boolean	
		  :Description:
			This is a boolean value, which triggers the appearance of this category and all assigned services.
		- :Field:
			description
		  :Datatype:
		  	string	
		  :Description:
			The description of the service.
		- :Field:
			urls
		  :Datatype:
		  	string	
		  :Description:
			Comma seperated string with urls that will be shredded in the HTML code, when this category is not accepted.
		- :Field:
			cookies
		  :Datatype:
		  	string	
		  :Description:
			Comma seperated string of cookie names. The cookie names needs to be configured in settings.cookies. These cookies will be deleted, when the category is not accepted.

Cookies
^^^^^^^^^^

The cookies is a normal TypoScript object as well. 

.. code-block:: typoscript

page.5.settings {
	cookies {

  	}
}


It contains more TypoScript object for the cerain cookies, where the index is the name of the cookie. This looks like so:


.. code-block:: typoscript

page.5.settings {
	cookies {
		PHPSESSID {
			description = LLL:EXT:slavlee_cookie_control/Resources/Private/Language/locallang.xlf:cookies.phpsessid
			type = session
			expiration {
				type = endofbrowser
			}
		}
  	}
}

.. t3-field-list-table::
	:header-rows: 1
		- :Field:
 				Field:
 		  :Datatype:
 		  		Datatype:
		  :Description:
				Description:
		- :Field:
			description
		  :Datatype:
		  	string	
		  :Description:
			The description of the cookie.
		- :Field:
			type
		  :Datatype:
		  	list	
		  :Description:
			Valid values are: session, permanent
		- :Field:
			expiration
		  :Datatype:
		  	object	
		  :Description:
			This object contains:
			- "type": Valid values are: endofbrowser, minutes, hours, days, months, years
 
