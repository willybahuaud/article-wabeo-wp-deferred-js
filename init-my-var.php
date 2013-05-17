<?php 
add_action( 'init', 'initialize_script_global' );
function initialize_script_global() {
  global $mes_scripts;
  $mes_scripts = array();
}