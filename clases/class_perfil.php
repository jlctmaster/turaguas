<?php
 require_once("class_bd.php");
 class Perfil
 {
     private $nid_perfil; 
     private $nid_configuracion; 
     private $curl; 
     private $nid_servicio; 
     private $nid_modulo; 
     private $nid_opcion; 
     private $cnombreperfil; 
     private $dfecha_desactivacion; 
     private $estatus_perfil; 
     private $pgsql; 
	 
   public function __construct(){
     $this->cnombreperfil=null;
     $this->nid_perfil=null;
	 $this->pgsql=new Conexion();
   }
   
 public function __destruct(){}

 public function Transaccion($value){
	 if($value=='iniciANDo') return $this->pgsql->Incializar_Transaccion();
	 if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
	 if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	 }

   public function nid_perfil(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_perfil;
     
	 if($Num_Parametro>0){
	   $this->nid_perfil=func_get_arg(0);
	 }
   }

   public function nid_configuracion(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nid_configuracion;
     
   if($Num_Parametro>0){
     $this->nid_configuracion=func_get_arg(0);
   }
   }
   
      public function estatus_perfil(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->estatus_perfil;
     
	 if($Num_Parametro>0){
	   $this->estatus_perfil=func_get_arg(0);
	 }
   }
      public function nid_servicio(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_servicio;
     
	 if($Num_Parametro>0){
	   $this->nid_servicio=func_get_arg(0);
	 }
   }
      public function curl(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->curl;
     
	 if($Num_Parametro>0){
	   $this->curl=func_get_arg(0);
	 }
   }
       public function nid_opcion(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_opcion;
     
	 if($Num_Parametro>0){
	   $this->nid_opcion=func_get_arg(0);
	 }
   }
   
   public function nid_modulo(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_modulo;
     
	 if($Num_Parametro>0){
	   $this->nid_modulo=func_get_arg(0);
	 }
   }
   
   public function cnombreperfil(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cnombreperfil;
     
	 if($Num_Parametro>0){
	   $this->cnombreperfil=func_get_arg(0);
	 }
   }

   
   public function dfecha_desactivacion(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->dfecha_desactivacion;
     
	 if($Num_Parametro>0){
	   $this->dfecha_desactivacion=func_get_arg(0);
	 }
   }
   

   public function Registrar($user){
    $sql="INSERT INTO seguridad.tperfil (cnombreperfil,nid_configuracion,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
    ('$this->cnombreperfil','$this->nid_configuracion',NOW(),'$user',NOW(),'$user');";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }
   
     public function Activar($user){
    $sql="UPDATE seguridad.tperfil SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),cmodificado_por='$user' WHERE (nid_perfil='$this->nid_perfil');";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }
    public function Desactivar($user){
    $sqlx="SELECT * FROM seguridad.tperfil p WHERE p.nid_perfil = '$this->nid_perfil' AND EXISTS 
    (SELECT 1 FROM seguridad.tdetalleservicio_perfil_opcion dspo WHERE p.nid_perfil = dspo.nid_perfil)";
    $sql="UPDATE seguridad.tperfil SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),cmodificado_por='$user' WHERE (nid_perfil='$this->nid_perfil');";
    $query=$this->pgsql->Ejecutar($sqlx);
    if($this->pgsql->Total_Filas($query)==0){
      if($this->pgsql->Ejecutar($sql)!=null)
    	  return true;
    	else
        return false;
    }
    else
      return false;
   }
   
    public function Actualizar($user){
    $sql="UPDATE seguridad.tperfil SET cnombreperfil='$this->cnombreperfil',nid_configuracion='$this->nid_configuracion',dmodificado_desde=NOW(),cmodificado_por='$user' WHERE (nid_perfil='$this->nid_perfil');";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }
   
   public function Consultar(){
     $sql="SELECT *,( CASE 
        WHEN dfecha_desactivacion IS NULL THEN  'Activo'
        ELSE 'Desactivado' END) AS estatus_perfil FROM seguridad.tperfil WHERE 
        cnombreperfil='$this->cnombreperfil' AND dfecha_desactivacion IS NULL";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$tperfil=$this->pgsql->Respuesta($query);
	$this->nid_perfil($tperfil['nid_perfil']);
  $this->nid_configuracion($tperfil['nid_configuracion']);
	$this->cnombreperfil($tperfil['cnombreperfil']);
   $this->estatus_perfil($tperfil['estatus_perfil']);
	$this->dfecha_desactivacion($tperfil['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   

   public function ELIMINAR_OPCION_SERVICIO_PERFIL(){
    $sql="DELETE FROM seguridad.tdetalleservicio_perfil_opcion WHERE (nid_perfil='$this->nid_perfil');";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   } 
   
   public function INSERTAR_OPCION_SERVICIO_PERFIL($user){
    $sql1="SELECT * FROM seguridad.tdetalleservicio_perfil_opcion WHERE nid_perfil=$this->nid_perfil AND nid_servicio=$this->nid_servicio AND nid_opcion=$this->nid_opcion";
    $query=$this->pgsql->Ejecutar($sql1);
    if(@$this->pgsql->Total_Filas($query)==0){
      $sql="INSERT INTO seguridad.tdetalleservicio_perfil_opcion(nid_perfil,nid_servicio,nid_opcion,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
      VALUES ('$this->nid_perfil','$this->nid_servicio','$this->nid_opcion',NOW(),'$user',NOW(),'$user')";
      if($this->pgsql->Ejecutar($sql)!=null)
        return true;
      else
        return false;
      }
    }
    
      public function Consultar_SERVICIOS(){
        if($this->nid_perfil==''){
          $sql="SELECT * FROM seguridad.tdetalleservicio_perfil_opcion tsuo 
          inner join seguridad.tperfil tper on tper.nid_perfil=tsuo.nid_perfil 
          inner join seguridad.tservicio tser on tser.nid_servicio=tsuo.nid_servicio 
          WHERE tser.nid_servicio='$this->nid_servicio' AND tper.nid_perfil IS NULL 
          AND tser.dfecha_desactivacion IS NULL AND tper.dfecha_desactivacion IS NULL";
        }
        else{
          $sql="SELECT * FROM seguridad.tdetalleservicio_perfil_opcion tsuo 
          inner join seguridad.tperfil tper on tper.nid_perfil=tsuo.nid_perfil 
          inner join seguridad.tservicio tser on tser.nid_servicio=tsuo.nid_servicio 
          WHERE tper.nid_perfil='$this->nid_perfil' AND tser.nid_servicio='$this->nid_servicio' 
          AND tser.dfecha_desactivacion IS NULL AND tper.dfecha_desactivacion IS NULL";
        }
	 $query=$this->pgsql->Ejecutar($sql);
    if(@$this->pgsql->Total_Filas($query)!=0){
	   return true;
	  }
	   else{
	    return false;
	    }
   }
         public function Consultar_OPCIONES(){
          if($this->nid_perfil==''){
            $sql="SELECT * FROM seguridad.tdetalleservicio_perfil_opcion tsuo 
            inner join seguridad.tperfil tper on tper.nid_perfil=tsuo.nid_perfil 
            inner join seguridad.tservicio tser on tser.nid_servicio=tsuo.nid_servicio
            inner join seguridad.topcion topc on topc.nid_opcion=tsuo.nid_opcion 
            WHERE topc.nid_opcion='$this->nid_opcion' AND 
            tser.nid_servicio='$this->nid_servicio' AND tper.nid_perfil IS NULL 
            AND tser.dfecha_desactivacion IS NULL AND tper.dfecha_desactivacion IS NULL 
            AND topc.dfecha_desactivacion IS NULL"; 
          }
          else{
            $sql="SELECT * FROM seguridad.tdetalleservicio_perfil_opcion tsuo 
            inner join seguridad.tperfil tper on tper.nid_perfil=tsuo.nid_perfil 
            inner join seguridad.tservicio tser on tser.nid_servicio=tsuo.nid_servicio
            inner join seguridad.topcion topc on topc.nid_opcion=tsuo.nid_opcion 
            WHERE topc.nid_opcion='$this->nid_opcion' AND 
            tper.nid_perfil='$this->nid_perfil' AND 
            tser.nid_servicio='$this->nid_servicio' 
            AND tser.dfecha_desactivacion IS NULL AND tper.dfecha_desactivacion IS NULL 
            AND topc.dfecha_desactivacion IS NULL"; 
          }
	$query=$this->pgsql->Ejecutar($sql);
    if(@$this->pgsql->Total_Filas($query)!=0){
	   return true;
	  }
	   else{
	    return false;
	    }
   }
   
      public function IMPRIMIR_MODULOS(){
    $sql="SELECT DISTINCT tmod.nid_modulo, LOWER(tmod.cnombremodulo) cnombremodulo,tmod.cicono,tmod.norden 
    FROM seguridad.tmodulo tmod 
    INNER JOIN seguridad.tformulario tform ON tmod.nid_modulo = tform.nid_modulo 
    INNER JOIN seguridad.tservicio tserv ON tform.nid_formulario = tserv.nid_formulario 
    INNER JOIN seguridad.tdetalleservicio_perfil_opcion tdspo ON tserv.nid_servicio = tdspo.nid_servicio 
    WHERE tdspo.nid_perfil = '$this->nid_perfil'
    ORDER BY tmod.norden ASC";
    $x=array();
    $i=0;
	$query=$this->pgsql->Ejecutar($sql);
   while($a=$this->pgsql->Respuesta($query)){
   	$x[$i]['cnombremodulo']=$a['cnombremodulo'];
   	$x[$i]['nid_modulo']=$a['nid_modulo'];
   	$x[$i]['cicono']=$a['cicono'];
      $i++;     
     }
     return $x;    
 }

 public function IMPRIMIR_FORMULARIOS(){
    $sql="SELECT DISTINCT tform.nid_formulario, LOWER(tform.cnombreformulario) AS cnombreformulario,tform.curl,tform.norden 
    FROM seguridad.tformulario tform 
    INNER JOIN seguridad.tservicio tserv ON tform.nid_formulario = tserv.nid_formulario 
    INNER JOIN seguridad.tdetalleservicio_perfil_opcion tdspo ON tserv.nid_servicio = tdspo.nid_servicio 
    WHERE tdspo.nid_perfil ='$this->nid_perfil' AND tform.nid_modulo = '$this->nid_modulo'
    ORDER BY tform.norden,LOWER(tform.cnombreformulario),tform.nid_formulario ASC";
    $x=array();
    $i=0;
  $query=$this->pgsql->Ejecutar($sql);
   while($a=$this->pgsql->Respuesta($query)){
    $x[$i]['cnombreformulario']=$a['cnombreformulario'];
    $x[$i]['nid_formulario']=$a['nid_formulario'];
    $x[$i]['curl']=$a['curl'];
      $i++;     
     }
     return $x;    
 }
  
  
  public function IMPRIMIR_SERVICIOS(){
    $sql="SELECT DISTINCT tserv.nid_servicio, tserv.cnombreservicio 
    FROM seguridad.tservicio tserv 
    INNER JOIN seguridad.tdetalleservicio_perfil_opcion tdspo ON tserv.nid_servicio = tdspo.nid_servicio 
    WHERE tdspo.nid_perfil = '$this->nid_perfil' ORDER BY tserv.nid_servicio";
	 $x=array();
    $i=0;
	$query=$this->pgsql->Ejecutar($sql);
   while($a=$this->pgsql->Respuesta($query)){
   	$x[$i]['cnombreservicio']=$a['cnombreservicio'];
   	$x[$i]['nid_servicio']=$a['nid_servicio'];
      $i++;     
     }
     return $x;     
   }
   
    public function IMPRIMIR_OPCIONES(){
    $sql="SELECT DISTINCT top.cnombreopcion,top.norden,CASE WHEN top.dfecha_desactivacion IS NULL THEN 'Activo' ELSE 'Desactivado' END estatus 
    FROM seguridad.topcion top 
    INNER JOIN seguridad.tdetalleservicio_perfil_opcion tdspo ON top.nid_opcion = tdspo.nid_opcion 
    INNER JOIN seguridad.tservicio tserv ON tdspo.nid_servicio = tserv.nid_servicio 
    INNER JOIN seguridad.tformulario tform ON tserv.nid_formulario = tform.nid_formulario 
    WHERE tdspo.nid_perfil = '$this->nid_perfil' AND lower(tform.curl) = '$this->curl' 
    ORDER BY top.norden ASC";
		 $x=array();
    $i=0;
	$query=$this->pgsql->Ejecutar($sql);
   while($a=$this->pgsql->Respuesta($query)){
   	$x[$i]['cnombreopcion']=$a['cnombreopcion'];
   	$x[$i]['norden']=$a['norden'];
   	$x[$i]['estatus']=$a['estatus'];
      $i++;     
     }
     return $x;   
   }
   
   
   public function Comprobar(){
    $sql="SELECT * FROM seguridad.tperfil WHERE cnombreperfil='$this->cnombreperfil'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$tperfil=$this->pgsql->Respuesta($query);
	$this->nid_perfil($tperfil['nid_perfil']);
  $this->nid_configuracion($tperfil['nid_configuracion']);
	$this->cnombreperfil($tperfil['cnombreperfil']);
	$this->dfecha_desactivacion($tperfil['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
}
?>
