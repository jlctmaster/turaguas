<?php
 require_once("class_bd.php");
 class Proveedor
 {
   private $crif_personaproveedor; 
   private $cnombreproveedor;
   private $ctelefhabproveedor; 
   private $ctelefmovproveedor; 
   private $cemailproveedor;
   private $nid_condicionpago;
   private $nid_localidadproveedor;
   private $cdireccionproveedor; 
   private $ctelefonodireccion;
   private $csede_principaldireccion;
   private $nid_localidaddireccion;
   private $cdirecciondespaho;
   private $estatus_personaproveedor; 
   private $dfecha_desactivacionproveedor; 
   private $pgsql; 
	 
   public function __construct(){
     $this->crif_personaproveedor=null;
     $this->cnombreproveedor=null;
     $this->ctelefhabproveedor=null;
     $this->ctelefmovproveedor=null;
     $this->cemailproveedor=null;
     $this->nid_condicionpago=null;
     $this->nid_localidadproveedor=null;
     $this->cdireccionproveedor=null;
  	 $this->pgsql=new Conexion();
   }
   
 public function __destruct(){}

  public function Transaccion($value){
    if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
    if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
    if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();

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

   public function ctelefhabproveedor(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->ctelefhabproveedor;
     
	 if($Num_Parametro>0){
	   $this->ctelefhabproveedor=func_get_arg(0);
	 }
   }
   
   public function ctelefmovproveedor(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->ctelefmovproveedor;
     
	 if($Num_Parametro>0){
	   $this->ctelefmovproveedor=func_get_arg(0);
	 }
   }

   public function cemailproveedor(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cemailproveedor;
     
	 if($Num_Parametro>0){
	   $this->cemailproveedor=func_get_arg(0);
	 }
   }

   public function nid_condicionpago(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nid_condicionpago;
     
   if($Num_Parametro>0){
     $this->nid_condicionpago=func_get_arg(0);
   }
   }

   public function nid_localidadproveedor(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_localidadproveedor;
     
	 if($Num_Parametro>0){
	   $this->nid_localidadproveedor=func_get_arg(0);
	 }
   }

   public function cdireccionproveedor(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cdireccionproveedor;
     
	 if($Num_Parametro>0){
	   $this->cdireccionproveedor=func_get_arg(0);
	 }
   }

   public function estatusproveedor(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->estatusproveedor;
     
	 if($Num_Parametro>0){
	   $this->estatusproveedor=func_get_arg(0);
	 }
   }

   public function dfecha_desactivacionproveedor(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->dfecha_desactivacionproveedor;
     
	 if($Num_Parametro>0){
	   $this->dfecha_desactivacionproveedor=func_get_arg(0);
	 }
   }

   public function nid_localidaddireccion(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nid_localidaddireccion;
     
   if($Num_Parametro>0){
     $this->nid_localidaddireccion=func_get_arg(0);
   }
   }

   public function cdirecciondespaho(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->cdirecciondespaho;
     
   if($Num_Parametro>0){
     $this->cdirecciondespaho=func_get_arg(0);
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

   public function EliminarDirecciones(){
    $sql="DELETE FROM general.tdireccion_despacho dp WHERE crif_persona = '$this->crif_personaproveedor' 
    AND (NOT EXISTS (SELECT 1 FROM general.tpersona_contacto pc WHERE dp.nid_direcciondespacho = pc.nid_direcciondespacho) 
    AND NOT EXISTS (SELECT 1 FROM facturacion.tdocumento d WHERE dp.nid_direcciondespacho = d.nid_direcciondespacho))";
    if($this->pgsql->Ejecutar($sql)!=null)
      return true;
    else
      return false;
   }
   
  public function InsertarDirecciones($user){
    $sql1="SELECT * FROM general.tdireccion_despacho WHERE ctelefono='$this->ctelefonodireccion' 
    AND csede_principal='$this->csede_principaldireccion' AND nid_localidad='$this->nid_localidaddireccion' 
    AND cdireccion='$this->cdirecciondespaho'";
    $query=$this->pgsql->Ejecutar($sql1);
    if($this->pgsql->Total_Filas($query)==0){
      $sql="INSERT INTO general.tdireccion_despacho(crif_persona,ctelefono,csede_principal,nid_localidad,cdireccion,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
      VALUES ('$this->crif_personaproveedor','$this->ctelefonodireccion','$this->csede_principaldireccion','$this->nid_localidaddireccion','$this->cdirecciondespaho',NOW(),'$user',NOW(),'$user')";
      if($this->pgsql->Ejecutar($sql)!=null)
        return true;
      else
        return false;
    }else{
      $proveedor=$this->pgsql->Respuesta($query);
      $sql="UPDATE general.tdireccion_despacho SET ctelefono='$this->ctelefonodireccion',csede_principal='$this->csede_principaldireccion',
      nid_localidad='$this->nid_localidaddireccion',cdireccion='$this->cdirecciondespaho',dmodificado_desde=NOW(), cmodificado_por='$user' 
      WHERE nid_direcciondespacho = '".$proveedor['nid_direcciondespacho']."'";
      if($this->pgsql->Ejecutar($sql)!=null)
        return true;
      else
        return false;
    }
  }

   public function Registrar($user){
    $sql="INSERT INTO general.tpersona (crif_persona,cnombre,cdireccion,ctelefhab,ctelefmov,cemail,nid_condicionpago,nid_localidad,ntipo_persona,dcreado_desde,ccreado_por,dmodificado_desde,
      cmodificado_por) VALUES ('$this->crif_personaproveedor','$this->cnombreproveedor','$this->cdireccionproveedor','$this->ctelefhabproveedor','$this->ctelefmovproveedor','$this->cemailproveedor','$this->nid_condicionpago',
      '$this->nid_localidadproveedor',(select nid_combovalor from general.tcombo_valor where ctabla='tpersona' AND lower(cdescripcion) like '%proveedor%'),NOW(),'$user',NOW(),'$user')";
  
    if($this->pgsql->Ejecutar($sql)!=null)
    	return true;
		else
			return false;
   }
   
    public function Activar($user){
    $sql="UPDATE general.tpersona SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),cmodificado_por='$user' WHERE crif_persona = '$this->crif_personaproveedor'";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }

    public function Desactivar($user){
    $sqlx="SELECT * FROM general.tpersona p WHERE p.crif_persona = '$this->crif_personaproveedor'
    AND (EXISTS (SELECT 1 FROM general.tdireccion_despacho dd WHERE p.crif_persona = dd.crif_persona) 
    OR EXISTS (SELECT 1 FROM general.tpersona_contacto pc WHERE p.crif_persona = pc.crif_persona) 
    OR EXISTS (SELECT 1 FROM facturacion.tdocumento d WHERE p.crif_persona = d.crif_persona))";
    $sql="UPDATE general.tpersona SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),cmodificado_por='$user' WHERE crif_persona = '$this->crif_personaproveedor'";
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
    $sql="UPDATE general.tpersona SET crif_persona='$this->crif_personaproveedor',
    cnombre='$this->cnombreproveedor',ctelefhab='$this->ctelefhabproveedor',ctelefmov='$this->ctelefmovproveedor',
    cemail='$this->cemailproveedor',nid_condicionpago='$this->nid_condicionpago',nid_localidad='$this->nid_localidadproveedor',
    cdireccion='$this->cdireccionproveedor',dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE crif_persona='$this->crif_personaproveedor'";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }
   
   public function Consultar(){
    $sql="SELECT *,(CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
    ELSE 'Desactivado' END) AS estatusproveedor FROM general.tpersona WHERE crif_persona='$this->crif_personaproveedor'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$proveedor=$this->pgsql->Respuesta($query);
	$this->crif_personaproveedor($proveedor['crif_persona']);
	$this->cnombreproveedor($proveedor['cnombre']);
	$this->ctelefhabproveedor($proveedor['ctelefhab']);
	$this->ctelefmovproveedor($proveedor['ctelefmov']);
	$this->cemailproveedor($proveedor['cemail']);
  $this->nid_condicionpago($proveedor['nid_condicionpago']);
	$this->nid_localidadproveedor($proveedor['nid_localidad']);
	$this->cdireccionproveedor($proveedor['cdireccion']);
  $this->estatusproveedor($proveedor['estatusproveedor']);
	$this->dfecha_desactivacionproveedor($proveedor['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   public function Comprobar(){
    $sql="SELECT * FROM general.tpersona WHERE crif_persona='$this->crif_personaproveedor'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$proveedor=$this->pgsql->Respuesta($query);
	$this->crif_personaproveedor($proveedor['crif_persona']);
	$this->cnombreproveedor($proveedor['cnombre']);
	$this->ctelefhabproveedor($proveedor['ctelefhab']);
	$this->ctelefmovproveedor($proveedor['ctelefmov']);
	$this->cemailproveedor($proveedor['cemail']);
  $this->nid_condicionpago($proveedor['nid_condicionpago']);
	$this->nid_localidadproveedor($proveedor['nid_localidad']);
	$this->cdireccionproveedor($proveedor['cdireccion']);
	$this->dfecha_desactivacionproveedor($proveedor['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
}
?>