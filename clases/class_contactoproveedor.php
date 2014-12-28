<?php
 require_once("class_bd.php");
 class ContactoProveedor
 {
   private $crif_personaproveedor; 
   private $cnombreproveedor;
   private $nid_direcciondespacho; 
   private $cdireccion;
   private $nid_personacontacto; 
   private $crif_personacontacto; 
   private $cnombrecontacto;
   private $ccargo; 
   private $ctelefono; 
   private $estatuscontacto; 
   private $dfecha_desactivacion; 
   private $pgsql; 
	 
   public function __construct(){
     $this->crif_personaproveedor=null;
     $this->cnombreproveedor=null;
     $this->nid_personacontacto=null;
     $this->crif_personacontacto=null;
     $this->cnombrecontacto=null;
     $this->nid_direcciondespacho=null;
     $this->cdireccion=null;
     $this->ccargo=null;
     $this->ctelefono=null;
     $this->estatuscontacto=null;
	 $this->pgsql=new Conexion();
   }
   
 public function __destruct(){}

 public function Transaccion($value){
	 if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
	 if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
	 if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	 }

   public function nid_personacontacto(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nid_personacontacto;
     
   if($Num_Parametro>0){
     $this->nid_personacontacto=func_get_arg(0);
   }
   }

   public function crif_personacontacto(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->crif_personacontacto;
     
	 if($Num_Parametro>0){
	   $this->crif_personacontacto=func_get_arg(0);
	 }
   }
   
   public function cnombrecontacto(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cnombrecontacto;
     
	 if($Num_Parametro>0){
	   $this->cnombrecontacto=func_get_arg(0);
	 }
   }
 public function crif_personaproveedor(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->crif_personaproveedor;
     
   if($Num_Parametro>0){
     $this->crif_personaproveedor=func_get_arg(0);
   }
   }
   
   public function cnombreproveedor(){
   $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->cnombreproveedor;
     
   if($Num_Parametro>0){
     $this->cnombreproveedor=func_get_arg(0);
   }
   }
   public function ccargo(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->ccargo;
     
	 if($Num_Parametro>0){
	   $this->ccargo=func_get_arg(0);
	 }
   }
   
   public function ctelefono(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->ctelefono;
     
	 if($Num_Parametro>0){
	   $this->ctelefono=func_get_arg(0);
	 }
   }

   public function nid_direcciondespacho(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_direcciondespacho;
     
	 if($Num_Parametro>0){
	   $this->nid_direcciondespacho=func_get_arg(0);
	 }
   }

   public function cdireccion(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cdireccion;
     
	 if($Num_Parametro>0){
	   $this->cdireccion=func_get_arg(0);
	 }
   }

   public function estatuscontacto(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->estatuscontacto;
     
	 if($Num_Parametro>0){
	   $this->estatuscontacto=func_get_arg(0);
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
    $sql="INSERT INTO general.tpersona_contacto(crif_persona,cnombre,nid_direcciondespacho,ccargo,ctelefono,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
    VALUES ('$this->crif_personacontacto','$this->cnombrecontacto','$this->nid_direcciondespacho','$this->ccargo','$this->ctelefono',NOW(),'$user',NOW(),'$user')";
    if($this->pgsql->Ejecutar($sql)!=null)
    	return true;
		else
			return false;
   }
   
    public function Activar($user){
    $sql="UPDATE general.tpersona_contacto SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE crif_persona = '$this->crif_personacontacto'";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }

    public function Desactivar($user){
    $sql="UPDATE general.tpersona_contacto SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE crif_persona = '$this->crif_personacontacto'";
    if($this->pgsql->Ejecutar($sql)!=null)
  	return true;
  	else
  	return false;
   }
   
    public function Actualizar($user){
    $sql="UPDATE general.tpersona_contacto SET cnombre='$this->cnombrecontacto',ctelefono='$this->ctelefono',
    ccargo='$this->ccargo',dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE crif_persona='$this->crif_personacontacto'";
    if($this->pgsql->Ejecutar($sql)!=null)
      return true;
	  else
      return false;
   }
   
   public function Consultar(){
    $sql="SELECT pc.nid_personacontacto,p.crif_persona crif_personaproveedor,p.cnombre cnombreproveedor,pc.nid_direcciondespacho,dp.cdireccion,
    pc.crif_persona crif_personacontacto,pc.cnombre cnombrecontacto, pc.ccargo,pc.ctelefono, 
    (CASE WHEN pc.dfecha_desactivacion IS NULL THEN  'Activo' ELSE 'Desactivado' END) AS estatuscontacto 
    FROM general.tpersona p 
    INNER JOIN general.tdireccion_despacho dp ON p.crif_persona = dp.crif_persona 
    INNER JOIN general.tpersona_contacto pc ON dp.nid_direcciondespacho = pc.nid_direcciondespacho 
    WHERE pc.crif_persona='$this->crif_personacontacto'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$tpersonas=$this->pgsql->Respuesta($query);
  $this->nid_personacontacto($tpersonas['nid_personacontacto']);
	$this->crif_personaproveedor($tpersonas['crif_personaproveedor']);
	$this->cnombreproveedor($tpersonas['cnombreproveedor']);
  $this->crif_personacontacto($tpersonas['crif_personacontacto']);
  $this->cnombrecontacto($tpersonas['cnombrecontacto']);
	$this->ccargo($tpersonas['ccargo']);
  $this->ctelefono($tpersonas['ctelefono']);
	$this->nid_direcciondespacho($tpersonas['nid_direcciondespacho']);
	$this->cdireccion($tpersonas['cdireccion']);
  $this->estatuscontacto($tpersonas['estatuscontacto']);
	$this->dfecha_desactivacion($tpersonas['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   public function Comprobar(){
    $sql="SELECT * FROM general.tpersona_contacto WHERE crif_persona='$this->crif_personacontacto'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$tpersonas=$this->pgsql->Respuesta($query);
  $this->nid_personacontacto($tpersonas['nid_personacontacto']);
  $this->crif_personacontacto($tpersonas['crif_personacontacto']);
  $this->cnombrecontacto($tpersonas['cnombrecontacto']);
  $this->ccargo($tpersonas['ccargo']);
  $this->ctelefono($tpersonas['ctelefono']);
  $this->nid_direcciondespacho($tpersonas['nid_direcciondespacho']);
	$this->dfecha_desactivacion($tpersonas['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
}
?>