// code à insérer avant la fermeture de affichez_moi_tout_ca()
if( ! empty( $mes_scripts_ordonnes ) ) {
  $output = '<script src="' . get_bloginfo( 'template_url' ) . '/js/lab.min.js"></script>' . "\n";
  $output.= '<script>';
  foreach( $mes_scripts_ordonnes as $s )
    $output.= $s[ 'extra' ][ 'data' ] . '$LAB.script("' . $s[ 'src' ] . '");' . "\n";
  $output.= '</script>';
  echo $output;
}