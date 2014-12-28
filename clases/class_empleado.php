<?php
 require_once("class_bd.php");
 class Empleado
 {
   private $nid_rol;
   private $crif_persona; 
   private $cnombre;
   private $ctelefhab; 
   private $ctelefmov; 
   private $cemail;
   private $nid_localidad;
   private $cdireccion; 
   private $estatus_persona; 
   private $dfecha_desactivacion; 
   private $pgsql; 
	 
   public function __construct(){
     $this->nid_rol=null;
     $this->crif_persona=null;
     $this->cnombre=null;
     $this->ctelefhab=null;
     $this->ctelefmov=null;
     $this->cemail=null;
     $this->nid_localidad=null;
     $this->cdireccion=null;
     $this->estatus_persona=null;
	 $this->pgsql=new Conexion();
   }
   
 public function __destruct(){}

 public function Transaccion($value){
	 if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
	 if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
	 if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	 }

   public function nid_rol(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nid_rol;
     
   if($Num_Parametro>0){
     $this->nid_rol=func_get_arg(0);
   }
   }

   public function crif_persona(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->crif_persona;
     
	 if($Num_Parametro>0){
	   $this->crif_persona=func_get_arg(0);
	 }
   }
   
   public function cnombre(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cnombre;
     
	 if($Num_Parametro>0){
	   $this->cnombre=func_get_arg(0);
	 }
   }

   public function ctelefhab(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->ctelefhab;
     
	 if($Num_Parametro>0){
	   $this->ctelefhab=func_get_arg(0);
	 }
   }
   
   public function ctelefmov(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->ctelefmov;
     
	 if($Num_Parametro>0){
	   $this->ctelefmov=func_get_arg(0);
	 }
   }

   public function cemail(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cemail;
     
	 if($Num_Parametro>0){
	   $this->cemail=func_get_arg(0);
	 }
   }

   public function nid_localidad(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_localidad;
     
	 if($Num_Parametro>0){
	   $this->nid_localidad=func_get_arg(0);
	 }
   }

   public function cdireccion(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cdireccion;
     
	 if($Num_Parametro>0){
	   $this->cdireccion=func_get_arg(0);
	 }
   }

   public function estatus_persona(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->estatus_persona;
     
	 if($Num_Parametro>0){
	   $this->estatus_persona=func_get_arg(0);
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
    $sql="INSERT INTO general.tpersona (crif_persona,cnombre,cdireccion,ctelefhab,ctelefmov,cemail,nid_localidad,nid_rol,ntipo_persona,dcreado_desde,ccreado_por,dmodificado_desde,
      cmodificado_por) VALUES ('$this->crif_persona','$this->cnombre','$this->cdireccion','$this->ctelefhab','$this->ctelefmov','$this->cemail','$this->nid_localidad'
    	,'$this->nid_rol',(select nid_combovalor from general.tcombo_valor where ctabla='tpersona' AND lower(cdescripcion) like '%empleado%'),NOW(),'$user',NOW(),'$user')";
    if($this->pgsql->Ejecutar($sql)!=null)
    	return true;
		else
			return false;
   }
   
    public function Activar($user){
    $sql="UPDATE general.tpersona SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),cmodificado_por='$user' WHERE crif_persona = '$this->crif_persona'";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }

    public function Desactivar($user){
    $sqlx="SELECT * FROM general.tpersona p WHERE p.crif_persona = '$this->crif_persona' AND EXISTS 
    (SELECT 1 FROM seguridad.tusuario u WHERE u.ccedula = p.crif_persona)";
    $sql="UPDATE general.tpersona SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),cmodificado_por='$user' WHERE crif_persona = '$this->crif_persona'";
    $query=$this->pgsql->Ejecutar($sqlx);
    if($this->pgsql->Total_Filas($query)==0){
      if($this->pgsql->Ejecutar($sql)!=null)
    	  return true;
    	else
    	  return false;
    }
    else{
      return false;
    }
   }
   
    public function Actualizar($user){
    $sql="UPDATE general.tpersona SET nid_rol = '$this->nid_rol',crif_persona='$this->crif_persona',cnombre='$this->cnombre',ctelefhab='$this->ctelefhab',
    ctelefmov='$this->ctelefmov',cemail='$this->cemail',nid_localidad='$this->nid_localidad',cdireccion='$this->cdireccion',dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE crif_persona='$this->crif_persona'";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }
   
   public function Consultar(){
    $sql="SELECT *,(CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
    ELSE 'Desactivado' END) AS estatus_persona FROM general.tpersona WHERE crif_persona='$this->crif_persona'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$tpersonas=$this->pgsql->Respuesta($query);
  $this->nid_rol($tpersonas['nid_rol']);
	$this->crif_persona($tpersonas['crif_persona']);
	$this->cnombre($tpersonas['cnombre']);
	$this->ctelefhab($tpersonas['ctelefhab']);
	$this->ctelefmov($tpersonas['ctelefmov']);
	$this->cemail($tpersonas['cemail']);
	$this->nid_localidad($tpersonas['nid_localidad']);
	$this->cdireccion($tpersonas['cdireccion']);
  $this->estatus_persona($tpersonas['estatus_persona']);
	$this->dfecha_desactivacion($tpersonas['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   public function Comprobar(){
    $sql="SELECT * FROM general.tpersona WHERE crif_persona='$this->crif_persona'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$tpersonas=$this->pgsql->Respuesta($query);
  $this->nid_rol($tpersonas['nid_rol']);
	$this->crif_persona($tpersonas['crif_persona']);
	$this->cnombre($tpersonas['cnombre']);
	$this->ctelefhab($tpersonas['ctelefhab']);
	$this->ctelefmov($tpersonas['ctelefmov']);
	$this->cemail($tpersonas['cemail']);
	$this->nid_localidad($tpersonas['nid_localidad']);
	$this->cdireccion($tpersonas['cdireccion']);
	$this->dfecha_desactivacion($tpersonas['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
}
?>