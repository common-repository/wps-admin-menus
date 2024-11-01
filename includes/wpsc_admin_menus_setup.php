<?php

/*
File: Setup plugin WPS Admin Menus
Author: Leigh Gregg (wpscomplete.com)
Author URI: https://wpscomplete.com
Copyright 2018 wpscomplete.com. All rights reserved.
*/

if ( ! defined( 'ABSPATH' ) ) { exit; }

echo '<div class="wrap">';


//call the setting page to be built
wpsc_am_settings_page(); 


/*
*  Build nav tabs
* 
* 
*/


function wpsc_am_admin_tabs( $current = 'admin_menu' ) {
    $tabs = array( 	'admin_menu' => 'Admin Menu',
    				'admin_toolbar' => 'Toolbar',
            'admin_backend' => 'Backend',
            'admin_instructions' => 'Instructions',
    			);
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : "";
        $url_include = "";
		  echo "<a class='nav-tab$class' href='?page=wpsc_menu&tab=$tab" . $url_include . "'>$name</a>";
    }
    echo '</h2>';
}



/*
*  Select content to display
* 
* 
*/


switch ( $_GET['tab'] ) {
    case 'admin_menu':
       		include "wpsc_menu_tab.php";
        break;
    case 'admin_instructions':
          include "wpsc_instructions_tab.php";
        break;
    case 'admin_backend':
          include "wpsc_backend_tab.php";
        break;
     case 'admin_toolbar':
       		include "wpsc_toolbar_tab.php";
       	break;
      case 'admin_page_restrictions':
          echo "This is coming in V1.1";
        break;
      default:
          include "wpsc_menu_tab.php";
}


/*
* Close page content
* 
* 
*/


echo "</div>";





/*
*  Build the settings page
* 
* 
*/


function wpsc_am_settings_page() {
   global $pagenow;

      if(! isset( $_GET['tab'] ) ){
        $_GET['tab'] = '';
      }

	   	switch( $_GET['tab'] ){
	   	 	case 'admin_menu':
	   	 			wpsc_am_admin_tabs('admin_menu');
	   	 		break;
	   	  case 'admin_toolbar':
	   	 			wpsc_am_admin_tabs('admin_toolbar');
	   	 		break;
        case 'admin_instructions':
            wpsc_am_admin_tabs('admin_instructions');
          break;
        case 'admin_backend':
            wpsc_am_admin_tabs('admin_backend');
          break;
	   	 default:
            wpsc_am_admin_tabs('admin_menu');
	   }
}

