// On se greffe sur wp_header et sur wp_footer...
// ... avant que wp_print_script ne soit exécuté...
// ... sinon ce sera trop tard, il n'y aura plus de hook pour empêcher...
// ... l'impression des scripts
add_action( 'wp_head', 'je_veux_mes_scripts', 1 );
add_action( 'wp_footer', 'je_veux_mes_scripts', 1 );
function je_veux_mes_scripts() {
  global $mes_scripts,$wp_scripts;
  foreach( $wp_scripts->queue as $s ){
    $mes_scripts[ $wp_scripts->registered[ $s ]->handle ] = array(
      'src'   => $wp_scripts->registered[ $s ]->src, // src du script
      'deps'  => $wp_scripts->registered[ $s ]->deps, // dépendances du script
      'extra' => $wp_scripts->registered[ $s ]->extra //données relatives (variables)
      );
  }
}