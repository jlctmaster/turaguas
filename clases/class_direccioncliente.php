<?php
 require_once("class_bd.php");
 class DireccionCliente
 {
   private $nid_direcciondespacho;
   private $crif_personacliente;
   private $cnombre_personacliente;
   private $cdireccion;
   private $ctelefonodireccion; 
   private $csede_principaldireccion;
   private $nid_localidaddireccion;
   private $dfecha_desactivaciondireccion;
   private $estatusdireccion;
   private $pgsql; 
	 
   public function __construct(){
     $this->nid_direcciondespacho=null;
     $this->crif_personacliente=null;
     $this->cdireccion=null;
     $this->ctelefonodireccion=null;
     $this->csede_principaldireccion=null;
     $this->nid_localidaddireccion=null;
     $this->dfecha_desactivaciondireccion=null;
     
  	 $this->pgsql=new Conexion();
   }
   
 public function __destruct(){}

 public function Transaccion($value){
	 if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
	 if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
	 if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	 }

   public function nid_direcciondespacho(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nid_direcciondespacho;
     
   if($Num_Parametro>0){
     $this->nid_direcciondespacho=func_get_arg(0);
   }
   }

   public function crif_personacliente(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->crif_personacliente;
     
	 if($Num_Parametro>0){
	   $this->crif_personacliente=func_get_arg(0);
	 }
   }

   public function estatusdireccion(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->estatusdireccion;
     
   if($Num_Parametro>0){
     $this->estatusdireccion=func_get_arg(0);
   }
   }

   public function cnombre_personacliente(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->cnombre_personacliente;
     
   if($Num_Parametro>0){
     $this->cnombre_personacliente=func_get_arg(0);
   }
   }
   
   public function cdireccion(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->cdireccion;
     
   if($Num_Parametro>0){
     $this->cdireccion=func_get_arg(0);
   }
   }

   public function ctelefonodireccion(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->ctelefonodireccion;
     
   if($Num_Parametro>0){
     $this->ctelefonodireccion=func_get_arg(0);
   }
   }

   public function csede_principaldireccion(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->csede_principaldireccion;
     
	 if($Num_Parametro>0){
	   $this->csede_principaldireccion=func_get_arg(0);
	 }
   }

   public function nid_localidaddireccion(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nid_localidaddireccion;
     
   if($Num_Parametro>0){
     $this->nid_localidaddireccion=func_get_arg(0);
   }
   }

   public function dfecha_desactivaciondireccion(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->dfecha_desactivaciondireccion;
     
	 if($Num_Parametro>0){
	   $this->dfecha_desactivaciondireccion=func_get_arg(0);
	 }
   }

   public function Registrar($user){
    $sql="INSERT INTO general.tdireccion_despacho (crif_persona,cdireccion,ctelefono,csede_principal,nid_localidad,dcreado_desde,ccreado_por,dmodificado_desde,
      cmodificado_por) VALUES ('$this->crif_personacliente','$this->cdireccion','$this->ctelefonodireccion','$this->csede_principaldireccion','$this->nid_localidaddireccion'
      ,NOW(),'$user',NOW(),'$user')";
    if($this->pgsql->Ejecutar($sql)!=null)
    	return true;
		else
			return false;
   }
   
    public function Activar($user){
    $sql="UPDATE general.tdireccion_despacho SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE nid_direcciondespacho = '$this->nid_direcciondespacho'";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }

    public function Desactivar($user){
    $sql="UPDATE general.tdireccion_despacho SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE nid_direcciondespacho = '$this->nid_direcciondespacho'";
    if($this->pgsql->Ejecutar($sql)!=null)
  	return true;
  	else
  	return false;
   }
   
    public function Actualizar($user){
    $sql="UPDATE general.tdireccion_despacho SET cdireccion='$this->cdireccion',crif_persona='$this->crif_personacliente',ctelefono='$this->ctelefonodireccion',csede_principal='$this->csede_principaldireccion',
    nid_localidad='$this->nid_localidaddireccion', dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE nid_direcciondespacho = '$this->nid_direcciondespacho'";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }
   
   public function Consultar(){
    $sql="SELECT dd.nid_direcciondespacho,dd.crif_persona,dd.cdireccion,dd.ctelefono,dd.nid_localidad,dd.dfecha_desactivacion,
    dd.csede_principal,p.cnombre as cnombrecliente,
    (CASE WHEN dd.dfecha_desactivacion IS NULL THEN  'Activo' ELSE 'Desactivado' END) AS estatusdireccion 
    FROM general.tdireccion_despacho dd 
    INNER JOIN general.tpersona p ON dd.crif_persona = p.crif_persona 
    WHERE dd.cdireccion='$this->cdireccion'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$tdireccion=$this->pgsql->Respuesta($query);
  $this->nid_direcciondespacho($tdireccion['nid_direcciondespacho']);
	$this->crif_personacliente($tdireccion['crif_persona']);
  $this->cdireccion($tdireccion['cdireccion']);
  $this->ctelefonodireccion($tdireccion['ctelefono']);
	$this->csede_principaldireccion($tdireccion['csede_principal']);
	$this->nid_localidaddireccion($tdireccion['nid_localidad']);
	$this->dfecha_desactivaciondireccion($tdireccion['dfecha_desactivacion']);
  $this->estatusdireccion($tdireccion['estatusdireccion']);  
  $this->cnombre_personacliente($tdireccion['cnombrecliente']);  
	return true;
	}
	else{
	return false;
	}
   }
   public function Comprobar(){
    $sql="SELECT * FROM general.tdireccion_despacho WHERE cdireccion='$this->cdireccion'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$tdireccion=$this->pgsql->Respuesta($query);
  $this->nid_direcciondespacho($tdireccion['nid_direcciondespacho']);
  $this->crif_personadcliente($tdireccion['crif_persona']);
  $this->cdireccion($tdireccion['cdireccion']);
  $this->ctelefonodireccion($tdireccion['ctelefono']);
  $this->csede_principaldireccion($tdireccion['csede_principal']);
  $this->nid_localidaddireccion($tdireccion['nid_localidad']);
  $this->dfecha_desactivaciondireccion($tdireccion['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
}
?>