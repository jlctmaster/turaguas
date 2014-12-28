<?php
  require_once("../clases/class_perfil.php");
  function imprimir_boton($disabledRC,$disabledMD,$estatus,$URLservicios,$URLtab){
    $perfil=new Perfil();
    $perfil->nid_perfil($_SESSION['user_codigo_perfil']);
    $perfil->curl($URLservicios); 
    $a=$perfil->IMPRIMIR_OPCIONES();
    echo '<input type="hidden" name="operacion" value="" id="operacion_'.$URLtab.'" />';
    for($x=0;$x<count($a);$x++){
      if($a[$x]['norden']==1){   
        echo '<input '.$disabledRC.' onclick="validar_formulario(this.id,\''.$URLtab.'\')" 
        type="button" id='.$a[$x]['norden'].' name="btregistrar" value="'.ucfirst(strtolower($a[$x]['cnombreopcion'])).'" class="btn btn-default"/>&nbsp;';
      }
      if($a[$x]['norden']==5){   
        echo '<input '.$disabledRC.' onclick="validar_formulario(this.id,\''.$URLtab.'\')" type="button" id='.$a[$x]['norden'].' 
        name="btbuscar" value="'.ucfirst(strtolower($a[$x]['cnombreopcion'])).'" class="btn btn-default"/>&nbsp;';
      }
      if($a[$x]['norden']==2){   
        echo '<input '.$disabledMD.' onclick="validar_formulario(this.id,\''.$URLtab.'\')" type="button" 
        id='.$a[$x]['norden'].' name="btmodificar" value="'.ucfirst(strtolower($a[$x]['cnombreopcion'])).'" class="btn btn-default"/>&nbsp;';
      }
      if($estatus==null){
        $ACT='disabled';
        $DES='disabled';    	
      }elseif($estatus=='Activo') {
        $ACT='disabled';
        $DES=''; 
      }elseif($estatus=='Desactivado'){
        $ACT='';
        $DES='disabled';       	
      }
      if($a[$x]['norden']==4){   
        echo '<input '.$ACT.' onclick="validar_formulario(this.id,\''.$URLtab.'\')" type="button" id='.$a[$x]['norden'].' 
        name="btactivar" value="'.ucfirst (strtolower($a[$x]['cnombreopcion'])).'" class="btn btn-default" />&nbsp;';
      }  
      if($a[$x]['norden']==3){   
        echo '<input '.$DES.' onclick="validar_formulario(this.id,\''.$URLtab.'\')" type="button" id='.$a[$x]['norden'].' 
        name="btdesactivar" value="'.ucfirst (strtolower($a[$x]['cnombreopcion'])).'" class="btn btn-default" />&nbsp;';
      }
      if($a[$x]['norden']==6){   
        echo '<input  onclick="limpiar()" type="button" name="btcancelar" value="'.ucfirst (strtolower($a[$x]['cnombreopcion'])).'" 
        class="btn btn-default"  />&nbsp;';
      }
      if($a[$x]['norden']==7){   
        echo '<input  onclick="location=\'?'.$URLservicios.'&l#'.$URLtab.'\'" type="button" name="btlistar" id='.$a[$x]['norden'].' 
        value="'.ucfirst (strtolower($a[$x]['cnombreopcion'])).'" class="btn btn-default"/>&nbsp;';
      }
    }
}
?>
