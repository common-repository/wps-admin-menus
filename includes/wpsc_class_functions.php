<?php

/*
File: Setup plugin WPS Admin Menus
Author: Leigh Gregg (wpscomplete.com)
Author URI: https://wpscomplete.com
Copyright 2018 wpscomplete.com. All rights reserved.
*/

if ( ! defined( 'ABSPATH' ) ) { exit; }

class WPSC_admin_menu{

 


  /*
  *  Create the array list of menus / submenus correctly.
  * 
  * 
  */


  public function wpsc_am_match_converted_posted_underscore(){
    global $menu , $submenu;

    $output = array();
    foreach($menu as $m){
      $output[] = $m[2];
      foreach( $submenu as $key => $value){
        if( $m[2] == $key ){
          foreach($value as $sub){
            $output[] = $sub[2];
          }
          break;
        }
      }
    }
    return $output;
  }

  



}