<?php

/*
File: Setup plugin WPS Admin Menus
Author: Leigh Gregg (wpscomplete.com)
Author URI: https://wpscomplete.com
Copyright 2018 wpscomplete.com. All rights reserved.
*/

if ( ! defined( 'ABSPATH' ) ) { exit; }

echo "<br/>This is coming in version 1.1";

add_action( 'init', 'admin_bar_actions');
function admin_bar_actions(  ) {
  global $wp_admin_bar;

}



