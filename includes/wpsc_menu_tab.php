<?php

/**
 * Main plugin page and functions
 *
 * 
 *
 * @package     WPS Admin Menus
 * @subpackage  
 * @copyright   Copyright (c) 2018, WPS Complete
 * @license     http://opensource.org/license/gpl-2.1.php GNU Public License
 * @since       1.0
 */



if ( ! defined( 'ABSPATH' ) ) { exit; }



/*
* Admin side menu
*
*/

global $menu, $submenu, $wp_roles;


//update on post
if( isset( $_POST ) ){
  if( ! isset( $_POST['WPS-action'] ) ){ $_POST['WPS-action'] = ''; }
  if( $_POST['WPS-action'] == 'edit-admin_menus' ){

    if ( ! wp_verify_nonce( $_POST['wpsc_am_edit_admin_menus_nonce'], 'wpsc_am_edit_admin_menus_nonce' ) ) {
      wp_die( __( 'Nonce verification failed.', 'wps' ), __( 'Error', 'wps' ), array( 'response' => 403 ) );
    }

    $admin_menus_class = new WPSC_admin_menu;
    $ordered = $admin_menus_class->wpsc_am_match_converted_posted_underscore();

    // $ordered = wpsc_am_match_converted_posted_underscore( $menu , $submenu );
    $conversions = wpsc_am_match_posted_names_converted( $ordered , $_POST );
    $update = wpsc_am_insert_selections( $conversions );

  }
}

$available_roles = wpsc_am_role_types_output( $wp_roles->roles );

echo "<h3>Set your desired menu access</h3>";
echo "<p>If the menu is hidden from a user role by default, these options will not grant access. The option will only hide if the user is currently able to see it.</p>";
echo '<form action="" method="post">';
echo '<ul class="admin_menu_list" >';

foreach($menu as $m){
  $menu_title = $m[0] != "" ? $m[0] : $m[2];
  echo "<li><h3>Menu: " . $menu_title . "</h3></li>";
  echo wpsc_am_checbox_user_selection( $available_roles , $m , 'wpsc_am_menu', $m[2] );

  foreach( $submenu as $key => $value){
    if( $m[2] == $key ){
      echo "<ul>";
      $i = 1;
      foreach($value as $sub){
        echo "<li><h3>Sub Menu: ". $sub[0] . '</h3></li>';
        if( $i == 1 ){
          echo  "This is a duplication of the Menu selection";
        } else {
          echo wpsc_am_checbox_user_selection( $available_roles , $sub, 'wpsc_am_submenu', $m[2] );
        }
        $i++;
      }
      echo "</ul>";
      break;
    }
  }
}

echo "</ul>";


echo '<input type="hidden" name="WPS-action" value="edit-admin_menus"/>';
echo '<input type="hidden" name="post_type" value="job_listing"/>';
wp_nonce_field( 'wpsc_am_edit_admin_menus_nonce', 'wpsc_am_edit_admin_menus_nonce' );
submit_button("Update Menus");
echo '</form>';    




/*
*  Check the role types into manageable array
* 
* 
*/


function wpsc_am_role_types_output( $roles ){
  $output=array();
  foreach( $roles as $key => $value ){
    $output[] = $key;
  }
  return $output;
}


/*
*  Create the user role checkbox selections
* 
* 
*/


function wpsc_am_checbox_user_selection( $available_roles , $m , $menu_type = 'menu' , $parent ){
  $output="";

  $output .= '<input name="' . $m[2] . '[]" type="hidden" value="wpsc_am_ensure_updates" >';
  //help to identify the menu type
  $output .= '<input name="' . $m[2] . '[]" type="hidden" value="' . $menu_type . '" >';
  $output .= '<input name="' . $m[2] . '[]" type="hidden" value="parent__' .  $parent . '" >';

    foreach($available_roles as $role){
      $checked = '';
      $option_name = 'wpsc_am_option_'.$m[2];
      $saved_options = get_option($option_name);
      if( $saved_options ){
        foreach($saved_options as $user_role ){
          if($user_role == $role){
            $checked = 'checked';    
            break;
          }
        }
      }
      if( $role == 'administrator' ){ $checked = ''; $disable = 'disabled'; } else { $disable = ""; }
      $output .= '<li><label><input ' . $disable . " " . $checked . ' name="' . $m[2] . '[]" type="checkbox" value="' . $role . '" >' . $role . '<label></li>';
    }
  return $output;
}




/*
*  Match of names posted with . converted to _
* 
* 
*/


function wpsc_am_match_posted_names_converted( $ordered_menu , $args = array() ){
  $output = array();
  foreach( $ordered_menu as $d ){
    foreach( $args as $posted => $value ){
      $e = str_replace( '.' , '_' , $d);
      if($e == $posted){
        $output[$d] = $value;
        break;
      }
    }
  }
  return $output;
}




/*
* Insert and update current selections
* 
* 
*/


function wpsc_am_insert_selections( $args ){
  global $wpdb;
  foreach($args as $key => $value){
    $option_name = 'wpsc_am_option_'.$key;
    update_option( $option_name, $value, true);
  }
}

