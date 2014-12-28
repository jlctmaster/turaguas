<?php
 require_once("class_bd.php");
 class Cotizacion
 {
   private $nid_documentoventa; 
   private $nid_tipodocumento;
   private $nnro_cotizacion; 
   private $dfecha_documento;
   private $crif_persona; 
   private $cnombre;
   private $nid_condicionpago;
   private $nlinea; 
   private $cid_articulo;
   private $ncantidad_articulo; 
   private $ncantidad_articulo_viejo; 
   private $nprecio; 
   private $estatus; 
   private $dfecha_desactivacion; 
   private $pgsql; 
	 
   public function __construct(){
     $this->nid_documentoventa=null;
     $this->nid_tipodocumento=null;
     $this->nnro_cotizacion=null;
     $this->dfecha_documento=null;
     $this->crif_persona=null;
     $this->cnombre=null;
     $this->nid_condicionpago=null;
     $this->nlinea=null;
     $this->cid_articulo=null;
     $this->ncantidad_articulo=null;
     $this->ncantidad_articulo_viejo=null;
     $this->nprecio=null;
  	 $this->pgsql=new Conexion();
   }
   
 public function __destruct(){}

  public function Transaccion($value){
    if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
    if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
    if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();

  }
  public function nid_documentoventa(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_documentoventa;
     
	 if($Num_Parametro>0){
	   $this->nid_documentoventa=func_get_arg(0);
	 }
   }
   
   public function nid_tipodocumento(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_tipodocumento;
     
	 if($Num_Parametro>0){
	   $this->nid_tipodocumento=func_get_arg(0);
	 }
   }

   public function nnro_cotizacion(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nnro_cotizacion;
     
	 if($Num_Parametro>0){
	   $this->nnro_cotizacion=func_get_arg(0);
	 }
   }
   
   public function dfecha_documento(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->dfecha_documento;
     
	 if($Num_Parametro>0){
	   $this->dfecha_documento=func_get_arg(0);
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
   
   public function nid_condicionpago(){
   $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nid_condicionpago;
     
   if($Num_Parametro>0){
     $this->nid_condicionpago=func_get_arg(0);
   }
   }

   public function nlinea(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nlinea;
     
	 if($Num_Parametro>0){
	   $this->nlinea=func_get_arg(0);
	 }
   }

   public function cid_articulo(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->cid_articulo;
     
   if($Num_Parametro>0){
     $this->cid_articulo=func_get_arg(0);
   }
   }

   public function ncantidad_articulo(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->ncantidad_articulo;
     
	 if($Num_Parametro>0){
	   $this->ncantidad_articulo=func_get_arg(0);
	 }
   }

   public function ncantidad_articulo_viejo(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->ncantidad_articulo_viejo;
     
   if($Num_Parametro>0){
     $this->ncantidad_articulo_viejo=func_get_arg(0);
   }
   }

   public function nprecio(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nprecio;
     
   if($Num_Parametro>0){
     $this->nprecio=func_get_arg(0);
   }
   }

   public function estatus(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->estatus;
     
	 if($Num_Parametro>0){
	   $this->estatus=func_get_arg(0);
	 }
   }

   public function dfecha_desactivacion(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->dfecha_desactivacion;
     
	 if($Num_Parametro>0){
	   $this->dfecha_desactivacion=func_get_arg(0);
	 }
   }

   public function BuscarNuevoRegistro(){
    $sql="SELECT MAX(CAST(nnro_cotizacion AS NUMERIC)) nnro_cotizacion FROM facturacion.tdocumentoventa WHERE nnro_entrega IS NULL";
    $query=$this->pgsql->Ejecutar($sql);
    if($row=$this->pgsql->Respuesta($query)){
      $numero=$row['nnro_cotizacion'];
      while (strlen($numero)<10){
        $numero="0".$numero;
      }
      return $numero;
    }else{
      return 0;
    }
   }

  public function GenerarNroCotizacion(){
    $sql="SELECT CASE WHEN MAX(CAST(nnro_cotizacion AS NUMERIC)) IS NULL THEN 1 ELSE MAX(CAST(nnro_cotizacion AS NUMERIC))+1 END nnro_cotizacion 
    FROM facturacion.tdocumentoventa WHERE nnro_entrega IS NULL";
    $query=$this->pgsql->Ejecutar($sql);
    if($row=$this->pgsql->Respuesta($query)){
      $numero=$row['nnro_cotizacion'];
      while (strlen($numero)<10){
        $numero="0".$numero;
      }
      return $numero;
    }else{
      return 0;
    }
  }

   public function Registrar($user){
    $this->nnro_cotizacion($this->GenerarNroCotizacion());
    $sql="INSERT INTO facturacion.tdocumentoventa (nnro_cotizacion,nid_tipodocumento,dfecha_documento,crif_persona,nid_condicionpago,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
    VALUES ('$this->nnro_cotizacion','$this->nid_tipodocumento','$this->dfecha_documento','$this->crif_persona','$this->nid_condicionpago',NOW(),'$user',NOW(),'$user')";
    if($this->pgsql->Ejecutar($sql)!=null)
    	return true;
		else
			return false;
   }
   
    public function Activar($user){
    $sql="UPDATE facturacion.tdocumentoventa SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),cmodificado_por='$user' WHERE nid_documentoventa = '$this->nid_documentoventa'";
      if($this->pgsql->Ejecutar($sql)!=null)
  	return true;
  	else
  	return false;
   }

    public function Desactivar($user){
    $sqlx="SELECT * FROM facturacion.tdocumentoventa dc WHERE dc.nid_documentoventa = '$this->nid_documentoventa'
    AND EXISTS (SELECT 1 FROM facturacion.tdocumentoventa dcr WHERE dc.nnro_cotizacion = dcr.nnro_cotizacion AND dcr.nnro_entrega IS NOT NULL)";
    $sql="UPDATE facturacion.tdocumentoventa SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),cmodificado_por='$user' WHERE nid_documentoventa = '$this->nid_documentoventa'";
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
    $sql="UPDATE facturacion.tdocumentoventa SET nid_tipodocumento='$this->nid_tipodocumento',
    dfecha_documento='$this->dfecha_documento',crif_persona='$this->crif_persona',nid_condicionpago='$this->nid_condicionpago',
    dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE nid_documentoventa='$this->nid_documentoventa'";
    if($this->pgsql->Ejecutar($sql)!=null)
  	 return true;
  	else
  	 return false;
   }
   
   public function Consultar(){
    $sql="SELECT DISTINCT c.nid_documentoventa,c.nid_tipodocumento,c.nnro_cotizacion,TO_CHAR(c.dfecha_documento,'DD/MM/YYYY') dfecha_documento,
    c.crif_persona,c.nid_condicionpago,p.cnombre,c.dfecha_desactivacion,(CASE WHEN c.dfecha_desactivacion IS NULL THEN  'Activo' ELSE 'Desactivado' END) AS estatus 
    FROM facturacion.vw_cotizacion c 
    INNER JOIN general.tpersona p ON c.crif_persona = p.crif_persona 
    WHERE c.nnro_cotizacion='$this->nnro_cotizacion'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$cotizacion=$this->pgsql->Respuesta($query);
	$this->nid_documentoventa($cotizacion['nid_documentoventa']);
	$this->nid_tipodocumento($cotizacion['nid_tipodocumento']);
	$this->nnro_cotizacion($cotizacion['nnro_cotizacion']);
	$this->dfecha_documento($cotizacion['dfecha_documento']);
  $this->crif_persona($cotizacion['crif_persona']);
  $this->cnombre($cotizacion['cnombre']);
  $this->nid_condicionpago($cotizacion['nid_condicionpago']);
  $this->estatus($cotizacion['estatus']);
	$this->dfecha_desactivacion($cotizacion['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   public function Comprobar(){
    $sql="SELECT * FROM facturacion.vw_cotizacion WHERE nnro_cotizacion='$this->nnro_cotizacion'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$cotizacion=$this->pgsql->Respuesta($query);
  $this->nid_documentoventa($cotizacion['nid_documentoventa']);
  $this->nid_tipodocumento($cotizacion['nid_tipodocumento']);
  $this->nnro_cotizacion($cotizacion['nnro_cotizacion']);
  $this->dfecha_documento($cotizacion['dfecha_documento']);
  $this->crif_persona($cotizacion['crif_persona']);
  $this->nid_condicionpago($cotizacion['nid_condicionpago']);
  $this->dfecha_desactivacion($cotizacion['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   
  public function InsertarDetalle($user){
    $sql1="SELECT * FROM facturacion.tdetalle_documentoventa WHERE nlinea='$this->nlinea' AND cid_articulo='$this->cid_articulo'
    AND nid_documentoventa = (SELECT nid_documentoventa FROM facturacion.tdocumentoventa WHERE nnro_cotizacion = '$this->nnro_cotizacion' AND nnro_entrega IS NULL)";
    $query=$this->pgsql->Ejecutar($sql1);
    if($this->pgsql->Total_Filas($query)==0){
      $sql="INSERT INTO facturacion.tdetalle_documentoventa (nid_documentoventa,nlinea,cid_articulo,ncantidad_articulo,nprecio,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
      VALUES ((SELECT nid_documentoventa FROM facturacion.tdocumentoventa WHERE nnro_cotizacion = '$this->nnro_cotizacion' AND nnro_entrega IS NULL),
      '$this->nlinea','$this->cid_articulo','$this->ncantidad_articulo','$this->nprecio',NOW(),'$user',NOW(),'$user')";
      if($this->pgsql->Ejecutar($sql)!=null)
        //$this->ComprobarAlmacen($this->cid_articulo,$this->nid_almacen,$this->ncantidad_articulo,$user);
        return true;
      else
        return false;
    }else{
      $sql="UPDATE facturacion.tdetalle_documentoventa SET nlinea='$this->nlinea',cid_articulo='$this->cid_articulo',ncantidad_articulo='$this->ncantidad_articulo',
      nprecio='$this->nprecio',dmodificado_desde=NOW(), cmodificado_por='$user' 
      WHERE nid_documentoventa = (SELECT nid_documentoventa FROM facturacion.tdocumentoventa WHERE nnro_cotizacion = '$this->nnro_cotizacion' AND nnro_entrega IS NULL) 
      AND nlinea='$this->nlinea'";
      if($this->pgsql->Ejecutar($sql)!=null){
        /*$cantidad=$this->ncantidad_articulo-$this->ncantidad_articulo_viejo;
        $this->ComprobarAlmacen($this->cid_articulo,$this->nid_almacen,$cantidad,$user);*/
        return true;
      }
      else
        return false;
    }
  }

  public function ActualizarDetalle($user){
    $sql="UPDATE facturacion.tdetalle_documentoventa SET nlinea='$this->nlinea',cid_articulo='$this->cid_articulo',ncantidad_articulo='$this->ncantidad_articulo',
      nprecio='$this->nprecio',dmodificado_desde=NOW(), cmodificado_por='$user' 
      WHERE nid_documentoventa = (SELECT nid_documentoventa FROM facturacion.tdocumentoventa WHERE nnro_cotizacion = '$this->nnro_cotizacion' AND nnro_entrega IS NULL) 
      AND nlinea='$this->nlinea'";
      if($this->pgsql->Ejecutar($sql)!=null){
        /*$cantidad=$this->ncantidad_articulo-$this->ncantidad_articulo_viejo;
        $this->ComprobarAlmacen($this->cid_articulo,$this->nid_almacen,$cantidad,$user);*/
        return true;
      }
      else
        return false;
  }

  public function ComprobarAlmacen($articulo,$almacen,$cant_articulos,$user){
    $sql="SELECT * FROM inventario.tinventario WHERE cid_articulo = '$articulo' AND nid_almacen = '$almacen' 
    AND nestatus_inventario = (SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tinventario' 
    AND (LOWER(cdescripcion) LIKE '%reservado%' OR LOWER(cdescripcion) LIKE '%productos reservados%'))";
    $query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=null){
      if($cant_articulos>=0)
        $signo="+";
      else
        $signo="";
      $sqlx="UPDATE inventario.tinventario SET nexistencia=nexistencia".$signo.$cant_articulos.",dmodificado_desde=NOW(),cmodificado_por='$user' 
      WHERE cid_articulo = '$articulo' AND nid_almacen = '$almacen' AND nestatus_inventario = 
      (SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tinventario' 
      AND (LOWER(cdescripcion) LIKE '%reservado%' OR LOWER(cdescripcion) LIKE '%productos reservados%'))";
      if($this->pgsql->Ejecutar($sqlx)!=null)
        return true;
      else
        return false;
    }
    else{
      $sqlx="INSERT INTO inventario.tinventario (cid_articulo,nid_almacen,nexistencia,nestatus_inventario,
      dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES ('$articulo','$almacen','$cant_articulos',
      (SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tinventario' 
      AND (LOWER(cdescripcion) LIKE '%reservado%' OR LOWER(cdescripcion) LIKE '%productos reservados%')),NOW(),'$user',NOW(),'$user')";
      if($this->pgsql->Ejecutar($sqlx)!=null)
        return true;
      else
        return false;
    }
  }

  public function BuscarDatosCliente($cliente){
    $sql="SELECT crif_persona,cnombre,nid_condicionpago FROM general.tpersona WHERE crif_persona = '$cliente'";
    $query = $this->pgsql->Ejecutar($sql);
    while($Obj=$this->pgsql->Respuesta_assoc($query)){
      $rows[]=array_map("html_entity_decode",$Obj);
    }
    if(!empty($rows)){
      $json = json_encode($rows);
    }
    else{
      $rows[] = array("msj" => "Error al Buscar Registros ");
      $json = json_encode($rows);
    }
    return $json;
  }

}
?>