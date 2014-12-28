<?php
 require_once("class_bd.php");
 class Opcion
 {
     private $nid_opcion; 
     private $cnombreopcion; 
     private $estatus_opciones; 
     private $norden; 
     private $dfecha_desactivacion; 
     private $pgsql; 
	 
   public function __construct(){
     $this->cnombreopcion=null;
     $this->nid_opcion=null;
	 $this->pgsql=new Conexion();
   }
   
 public function __destruct(){}

 public function Transaccion($value){
	 if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
	 if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
	 if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	 }

   public function nid_opcion(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_opcion;
     
	 if($Num_Parametro>0){
	   $this->nid_opcion=func_get_arg(0);
	 }
   }
      public function estatus_opciones(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->estatus_opciones;
     
	 if($Num_Parametro>0){
	   $this->estatus_opciones=func_get_arg(0);
	 }
   }
   public function cnombreopcion(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cnombreopcion;
     
	 if($Num_Parametro>0){
	   $this->cnombreopcion=func_get_arg(0);
	 }
   }

   public function norden(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->norden;
     
	 if($Num_Parametro>0){
	   $this->norden=func_get_arg(0);
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
    $sql="INSERT INTO seguridad.topcion (cnombreopcion,norden,dcreado_desde,ccreado_por) VALUES ('$this->cnombreopcion','$this->norden',NOW(),'$user');";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }
   
     public function Activar($user){
    $sql="UPDATE seguridad.topcion SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),cmodificado_por='$user' WHERE (nid_opcion='$this->nid_opcion');";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }
    public function Desactivar($user){
    $sqlx="SELECT * FROM seguridad.topcion o WHERE o.nid_opcion = '$this->nid_opcion' AND EXISTS 
    (SELECT 1 FROM seguridad.tdetalleservicio_perfil_opcion dspo WHERE o.nid_opcion = dspo.nid_opcion)";
    $sql="UPDATE seguridad.topcion SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),cmodificado_por='$user' WHERE (nid_opcion='$this->nid_opcion');";
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
    $sql="UPDATE seguridad.topcion SET cnombreopcion='$this->cnombreopcion',norden='$this->norden',dmodificado_desde=NOW(),cmodificado_por='$user' WHERE (nid_opcion='$this->nid_opcion');";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }
   
   public function Consultar(){
    $sql="SELECT *,(CASE WHEN dfecha_desactivacion IS NULL THEN 'Activo' ELSE 'Desactivado' END) AS estatus_opciones 
    FROM seguridad.topcion WHERE cnombreopcion='$this->cnombreopcion'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$topciones=$this->pgsql->Respuesta($query);
	$this->nid_opcion($topciones['nid_opcion']);
	$this->cnombreopcion($topciones['cnombreopcion']);
   $this->estatus_opciones($topciones['estatus_opciones']);
   $this->norden($topciones['norden']);
	$this->dfecha_desactivacion($topciones['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   public function Comprobar(){
    $sql="SELECT * FROM seguridad.topcion WHERE cnombreopcion='$this->cnombreopcion'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$topciones=$this->pgsql->Respuesta($query);
	$this->nid_opcion($topciones['nid_opcion']);
	$this->cnombreopcion($topciones['cnombreopcion']);
   $this->norden($topciones['norden']);
	$this->dfecha_desactivacion($topciones['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
}
?>
