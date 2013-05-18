else{
  $alldepscounter = 0; //nombre de conditions remplies
  foreach($s['deps'] as $d){
    if(!array_key_exists($d,$souvenir_de_mes_scripts)){ //je n'aurais jamais ma dépendance...
      if(isset($wp_scripts->registered[$d])){ //... à moins qu'il y ai un script ?
        $mes_scripts[$wp_scripts->registered[$d]->handle] = array(
          'src'   => $wp_scripts->registered[$d]->src,
          'deps'  => $wp_scripts->registered[$d]->deps, 
          'extra' =>$wp_scripts->registered[$d]->extra);
        $souvenir_de_mes_scripts[$wp_scripts->registered[$d]->handle] = $mes_scripts[$wp_scripts->registered[$d]->handle];
      }else{ //retourne dans ton monde, créature démoniaque...
        unset($mes_scripts[$k]);
        $i--;
        break; 
      }
    }else{
      if(array_key_exists($d,$mes_scripts_ordonnes)){ // je rempli une condition en +
        $alldepscounter++;
      }
    }
  }
  if($alldepscounter == count($s['deps'])){ //bravo, toutes les conditions sont remplies
    $mes_scripts_ordonnes[$k] = $s;
    unset($mes_scripts[$k]);
    $i--;
  }
}