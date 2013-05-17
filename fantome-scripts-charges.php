<?php
add_action( 'wp_footer', 'afficher_moi_tout_ca', 99 );
function afficher_moi_tout_ca() {
  global $mes_scripts,$wp_scripts;
  $i = count( $mes_scripts );

  $mes_scripts_ordonnes = array();
  $souvenir_de_mes_scripts = $mes_scripts;

  //la boucle infinie et le foreach sur la globale
  while( $i > 0 ){
    foreach( $mes_scripts as $k => $s ){
      //traitons nos scripts ici
    }
  }
}