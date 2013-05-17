<?php
if( empty( $s[ 'deps' ] ) ){
  $mes_scripts_ordonnes[ $k ] = $s;
  unset( $mes_scripts[ $k ] );
  $i--;
}