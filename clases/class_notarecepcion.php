<?php
 require_once("class_bd.php");
 class NotaRecepcion
 {
   private $nid_documentocompra; 
   private $nid_tipodocumento;
   private $nnro_solicitud; 
   private $dfecha_documento;
   private $nnro_factura; 
   private $nnro_recepcion; 
   private $dfecha_recepcion;
   private $crif_persona;
   private $cnombre;
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
     $this->nnro_factura=null;
     $this->nnro_recepcion=null;
     $this->dfecha_recepcion=null;
     $this->crif_persona=null;
     $this->cnombre=null;
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

   public function nnro_factura(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nnro_factura;
     
   if($Num_Parametro>0){
     $this->nnro_factura=func_get_arg(0);
   }
   }

   public function nnro_recepcion(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nnro_recepcion;
     
   if($Num_Parametro>0){
     $this->nnro_recepcion=func_get_arg(0);
   }
   }
   
   public function dfecha_recepcion(){
   $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->dfecha_recepcion;
     
   if($Num_Parametro>0){
     $this->dfecha_recepcion=func_get_arg(0);
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
    $sql="SELECT MAX(CAST(nnro_recepcion AS NUMERIC)) nnro_recepcion FROM facturacion.tdocumentocompra WHERE nnro_recepcion IS NOT NULL";
    $query=$this->pgsql->Ejecutar($sql);
    if($row=$this->pgsql->Respuesta($query)){
      $numero=$row['nnro_recepcion'];
      while (strlen($numero)<10){
        $numero="0".$numero;
      }
      return $numero;
    }else{
      return 0;
    }
   }

   public function CrearMovimiento($user){
    $this->nnro_recepcion($this->BuscarNuevoRegistro());
    $sql="SELECT nid_documentocompra,nid_tipodocumento,dfecha_recepcion,'E' AS tipo 
    FROM facturacion.tdocumentocompra WHERE nnro_recepcion = '$this->nnro_recepcion'";
    $query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=null){
      $datos=$this->pgsql->Respuesta($query);
      if($this->GenerarMovimientoInventario($datos['nid_documentocompra'],$datos['nid_tipodocumento'],$datos['dfecha_recepcion'],$datos['tipo'],$user)==true)
        return true;
      else
        return false;
    }
    else
      return false;
   }

   public function ModificarMovimiento($user){
    $logico=false;
    $sql="SELECT mi.nid_movinventario,r.cid_articulo,r.ncantidad_articulo ncantidad, dmi.nvalor_actual-(dmi.ncantidad-r.ncantidad_articulo) nvalor_actual 
    FROM facturacion.vw_recepcion r 
    INNER JOIN inventario.tmovimiento_inventario mi ON r.nid_documentocompra = mi.nid_documento 
    INNER JOIN inventario.tdetalle_movimiento_inventario dmi ON mi.nid_movinventario = dmi.nid_movinventario AND r.cid_articulo = dmi.cid_articulo 
    WHERE r.nnro_recepcion = '$this->nnro_recepcion' 
    ORDER BY r.nlinea ASC";
    $query=$this->pgsql->Ejecutar($sql);
    while($datos=$this->pgsql->Respuesta($query)){
      if($this->ModificarMovimientoInventario($datos['nid_movinventario'],$datos['cid_articulo'],$datos['ncantidad'],$datos['nvalor_actual'],$user)==true)
        $logico=true;
      else
        $logico=false;
    }
    return $logico;
   }

  public function GenerarNroRecepcion(){
    $sql="SELECT CASE WHEN MAX(CAST(nnro_recepcion AS NUMERIC)) IS NULL THEN 1 ELSE MAX(CAST(nnro_recepcion AS NUMERIC))+1 END nnro_recepcion 
    FROM facturacion.tdocumentocompra WHERE nnro_recepcion IS NOT NULL";
    $query=$this->pgsql->Ejecutar($sql);
    if($row=$this->pgsql->Respuesta($query)){
      $numero=$row['nnro_recepcion'];
      while (strlen($numero)<10){
        $numero="0".$numero;
      }
      return $numero;
    }else{
      return 0;
    }
  }

   public function Registrar($user){
    $this->nnro_recepcion($this->GenerarNroRecepcion());
    $sql="INSERT INTO facturacion.tdocumentocompra (nnro_factura,nnro_recepcion,dfecha_recepcion,nid_tipodocumento,nnro_solicitud,dfecha_documento,crif_persona,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
    VALUES ('$this->nnro_factura','$this->nnro_recepcion','$this->dfecha_recepcion','$this->nid_tipodocumento','$this->nnro_solicitud','$this->dfecha_documento','$this->crif_persona',NOW(),'$user',NOW(),'$user')";
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
    AND EXISTS (SELECT 1 FROM facturacion.tdevolucion dv WHERE dc.nid_documentocompra=dv.nid_documentocompra)";
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
    $sql="UPDATE facturacion.tdocumentocompra SET nnro_factura='$this->nnro_factura',nid_tipodocumento='$this->nid_tipodocumento',crif_persona='$this->crif_persona',
    dfecha_documento='$this->dfecha_documento',dfecha_recepcion='$this->dfecha_recepcion',dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE nid_documentocompra='$this->nid_documentocompra'";
    if($this->pgsql->Ejecutar($sql)!=null)
  	 return true;
  	else
  	 return false;
   }
   
   public function Consultar(){
    $sql="SELECT DISTINCT r.nid_documentocompra,r.nid_tipodocumento,r.nnro_solicitud,TO_CHAR(r.dfecha_documento,'DD/MM/YYYY') dfecha_documento,
    r.nnro_factura,r.nnro_recepcion,TO_CHAR(r.dfecha_recepcion,'DD/MM/YYYY') dfecha_recepcion,r.crif_persona,p.cnombre,
    r.dfecha_desactivacion,(CASE WHEN r.dfecha_desactivacion IS NULL THEN  'Activo' ELSE 'Desactivado' END) AS estatus 
    FROM facturacion.vw_recepcion r 
    INNER JOIN general.tpersona p ON r.crif_persona = p.crif_persona 
    WHERE r.nnro_recepcion='$this->nnro_recepcion'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$recepcion=$this->pgsql->Respuesta($query);
	$this->nid_documentocompra($recepcion['nid_documentocompra']);
	$this->nid_tipodocumento($recepcion['nid_tipodocumento']);
	$this->nnro_solicitud($recepcion['nnro_solicitud']);
	$this->dfecha_documento($recepcion['dfecha_documento']);
  $this->nnro_factura($recepcion['nnro_factura']);
  $this->nnro_recepcion($recepcion['nnro_recepcion']);
  $this->dfecha_recepcion($recepcion['dfecha_recepcion']);
  $this->crif_persona($recepcion['crif_persona']);
  $this->cnombre($recepcion['cnombre']);
  $this->estatus($recepcion['estatus']);
	$this->dfecha_desactivacion($recepcion['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   public function Comprobar(){
    $sql="SELECT * FROM facturacion.vw_recepcion WHERE nnro_recepcion='$this->nnro_recepcion'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$recepcion=$this->pgsql->Respuesta($query);
  $this->nid_documentocompra($recepcion['nid_documentocompra']);
  $this->nid_tipodocumento($recepcion['nid_tipodocumento']);
  $this->nnro_solicitud($recepcion['nnro_solicitud']);
  $this->dfecha_documento($recepcion['dfecha_documento']);
  $this->nnro_factura($recepcion['nnro_factura']);
  $this->nnro_recepcion($recepcion['nnro_recepcion']);
  $this->dfecha_recepcion($recepcion['dfecha_recepcion']);
  $this->crif_persona($recepcion['crif_persona']);
  $this->dfecha_documento($recepcion['dfecha_documento']);
  $this->dfecha_desactivacion($recepcion['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   
  public function InsertarDetalle($user){
    $sql1="SELECT * FROM facturacion.tdetalle_documentocompra WHERE nlinea='$this->nlinea' AND cid_articulo='$this->cid_articulo' 
    AND nid_documentocompra = (SELECT nid_documentocompra FROM facturacion.tdocumentocompra WHERE nnro_recepcion = '$this->nnro_recepcion')";
    $query=$this->pgsql->Ejecutar($sql1);
    if($this->pgsql->Total_Filas($query)==0){
      $sql="INSERT INTO facturacion.tdetalle_documentocompra (nid_documentocompra,nlinea,cid_articulo,ncantidad_articulo,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
      VALUES ((SELECT nid_documentocompra FROM facturacion.tdocumentocompra WHERE nnro_recepcion = '$this->nnro_recepcion'),'$this->nlinea','$this->cid_articulo','$this->ncantidad_articulo',NOW(),'$user',NOW(),'$user')";
      if($this->pgsql->Ejecutar($sql)!=null)
        return true;
      else
        return false;
    }else{
      $sql="UPDATE facturacion.tdetalle_documentocompra SET nlinea='$this->nlinea',cid_articulo='$this->cid_articulo',
      ncantidad_articulo='$this->ncantidad_articulo',dmodificado_desde=NOW(), cmodificado_por='$user' 
      WHERE nid_documentocompra = (SELECT nid_documentocompra FROM facturacion.tdocumentocompra WHERE nnro_recepcion = '$this->nnro_recepcion') 
      AND nlinea = '$this->nlinea'";
      if($this->pgsql->Ejecutar($sql)!=null)
        return true;
      else
        return false;
    }
  }

  public function ActualizarDetalle($user){
    $sql="UPDATE facturacion.tdetalle_documentocompra SET nlinea='$this->nlinea',cid_articulo='$this->cid_articulo',
      ncantidad_articulo='$this->ncantidad_articulo',dmodificado_desde=NOW(), cmodificado_por='$user' 
      WHERE nid_documentocompra = (SELECT nid_documentocompra FROM facturacion.tdocumentocompra WHERE nnro_recepcion = '$this->nnro_recepcion') 
      AND nlinea = '$this->nlinea'";
      if($this->pgsql->Ejecutar($sql)!=null){
        return true;
      }
      else
        return false;
  }

  public function ModificarMovimientoInventario($movimiento,$articulo,$cantidad,$valor_actual,$user){
    $sql="UPDATE inventario.tdetalle_movimiento_inventario SET ncantidad=$cantidad,nvalor_actual=$valor_actual WHERE nid_movinventario = $movimiento AND cid_articulo = '$articulo'";
    if($this->pgsql->Ejecutar($sql)!=null)
      return true;
    else
      return false;
  }

  public function GenerarMovimientoInventario($documento,$tipodocumento,$fecha,$tipo,$user){
    $sql="INSERT INTO inventario.tmovimiento_inventario (nid_documento,nid_tipodocumento,dfecha_movinventario,ctipo_movinventario,
    dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES ('$documento','$tipodocumento','$fecha','$tipo',NOW(),'$user',NOW(),'$user')";
    if($this->pgsql->Ejecutar($sql)!=null){
      $sqlx="SELECT mi.nid_movinventario,d.cid_articulo,
      (SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tdetalle_movimiento_inventario' AND LOWER(cdescripcion) LIKE '%materia prima%') ntipo_inventario, 
      MAX(d.ncantidad_articulo) ncantidad, 
      LAST(CASE WHEN dmi.nvalor_actual IS NULL THEN 0 ELSE dmi.nvalor_actual END) nvalor_anterior,
      LAST(CASE WHEN dmi.nvalor_actual IS NULL THEN (d.ncantidad_articulo+0) ELSE (d.ncantidad_articulo+dmi.nvalor_actual) END) nvalor_actual 
      FROM facturacion.vw_recepcion d  
      INNER JOIN inventario.tmovimiento_inventario mi ON d.nid_documentocompra = mi.nid_documento 
      LEFT JOIN inventario.tdetalle_movimiento_inventario dmi ON d.cid_articulo = dmi.cid_articulo  AND dmi.ntipo_inventario = (SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tdetalle_movimiento_inventario' AND LOWER(cdescripcion) LIKE '%materia prima%')
      WHERE d.nid_documentocompra = '$documento' 
      GROUP BY d.nlinea,1,2,3 
      ORDER BY d.nlinea ASC";
      $query = $this->pgsql->Ejecutar($sqlx);
      while($rows=$this->pgsql->Respuesta($query)){
        $sql1 = "INSERT INTO inventario.tdetalle_movimiento_inventario (nid_movinventario,cid_articulo,ncantidad,nvalor_anterior,nvalor_actual,ntipo_inventario,
        dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES (".$rows['nid_movinventario'].",'".$rows['cid_articulo']."',
        ".$rows['ncantidad'].",".$rows['nvalor_anterior'].",".$rows['nvalor_actual'].",".$rows['ntipo_inventario'].",NOW(),'$user',NOW(),'$user')";
        if($this->pgsql->Ejecutar($sql1)!=null)
          $logico= true;
        else
          $logico= false;
      }
    }else{
      $logico= false;
    }
    return $logico;
  }

  public function BuscarDatosNroSolicitud($nnro_solicitud){
    $sql="SELECT sc.nnro_solicitud,TO_CHAR(sc.dfecha_documento,'DD/MM/YYYY') dfecha_documento,sc.nlinea,sc.cid_articulo,
    a.cdescripcion articulo,
    (MAX(sc.ncantidad_articulo)-SUM(CASE WHEN r.ncantidad_articulo IS NULL THEN 0 ELSE r.ncantidad_articulo END)) ncantidad_articulo 
    FROM facturacion.vw_solicitudcompra sc 
    LEFT JOIN facturacion.vw_recepcion r ON sc.nnro_solicitud = r.nnro_solicitud AND sc.cid_articulo = r.cid_articulo 
    INNER JOIN inventario.tarticulo a ON sc.cid_articulo = a.cid_articulo 
    WHERE sc.nnro_solicitud = '$nnro_solicitud' 
    GROUP BY sc.nnro_solicitud,sc.dfecha_documento,sc.nlinea,sc.cid_articulo,a.cdescripcion 
    HAVING (MAX(sc.ncantidad_articulo)-SUM(CASE WHEN r.ncantidad_articulo IS NULL THEN 0 ELSE r.ncantidad_articulo END)) <> 0 
    ORDER BY sc.nnro_solicitud,sc.nlinea ASC";
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

  public function BuscarDatosProveedor($proveedor){
    $sql="SELECT crif_persona,cnombre FROM general.tpersona WHERE crif_persona = '$proveedor'";
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