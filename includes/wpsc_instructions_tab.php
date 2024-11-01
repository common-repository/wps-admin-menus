<?php

/**
 * Instructions for the plugin
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



echo '<div class="wrap">';

?>

<h3>Index</h3>

<ol>
  <li>Select to hide</li>
  <li>Testing</li>
  <li>Adminstrator restriction.</li>
  <li>Adminstrator backend restriction.</li>
  <li>Hide Menu or Submenu from a role</li>
  <li>URL restricting</li>
  <li>Overriding defaults</li>
  <li>Seperator(number) menus</li>
</ol>

<h3>Content </h3>

<ol>
  <li>Select the roles you wish not to see the Menu or Sub Menu.</li>
  <li>Login to your website in another browser and login as a user with the role you wish to test. Check the Menu as required aand make any adjustemnts.</li>
  <li>The Administrator role is not allowed to be restricted to ensure Admins have full access to all menus as a safety measure.</li>
  <li>Adminstrators must always have access to the administration areas.</li>
  <li>Hiding a Menu from a role hides all Submenus of the Menu from the role. Ensure that the Menu is available to the role. Sometimes a Submenu can become a Menu for different roles.</li>
  <li>This plugin does not resrict the URL at the moment. Users will still be able to access a menu if they know the URL and enter it manually.
  <li>If the menu is hidden from a user role by default, these options will not grant access. The option will only hide if the user is currently able to see it.</li>
  <li>These are dividers between sections of menu areas. They create small spaces between menu areas. These maybe useful or not to display depending on the arrangement of menus you have.</li>
</ol>






<?php
echo '</div>';