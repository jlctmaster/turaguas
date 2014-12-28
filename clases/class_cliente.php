<?php
 require_once("class_bd.php");
 class Cliente
 {
   private $crif_personacliente; 
   private $cnombrecliente;
   private $ctelefhabcliente; 
   private $ctelefmovcliente; 
   private $cemailcliente;
   private $nid_condicionpago;
   private $nid_localidadcliente;
   private $cdireccioncliente; 
   private $ctelefonodireccion;
   private $csede_principaldireccion;
   private $nid_localidaddireccion;
   private $cdirecciondespaho;
   private $estatus_personacliente; 
   private $dfecha_desactivacioncliente; 
   private $pgsql; 
	 
   public function __construct(){
     $this->crif_personacliente=null;
     $this->cnombrecliente=null;
     $this->ctelefhabcliente=null;
     $this->ctelefmovcliente=null;
     $this->cemailcliente=null;
     $this->nid_condicionpago=null;
     $this->nid_localidadcliente=null;
     $this->cdireccioncliente=null;
  	 $this->pgsql=new Conexion();
   }
   
 public function __destruct(){}

  public function Transaccion($value){
    if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
    if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
    if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();

  }
  public function crif_personacliente(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->crif_personacliente;
     
	 if($Num_Parametro>0){
	   $this->crif_personacliente=func_get_arg(0);
	 }
   }
   
   public function cnombrecliente(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cnombrecliente;
     
	 if($Num_Parametro>0){
	   $this->cnombrecliente=func_get_arg(0);
	 }
   }

   public function ctelefhabcliente(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->ctelefhabcliente;
     
	 if($Num_Parametro>0){
	   $this->ctelefhabcliente=func_get_arg(0);
	 }
   }
   
   public function ctelefmovcliente(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->ctelefmovcliente;
     
	 if($Num_Parametro>0){
	   $this->ctelefmovcliente=func_get_arg(0);
	 }
   }

   public function cemailcliente(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cemailcliente;
     
	 if($Num_Parametro>0){
	   $this->cemailcliente=func_get_arg(0);
	 }
   }

   public function nid_condicionpago(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nid_condicionpago;
     
   if($Num_Parametro>0){
     $this->nid_condicionpago=func_get_arg(0);
   }
   }

   public function nid_localidadcliente(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_localidadcliente;
     
	 if($Num_Parametro>0){
	   $this->nid_localidadcliente=func_get_arg(0);
	 }
   }

   public function cdireccioncliente(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cdireccioncliente;
     
	 if($Num_Parametro>0){
	   $this->cdireccioncliente=func_get_arg(0);
	 }
   }

   public function estatuscliente(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->estatuscliente;
     
	 if($Num_Parametro>0){
	   $this->estatuscliente=func_get_arg(0);
	 }
   }

   public function dfecha_desactivacioncliente(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->dfecha_desactivacioncliente;
     
	 if($Num_Parametro>0){
	   $this->dfecha_desactivacioncliente=func_get_arg(0);
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
    $sql="DELETE FROM general.tdireccion_despacho dp WHERE crif_persona = '$this->crif_personacliente' 
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
      VALUES ('$this->crif_personacliente','$this->ctelefonodireccion','$this->csede_principaldireccion','$this->nid_localidaddireccion','$this->cdirecciondespaho',NOW(),'$user',NOW(),'$user')";
      if($this->pgsql->Ejecutar($sql)!=null)
        return true;
      else
        return false;
    }else{
      $cliente=$this->pgsql->Respuesta($query);
      $sql="UPDATE general.tdireccion_despacho SET ctelefono='$this->ctelefonodireccion',csede_principal='$this->csede_principaldireccion',
      nid_localidad='$this->nid_localidaddireccion',cdireccion='$this->cdirecciondespaho',dmodificado_desde=NOW(), cmodificado_por='$user' 
      WHERE nid_direcciondespacho = '".$cliente['nid_direcciondespacho']."'";
      if($this->pgsql->Ejecutar($sql)!=null)
        return true;
      else
        return false;
    }
  }

   public function Registrar($user){
    $sql="INSERT INTO general.tpersona (crif_persona,cnombre,cdireccion,ctelefhab,ctelefmov,cemail,nid_condicionpago,nid_localidad,ntipo_persona,dcreado_desde,ccreado_por,dmodificado_desde,
      cmodificado_por) VALUES ('$this->crif_personacliente','$this->cnombrecliente','$this->cdireccioncliente','$this->ctelefhabcliente','$this->ctelefmovcliente','$this->cemailcliente','$this->nid_condicionpago',
      '$this->nid_localidadcliente',(select nid_combovalor from general.tcombo_valor where ctabla='tpersona' AND lower(cdescripcion) like '%cliente%'),NOW(),'$user',NOW(),'$user')";
    if($this->pgsql->Ejecutar($sql)!=null)
    	return true;
		else
			return false;
   }
   
    public function Activar($user){
    $sql="UPDATE general.tpersona SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),cmodificado_por='$user' WHERE crif_persona = '$this->crif_personacliente'";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }

    public function Desactivar($user){
    $sqlx="SELECT * FROM general.tpersona p WHERE p.crif_persona = '$this->crif_personacliente'
    AND (EXISTS (SELECT 1 FROM general.tdireccion_despacho dd WHERE p.crif_persona = dd.crif_persona) 
    OR EXISTS (SELECT 1 FROM general.tpersona_contacto pc WHERE p.crif_persona = pc.crif_persona) 
    OR EXISTS (SELECT 1 FROM facturacion.tdocumento d WHERE p.crif_persona = d.crif_persona))";
    $sql="UPDATE general.tpersona SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),cmodificado_por='$user' WHERE crif_persona = '$this->crif_personacliente'";
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
    $sql="UPDATE general.tpersona SET crif_persona='$this->crif_personacliente',
    cnombre='$this->cnombrecliente',ctelefhab='$this->ctelefhabcliente',ctelefmov='$this->ctelefmovcliente',
    cemail='$this->cemailcliente',nid_condicionpago='$this->nid_condicionpago',nid_localidad='$this->nid_localidadcliente',
    cdireccion='$this->cdireccioncliente',dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE crif_persona='$this->crif_personacliente'";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }
   
   public function Consultar(){
    $sql="SELECT *,(CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
    ELSE 'Desactivado' END) AS estatuscliente FROM general.tpersona WHERE crif_persona='$this->crif_personacliente'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$cliente=$this->pgsql->Respuesta($query);
	$this->crif_personacliente($cliente['crif_persona']);
	$this->cnombrecliente($cliente['cnombre']);
	$this->ctelefhabcliente($cliente['ctelefhab']);
	$this->ctelefmovcliente($cliente['ctelefmov']);
	$this->cemailcliente($cliente['cemail']);
  $this->nid_condicionpago($cliente['nid_condicionpago']);
	$this->nid_localidadcliente($cliente['nid_localidad']);
	$this->cdireccioncliente($cliente['cdireccion']);
  $this->estatuscliente($cliente['estatuscliente']);
	$this->dfecha_desactivacioncliente($cliente['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   public function Comprobar(){
    $sql="SELECT * FROM general.tpersona WHERE crif_persona='$this->crif_personacliente'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$cliente=$this->pgsql->Respuesta($query);
	$this->crif_personacliente($cliente['crif_persona']);
	$this->cnombrecliente($cliente['cnombre']);
	$this->ctelefhabcliente($cliente['ctelefhab']);
	$this->ctelefmovcliente($cliente['ctelefmov']);
	$this->cemailcliente($cliente['cemail']);
  $this->nid_condicionpago($cliente['nid_condicionpago']);
	$this->nid_localidadcliente($cliente['nid_localidad']);
	$this->cdireccioncliente($cliente['cdireccion']);
	$this->dfecha_desactivacioncliente($cliente['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
}
?>