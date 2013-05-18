//init global
add_action( 'init', 'initialize_script_global' );
function initialize_script_global() {
  global $mes_scripts;
  $mes_scripts = array();
}

//remplissage de $mes_scripts et vidage de $wp_scripts->queue
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
  $wp_scripts->queue = array();
}

//tri et impression des scripts
add_action( 'wp_footer', 'afficher_moi_tout_ca', 99 );
function afficher_moi_tout_ca() {
  global $mes_scripts, $wp_scripts;
  $i = count( $mes_scripts );

  $mes_scripts_ordonnes = array();
  $souvenir_de_mes_scripts = $mes_scripts;

  //la boucle infinie et le foreach sur la globale
  while( $i > 0 ){
    foreach( $mes_scripts as $k => $s ){
      if( empty( $s[ 'deps' ] ) ){
        $mes_scripts_ordonnes[ $k ] = $s;
        unset( $mes_scripts[ $k ] );
        $i--;
      }else{
        $alldepscounter = 0; //nombre de conditions remplies
        foreach( $s[ 'deps' ] as $d ){
          if( ! array_key_exists( $d, $souvenir_de_mes_scripts ) ) { //je n'aurais jamais ma dépendance...
            if( isset( $wp_scripts->registered[ $d ] ) ) { //... à moins qu'il y ai un script ?
              $mes_scripts[ $wp_scripts->registered[ $d ]->handle ] = array(
                'src'   => $wp_scripts->registered[ $d ]->src,
                'deps'  => $wp_scripts->registered[ $d ]->deps, 
                'extra' => $wp_scripts->registered[ $d ]->extra);
              $souvenir_de_mes_scripts[ $wp_scripts->registered[ $d ]->handle ] = $mes_scripts[ $wp_scripts->registered[ $d ]->handle ];
            }else{ //retourne dans ton monde, créature démoniaque...
              unset( $mes_scripts[ $k ]);
              $i--;
              break; 
            }
          }else{
            if( array_key_exists( $d, $mes_scripts_ordonnes ) ) { // je rempli une condition en +
              $alldepscounter++;
            }
          }
        }
        if( $alldepscounter == count( $s[ 'deps' ] ) ) { //bravo, toutes les conditions sont remplies
          $mes_scripts_ordonnes[ $k ] = $s;
          unset( $mes_scripts[ $k ] );
          $i--;
        }
      }
    }
  }

  //print this
  if( ! empty( $mes_scripts_ordonnes ) ) {
    $output = '<script src="' . get_bloginfo( 'template_url' ) . '/js/lab.min.js"></script>' . "\n";
    $output.= '<script>';
    foreach( $mes_scripts_ordonnes as $s )
      $output.= $s[ 'extra' ][ 'data' ] . '$LAB.script("' . $s[ 'src' ] . '");' . "\n";
    $output.= '</script>';
    echo $output;
  }
}