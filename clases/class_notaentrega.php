<?php
 require_once("class_bd.php");
 class NotaEntrega
 {
   private $nid_documentoventa; 
   private $nid_tipodocumento;
   private $nnro_cotizacion; 
   private $dfecha_documento;
   private $nnro_factura; 
   private $nnro_entrega; 
   private $dfecha_entrega;
   private $crif_persona;
   private $cnombre;
   private $nid_condicionpago;
   private $nlinea; 
   private $cid_articulo;
   private $ncantidad_articulo; 
   private $ncantidad_articulo_viejo; 
   private $estatus; 
   private $dfecha_desactivacion; 
   private $pgsql; 
	 
   public function __construct(){
     $this->nid_documentoventa=null;
     $this->nid_tipodocumento=null;
     $this->nnro_cotizacion=null;
     $this->dfecha_documento=null;
     $this->nnro_factura=null;
     $this->nnro_entrega=null;
     $this->dfecha_entrega=null;
     $this->crif_persona=null;
     $this->cnombre=null;
     $this->nid_condicionpago=null;
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

   public function nnro_factura(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nnro_factura;
     
   if($Num_Parametro>0){
     $this->nnro_factura=func_get_arg(0);
   }
   }

   public function nnro_entrega(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nnro_entrega;
     
   if($Num_Parametro>0){
     $this->nnro_entrega=func_get_arg(0);
   }
   }
   
   public function dfecha_entrega(){
   $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->dfecha_entrega;
     
   if($Num_Parametro>0){
     $this->dfecha_entrega=func_get_arg(0);
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
    $sql="SELECT MAX(CAST(nnro_entrega AS NUMERIC)) nnro_entrega FROM facturacion.tdocumentoventa WHERE nnro_entrega IS NOT NULL";
    $query=$this->pgsql->Ejecutar($sql);
    if($row=$this->pgsql->Respuesta($query)){
      $numero=$row['nnro_entrega'];
      while (strlen($numero)<10){
        $numero="0".$numero;
      }
      return $numero;
    }else{
      return 0;
    }
   }

   public function CrearMovimiento($user){
    $this->nnro_entrega($this->BuscarNuevoRegistro());
    $sql="SELECT nid_documentoventa,nid_tipodocumento,dfecha_entrega,'S' AS tipo 
    FROM facturacion.tdocumentoventa WHERE nnro_entrega = '$this->nnro_entrega'";
    $query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=null){
      $datos=$this->pgsql->Respuesta($query);
      if($this->GenerarMovimientoInventario($datos['nid_documentoventa'],$datos['nid_tipodocumento'],$datos['dfecha_entrega'],$datos['tipo'],$user)==true)
        return true;
      else
        return false;
    }
    else
      return false;
   }

   public function ModificarMovimiento($user){
    $logico=false;
    $sql="SELECT mi.nid_movinventario,r.cid_articulo,r.ncantidad_articulo ncantidad, dmi.nvalor_actual+(dmi.ncantidad+r.ncantidad_articulo) nvalor_actual 
    FROM facturacion.vw_entrega r 
    INNER JOIN inventario.tmovimiento_inventario mi ON r.nid_documentoventa = mi.nid_documentoventa 
    INNER JOIN inventario.tdetalle_movimiento_inventario dmi ON mi.nid_movinventario = dmi.nid_movinventario AND r.cid_articulo = dmi.cid_articulo 
    WHERE r.nnro_entrega = '$this->nnro_entrega' 
    ORDER BY r.nlinea ASC";
    $query=$this->pgsql->Ejecutar($sql);
    while($datos=$this->pgsql->Respuesta($query)){
      if($this->ModificarMovimientoInventario($datos['nid_movinventario'],$datos['cid_articulo'],$datos['ncantidad_articulo'],$user)==true)
        $logico=true;
      else
        $logico=false;
    }
    return $logico;
   }

  public function GenerarNroEntrega(){
    $sql="SELECT CASE WHEN MAX(CAST(nnro_entrega AS NUMERIC)) IS NULL THEN 1 ELSE MAX(CAST(nnro_entrega AS NUMERIC))+1 END nnro_entrega 
    FROM facturacion.tdocumentoventa WHERE nnro_entrega IS NOT NULL";
    $query=$this->pgsql->Ejecutar($sql);
    if($row=$this->pgsql->Respuesta($query)){
      $numero=$row['nnro_entrega'];
      while (strlen($numero)<10){
        $numero="0".$numero;
      }
      return $numero;
    }else{
      return 0;
    }
  }

   public function Registrar($user){
    $this->nnro_entrega($this->GenerarNroEntrega());
    $sql="INSERT INTO facturacion.tdocumentoventa (nnro_factura,nnro_entrega,dfecha_entrega,nid_tipodocumento,nnro_cotizacion,dfecha_documento,crif_persona,nid_condicionpago,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
    VALUES ('$this->nnro_factura','$this->nnro_entrega','$this->dfecha_entrega','$this->nid_tipodocumento','$this->nnro_cotizacion','$this->dfecha_documento','$this->crif_persona','$this->nid_condicionpago',NOW(),'$user',NOW(),'$user')";
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
    AND EXISTS (SELECT 1 FROM facturacion.tdevolucion dv WHERE dc.nid_documentoventa=dv.nid_documentoventa)";
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
    $sql="UPDATE facturacion.tdocumentoventa SET nnro_factura='$this->nnro_factura',nid_tipodocumento='$this->nid_tipodocumento',crif_persona='$this->crif_persona',
    nid_condicionpago='$this->nid_condicionpago',dfecha_documento='$this->dfecha_documento',dfecha_entrega='$this->dfecha_entrega',
    dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE nid_documentoventa='$this->nid_documentoventa'";
    if($this->pgsql->Ejecutar($sql)!=null)
  	 return true;
  	else
  	 return false;
   }
   
   public function Consultar(){
    $sql="SELECT DISTINCT r.nid_documentoventa,r.nid_tipodocumento,r.nnro_cotizacion,TO_CHAR(r.dfecha_documento,'DD/MM/YYYY') dfecha_documento,
    r.nnro_factura,r.nnro_entrega,TO_CHAR(r.dfecha_entrega,'DD/MM/YYYY') dfecha_entrega,r.crif_persona,p.cnombre,r.nid_condicionpago,
    r.dfecha_desactivacion,(CASE WHEN r.dfecha_desactivacion IS NULL THEN  'Activo' ELSE 'Desactivado' END) AS estatus 
    FROM facturacion.vw_entrega r 
    INNER JOIN general.tpersona p ON r.crif_persona = p.crif_persona 
    WHERE r.nnro_entrega='$this->nnro_entrega'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$entrega=$this->pgsql->Respuesta($query);
	$this->nid_documentoventa($entrega['nid_documentoventa']);
	$this->nid_tipodocumento($entrega['nid_tipodocumento']);
	$this->nnro_cotizacion($entrega['nnro_cotizacion']);
	$this->dfecha_documento($entrega['dfecha_documento']);
  $this->nnro_factura($entrega['nnro_factura']);
  $this->nnro_entrega($entrega['nnro_entrega']);
  $this->dfecha_entrega($entrega['dfecha_entrega']);
  $this->crif_persona($entrega['crif_persona']);
  $this->cnombre($entrega['cnombre']);
  $this->nid_condicionpago($entrega['nid_condicionpago']);
  $this->estatus($entrega['estatus']);
	$this->dfecha_desactivacion($entrega['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   public function Comprobar(){
    $sql="SELECT * FROM facturacion.vw_entrega WHERE nnro_entrega='$this->nnro_entrega'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$entrega=$this->pgsql->Respuesta($query);
  $this->nid_documentoventa($entrega['nid_documentoventa']);
  $this->nid_tipodocumento($entrega['nid_tipodocumento']);
  $this->nnro_cotizacion($entrega['nnro_cotizacion']);
  $this->dfecha_documento($entrega['dfecha_documento']);
  $this->nnro_factura($entrega['nnro_factura']);
  $this->nnro_entrega($entrega['nnro_entrega']);
  $this->dfecha_entrega($entrega['dfecha_entrega']);
  $this->crif_persona($entrega['crif_persona']);
  $this->nid_condicionpago($entrega['nid_condicionpago']);
  $this->dfecha_documento($entrega['dfecha_documento']);
  $this->dfecha_desactivacion($entrega['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   
  public function InsertarDetalle($user){
    $sql1="SELECT * FROM facturacion.tdetalle_documentoventa WHERE nlinea='$this->nlinea' AND cid_articulo='$this->cid_articulo' 
    AND nid_documentoventa = (SELECT nid_documentoventa FROM facturacion.tdocumentoventa WHERE nnro_entrega = '$this->nnro_entrega')";
    $query=$this->pgsql->Ejecutar($sql1);
    if($this->pgsql->Total_Filas($query)==0){
      $sql="INSERT INTO facturacion.tdetalle_documentoventa (nid_documentoventa,nlinea,cid_articulo,ncantidad_articulo,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
      VALUES ((SELECT nid_documentoventa FROM facturacion.tdocumentoventa WHERE nnro_entrega = '$this->nnro_entrega'),'$this->nlinea','$this->cid_articulo','$this->ncantidad_articulo',NOW(),'$user',NOW(),'$user')";
      if($this->pgsql->Ejecutar($sql)!=null)
        return true;
      else
        return false;
    }else{
      $sql="UPDATE facturacion.tdetalle_documentoventa SET nlinea='$this->nlinea',cid_articulo='$this->cid_articulo',
      ncantidad_articulo='$this->ncantidad_articulo',dmodificado_desde=NOW(), cmodificado_por='$user' 
      WHERE nid_documentoventa = (SELECT nid_documentoventa FROM facturacion.tdocumentoventa WHERE nnro_entrega = '$this->nnro_entrega') 
      AND nlinea = '$this->nlinea'";
      if($this->pgsql->Ejecutar($sql)!=null)
        return true;
      else
        return false;
    }
  }

  public function ActualizarDetalle($user){
    $sql="UPDATE facturacion.tdetalle_documentoventa SET nlinea='$this->nlinea',cid_articulo='$this->cid_articulo',
      ncantidad_articulo='$this->ncantidad_articulo',dmodificado_desde=NOW(), cmodificado_por='$user' 
      WHERE nid_documentoventa = (SELECT nid_documentoventa FROM facturacion.tdocumentoventa WHERE nnro_entrega = '$this->nnro_entrega') 
      AND nlinea = '$this->nlinea'";
      if($this->pgsql->Ejecutar($sql)!=null)
        return true;
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
      (SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tdetalle_movimiento_inventario' AND LOWER(cdescripcion) LIKE '%terminado%') ntipo_inventario,
      MAX(d.ncantidad_articulo) ncantidad, 
      LAST(CASE WHEN dmi.nvalor_actual IS NULL THEN 0 ELSE dmi.nvalor_actual END) nvalor_anterior,
      LAST(CASE WHEN dmi.nvalor_actual IS NULL THEN (0-d.ncantidad_articulo) ELSE (dmi.nvalor_actual-d.ncantidad_articulo) END) nvalor_actual 
      FROM facturacion.vw_entrega d 
      INNER JOIN inventario.tmovimiento_inventario mi ON d.nid_documentoventa = mi.nid_documento 
      LEFT JOIN inventario.tdetalle_movimiento_inventario dmi ON d.cid_articulo = dmi.cid_articulo  AND dmi.ntipo_inventario = (SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tdetalle_movimiento_inventario' AND LOWER(cdescripcion) LIKE '%terminado%')
      WHERE d.nid_documentoventa = '$documento' 
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

  public function BuscarDatosNroCotizacion($nnro_cotizacion){
    $sql="SELECT c.nnro_cotizacion,TO_CHAR(c.dfecha_documento,'DD/MM/YYYY') dfecha_documento,c.nlinea,c.cid_articulo,
    a.cdescripcion articulo,c.crif_persona,p.cnombre,c.nid_condicionpago,
    (MAX(c.ncantidad_articulo)-SUM(CASE WHEN e.ncantidad_articulo IS NULL THEN 0 ELSE e.ncantidad_articulo END)) ncantidad_articulo, 
    MAX(ip.existencia) existencia 
    FROM facturacion.vw_cotizacion c 
    INNER JOIN general.tpersona p ON c.crif_persona = p.crif_persona 
    LEFT JOIN facturacion.vw_entrega e ON c.nnro_cotizacion = e.nnro_cotizacion AND c.cid_articulo = e.cid_articulo 
    INNER JOIN inventario.tarticulo a ON c.cid_articulo = a.cid_articulo 
    LEFT JOIN inventario.vw_inventario_productos ip ON c.cid_articulo = ip.cid_articulo AND ip.nid_estatus_inventario = (SELECT nid_combovalor FROM general.tcombo_valor WHERE LOWER(cdescripcion) LIKE '%terminado%')
    WHERE c.nnro_cotizacion = '$nnro_cotizacion' 
    GROUP BY c.nnro_cotizacion,c.dfecha_documento,c.nlinea,c.cid_articulo,a.cdescripcion,c.crif_persona,p.cnombre,c.nid_condicionpago 
    HAVING (MAX(c.ncantidad_articulo)-SUM(CASE WHEN e.ncantidad_articulo IS NULL THEN 0 ELSE e.ncantidad_articulo END)) <> 0 
    ORDER BY c.nnro_cotizacion,c.nlinea ASC";
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