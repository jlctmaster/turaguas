<?php
 require_once("class_bd.php");
 class SolicitudCompra
 {
   private $nid_documentocompra; 
   private $nid_tipodocumento;
   private $nnro_solicitud; 
   private $dfecha_documento;
   private $nlinea; 
   private $cid_articulo;
   private $ncantidad_articulo; 
   private $ncantidad_articulo_viejo; 
   private $estatus; 
   private $dfecha_desactivacion; 
   private $pgsql; 
	 
   public function __construct(){
     $this->nid_documentocompra=null;
     $this->nid_tipodocumento=null;
     $this->nnro_solicitud=null;
     $this->dfecha_documento=null;
     $this->nlinea=null;
     $this->cid_articulo=null;
     $this->ncantidad_articulo=null;
     $this->ncantidad_articulo_viejo=null;
  	 $this->pgsql=new Conexion();
   }
   
 public function __destruct(){}

  public function Transaccion($value){
    if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
    if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
    if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();

  }
  public function nid_documentocompra(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_documentocompra;
     
	 if($Num_Parametro>0){
	   $this->nid_documentocompra=func_get_arg(0);
	 }
   }
   
   public function nid_tipodocumento(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_tipodocumento;
     
	 if($Num_Parametro>0){
	   $this->nid_tipodocumento=func_get_arg(0);
	 }
   }

   public function nnro_solicitud(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nnro_solicitud;
     
	 if($Num_Parametro>0){
	   $this->nnro_solicitud=func_get_arg(0);
	 }
   }
   
   public function dfecha_documento(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->dfecha_documento;
     
	 if($Num_Parametro>0){
	   $this->dfecha_documento=func_get_arg(0);
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
    $sql="SELECT MAX(CAST(nnro_solicitud AS NUMERIC)) nnro_solicitud FROM facturacion.tdocumentocompra WHERE nnro_recepcion IS NULL";
    $query=$this->pgsql->Ejecutar($sql);
    if($row=$this->pgsql->Respuesta($query)){
      $numero=$row['nnro_solicitud'];
      while (strlen($numero)<10){
        $numero="0".$numero;
      }
      return $numero;
    }else{
      return 0;
    }
   }

  public function GenerarNroSolicitud(){
    $sql="SELECT CASE WHEN MAX(CAST(nnro_solicitud AS NUMERIC)) IS NULL THEN 1 ELSE MAX(CAST(nnro_solicitud AS NUMERIC))+1 END nnro_solicitud 
    FROM facturacion.tdocumentocompra WHERE nnro_recepcion IS NULL";
    $query=$this->pgsql->Ejecutar($sql);
    if($row=$this->pgsql->Respuesta($query)){
      $numero=$row['nnro_solicitud'];
      while (strlen($numero)<10){
        $numero="0".$numero;
      }
      return $numero;
    }else{
      return 0;
    }
  }

   public function Registrar($user){
    $this->nnro_solicitud($this->GenerarNroSolicitud());
    $sql="INSERT INTO facturacion.tdocumentocompra (nnro_solicitud,nid_tipodocumento,dfecha_documento,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
    VALUES ('$this->nnro_solicitud','$this->nid_tipodocumento','$this->dfecha_documento',NOW(),'$user',NOW(),'$user')";
    if($this->pgsql->Ejecutar($sql)!=null)
    	return true;
		else
			return false;
   }
   
    public function Activar($user){
    $sql="UPDATE facturacion.tdocumentocompra SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),cmodificado_por='$user' WHERE nid_documentocompra = '$this->nid_documentocompra'";
      if($this->pgsql->Ejecutar($sql)!=null)
  	return true;
  	else
  	return false;
   }

    public function Desactivar($user){
    $sqlx="SELECT * FROM facturacion.tdocumentocompra dc WHERE dc.nid_documentocompra = '$this->nid_documentocompra'
    AND EXISTS (SELECT 1 FROM facturacion.tdocumentocompra dcr WHERE dc.nnro_solicitud = dcr.nnro_solicitud AND dcr.nnro_recepcion IS NOT NULL)";
    $sql="UPDATE facturacion.tdocumentocompra SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),cmodificado_por='$user' WHERE nid_documentocompra = '$this->nid_documentocompra'";
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
    $sql="UPDATE facturacion.tdocumentocompra SET nid_tipodocumento='$this->nid_tipodocumento',
    dfecha_documento='$this->dfecha_documento',dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE nid_documentocompra='$this->nid_documentocompra'";
    if($this->pgsql->Ejecutar($sql)!=null)
  	 return true;
  	else
  	 return false;
   }
   
   public function Consultar(){
    $sql="SELECT DISTINCT nid_documentocompra,nid_tipodocumento,nnro_solicitud,TO_CHAR(dfecha_documento,'DD/MM/YYYY') dfecha_documento,
    dfecha_desactivacion,(CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' ELSE 'Desactivado' END) AS estatus 
    FROM facturacion.vw_solicitudcompra WHERE nnro_solicitud='$this->nnro_solicitud'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$solicitudcompra=$this->pgsql->Respuesta($query);
	$this->nid_documentocompra($solicitudcompra['nid_documentocompra']);
	$this->nid_tipodocumento($solicitudcompra['nid_tipodocumento']);
	$this->nnro_solicitud($solicitudcompra['nnro_solicitud']);
	$this->dfecha_documento($solicitudcompra['dfecha_documento']);
  $this->estatus($solicitudcompra['estatus']);
	$this->dfecha_desactivacion($solicitudcompra['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   public function Comprobar(){
    $sql="SELECT * FROM facturacion.vw_solicitudcompra WHERE nnro_solicitud='$this->nnro_solicitud'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$solicitudcompra=$this->pgsql->Respuesta($query);
  $this->nid_documentocompra($solicitudcompra['nid_documentocompra']);
  $this->nid_tipodocumento($solicitudcompra['nid_tipodocumento']);
  $this->nnro_solicitud($solicitudcompra['nnro_solicitud']);
  $this->dfecha_documento($solicitudcompra['dfecha_documento']);
  $this->dfecha_desactivacion($solicitudcompra['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   
  public function InsertarDetalle($user){
    $sql1="SELECT * FROM facturacion.tdetalle_documentocompra WHERE nlinea='$this->nlinea' AND cid_articulo='$this->cid_articulo' 
    AND nid_documentocompra = (SELECT nid_documentocompra FROM facturacion.tdocumentocompra WHERE nnro_solicitud = '$this->nnro_solicitud' AND nnro_recepcion IS NULL)";
    $query=$this->pgsql->Ejecutar($sql1);
    if($this->pgsql->Total_Filas($query)==0){
      $sql="INSERT INTO facturacion.tdetalle_documentocompra (nid_documentocompra,nlinea,cid_articulo,ncantidad_articulo,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
      VALUES ((SELECT nid_documentocompra FROM facturacion.tdocumentocompra WHERE nnro_solicitud = '$this->nnro_solicitud' AND nnro_recepcion IS NULL),'$this->nlinea','$this->cid_articulo','$this->ncantidad_articulo',NOW(),'$user',NOW(),'$user')";
      if($this->pgsql->Ejecutar($sql)!=null)
        //$this->ComprobarAlmacen($this->cid_articulo,$this->nid_almacen,$this->ncantidad_articulo,$user);
        return true;
      else
        return false;
    }else{
      $sql="UPDATE facturacion.tdetalle_documentocompra SET nlinea='$this->nlinea',cid_articulo='$this->cid_articulo',
      ncantidad_articulo='$this->ncantidad_articulo',dmodificado_desde=NOW(), cmodificado_por='$user' 
      WHERE nid_documentocompra = (SELECT nid_documentocompra FROM facturacion.tdocumentocompra WHERE nnro_solicitud = '$this->nnro_solicitud' AND nnro_recepcion IS NULL) 
      AND nlinea = '$this->nlinea'";
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
    $sql="UPDATE facturacion.tdetalle_documentocompra SET nlinea='$this->nlinea',cid_articulo='$this->cid_articulo',
      ncantidad_articulo='$this->ncantidad_articulo',dmodificado_desde=NOW(), cmodificado_por='$user' 
      WHERE nid_documentocompra = (SELECT nid_documentocompra FROM facturacion.tdocumentocompra WHERE nnro_solicitud = '$this->nnro_solicitud' AND nnro_recepcion IS NULL) 
      AND nlinea = '$this->nlinea'";
      if($this->pgsql->Ejecutar($sql)!=null){
        $cantidad=$this->ncantidad_articulo-$this->ncantidad_articulo_viejo;
        $this->ComprobarAlmacen($this->cid_articulo,$this->nid_almacen,$cantidad,$user);
      }
      else
        return false;
  }

  public function ComprobarAlmacen($articulo,$almacen,$cant_articulos,$user){
    $sql="SELECT * FROM inventario.tinventario WHERE cid_articulo = '$articulo' AND nid_almacen = '$almacen' 
    AND nestatus_inventario = (SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tinventario' 
    AND (LOWER(cdescripcion) LIKE '%ordenado%' OR LOWER(cdescripcion) LIKE '%productos ordenados%'))";
    $query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=null){
      if($cant_articulos>=0)
        $signo="+";
      else
        $signo="";
      $sqlx="UPDATE inventario.tinventario SET nexistencia=nexistencia".$signo.$cant_articulos.",dmodificado_desde=NOW(),cmodificado_por='$user' 
      WHERE cid_articulo = '$articulo' AND nid_almacen = '$almacen' AND nestatus_inventario = 
      (SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tinventario' 
      AND (LOWER(cdescripcion) LIKE '%ordenado%' OR LOWER(cdescripcion) LIKE '%productos ordenados%'))";
      if($this->pgsql->Ejecutar($sqlx)!=null)
        return true;
      else
        return false;
    }
    else{
      $sqlx="INSERT INTO inventario.tinventario (cid_articulo,nid_almacen,nexistencia,nestatus_inventario,
      dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES ('$articulo','$almacen','$cant_articulos',
      (SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tinventario' 
      AND (LOWER(cdescripcion) LIKE '%ordenado%' OR LOWER(cdescripcion) LIKE '%productos ordenados%')),NOW(),'$user',NOW(),'$user')";
      if($this->pgsql->Ejecutar($sqlx)!=null)
        return true;
      else
        return false;
    }
  }
}
?>