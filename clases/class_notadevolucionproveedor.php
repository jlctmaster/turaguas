<?php
 require_once("class_bd.php");
 class Notadevolucionproveedor
 {
   private $nid_tipodocumento;
   private $nid_devolucion;
   private $nnro_devolucion; 
   private $dfecha_devolucion;
   private $nid_documentocompra; 
   private $nnro_recepcion; 
   private $dfecha_documento;
   private $nlinea; 
   private $cid_articulo;
   private $ncantidad_articulo; 
   private $ncantidad_articulo_viejo; 
   private $nid_motivodevolucion; 
   private $estatus; 
   private $dfecha_desactivacion; 
   private $pgsql; 
	 
   public function __construct(){
     $this->nid_tipodocumento=null;
     $this->nid_devolucion=null;
     $this->nnro_devolucion=null;
     $this->dfecha_devolucion=null;
     $this->nid_documentocompra=null;
     $this->nnro_recepcion=null;
     $this->dfecha_documento=null;
     $this->nlinea=null;
     $this->cid_articulo=null;
     $this->ncantidad_articulo=null;
     $this->ncantidad_articulo_viejo=null;
     $this->nid_motivodevolucion=null;
  	 $this->pgsql=new Conexion();
   }
   
 public function __destruct(){}

  public function Transaccion($value){
    if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
    if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
    if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();

  }
   
   public function nid_tipodocumento(){
   $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nid_tipodocumento;
     
   if($Num_Parametro>0){
     $this->nid_tipodocumento=func_get_arg(0);
   }
   }
   
   public function nid_devolucion(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_devolucion;
     
	 if($Num_Parametro>0){
	   $this->nid_devolucion=func_get_arg(0);
	 }
   }

   public function nnro_devolucion(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nnro_devolucion;
     
   if($Num_Parametro>0){
     $this->nnro_devolucion=func_get_arg(0);
   }
   }
   
   public function dfecha_devolucion(){
   $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->dfecha_devolucion;
     
   if($Num_Parametro>0){
     $this->dfecha_devolucion=func_get_arg(0);
   }
   }

  public function nid_documentocompra(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nid_documentocompra;
     
   if($Num_Parametro>0){
     $this->nid_documentocompra=func_get_arg(0);
   }
   }

   public function nnro_recepcion(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nnro_recepcion;
     
	 if($Num_Parametro>0){
	   $this->nnro_recepcion=func_get_arg(0);
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

   public function nid_motivodevolucion(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nid_motivodevolucion;
     
   if($Num_Parametro>0){
     $this->nid_motivodevolucion=func_get_arg(0);
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

  public function GenerarNrodevolucion(){
    $sql="SELECT CASE WHEN MAX(CAST(nnro_devolucion AS NUMERIC)) IS NULL THEN 1 ELSE MAX(CAST(nnro_devolucion AS NUMERIC))+1 END nnro_devolucion 
    FROM facturacion.tdevolucion WHERE nid_documentocompra IS NOT NULL";
    $query=$this->pgsql->Ejecutar($sql);
    if($row=$this->pgsql->Respuesta($query)){
      $numero=$row['nnro_devolucion'];
      while (strlen($numero)<10){
        $numero="0".$numero;
      }
      return $numero;
    }else{
      return 0;
    }
  }

   public function BuscarNuevoRegistro(){
    $sql="SELECT MAX(CAST(nnro_devolucion AS NUMERIC)) nnro_devolucion FROM facturacion.tdevolucion WHERE nid_documentocompra IS NOT NULL";
    $query=$this->pgsql->Ejecutar($sql);
    if($row=$this->pgsql->Respuesta($query)){
      $numero=$row['nnro_devolucion'];
      while (strlen($numero)<10){
        $numero="0".$numero;
      }
      return $numero;
    }else{
      return 0;
    }
   }

   public function CrearMovimiento($user){ 
    $this->nnro_devolucion($this->BuscarNuevoRegistro());
    $sql="SELECT nid_devolucion,nid_tipodocumento,TO_CHAR(dfecha_devolucion,'DD/MM/YYYY') dfecha_devolucion,'S' AS tipo 
    FROM facturacion.tdevolucion WHERE nnro_devolucion = '$this->nnro_devolucion' AND nid_documentocompra IS NOT NULL";
    $query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=null){
      $datos=$this->pgsql->Respuesta($query);
      if($this->GenerarMovimientoInventario($datos['nid_devolucion'],$datos['nid_tipodocumento'],$datos['dfecha_devolucion'],$datos['tipo'],$user)==true)
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
    FROM facturacion.vw_devolucion_proveedor r 
    INNER JOIN inventario.tmovimiento_inventario mi ON r.nid_documentocompra = mi.nid_documento 
    INNER JOIN inventario.tdetalle_movimiento_inventario dmi ON mi.nid_movinventario = dmi.nid_movinventario AND r.cid_articulo = dmi.cid_articulo 
    WHERE r.nnro_devolucion = '$this->nnro_devolucion' 
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

   public function Registrar($user){
    $this->nnro_devolucion($this->GenerarNrodevolucion());
    $sql="INSERT INTO facturacion.tdevolucion (nid_tipodocumento,nnro_devolucion,dfecha_devolucion,nid_documentocompra,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
    VALUES ('$this->nid_tipodocumento','$this->nnro_devolucion','$this->dfecha_devolucion','$this->nid_documentocompra',NOW(),'$user',NOW(),'$user')";
    if($this->pgsql->Ejecutar($sql)!=null)
    	return true;
		else
			return false;
   }
   
    public function Activar($user){
    $sql="UPDATE facturacion.tdevolucion SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),cmodificado_por='$user' WHERE nid_devolucion = '$this->nid_devolucion'";
      if($this->pgsql->Ejecutar($sql)!=null)
  	return true;
  	else
  	return false;
   }

    public function Desactivar($user){
    $sqlx="SELECT * FROM facturacion.tdevolucion dp WHERE dp.nid_devolucion = '$this->nid_devolucion'
    AND EXISTS (SELECT 1 FROM inventario.tmovimiento_inventario mi WHERE dp.nid_devolucion = mi.nid_documento)";
    $sql="UPDATE facturacion.tdevolucion SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),cmodificado_por='$user' WHERE nid_devolucion = '$this->nid_devolucion'";
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
    $sql="UPDATE facturacion.tdevolucion SET nid_tipodocumento='$this->nid_tipodocumento',dfecha_devolucion='$this->dfecha_devolucion',dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE nid_devolucion='$this->nid_devolucion'";
    if($this->pgsql->Ejecutar($sql)!=null)
  	 return true;
  	else
  	 return false;
   }
   
   public function Consultar(){
    $sql="SELECT DISTINCT dp.nid_documentocompra,TRIM(r.nnro_recepcion) nnro_recepcion,TO_CHAR(r.dfecha_documento,'DD/MM/YYYY') dfecha_documento,
    dp.nid_devolucion,dp.nid_tipodocumento,dp.nnro_devolucion,TO_CHAR(dp.dfecha_devolucion,'DD/MM/YYYY') dfecha_devolucion,
    dp.dfecha_desactivacion,(CASE WHEN dp.dfecha_desactivacion IS NULL THEN  'Activo' ELSE 'Desactivado' END) AS estatus 
    FROM facturacion.vw_devolucion_proveedor dp 
    INNER JOIN facturacion.vw_recepcion r ON dp.nid_documentocompra = r.nid_documentocompra 
    WHERE dp.nnro_devolucion='$this->nnro_devolucion'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$devolucion=$this->pgsql->Respuesta($query);
  $this->nid_tipodocumento($devolucion['nid_tipodocumento']);
  $this->nid_devolucion($devolucion['nid_devolucion']);
  $this->nnro_devolucion($devolucion['nnro_devolucion']);
  $this->dfecha_devolucion($devolucion['dfecha_devolucion']);
	$this->nid_documentocompra($devolucion['nid_documentocompra']);
	$this->nnro_recepcion($devolucion['nnro_recepcion']);
	$this->dfecha_documento($devolucion['dfecha_documento']);
  $this->estatus($devolucion['estatus']);
	$this->dfecha_desactivacion($devolucion['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   public function Comprobar(){
    $sql="SELECT * FROM facturacion.vw_devolucion_proveedor WHERE nnro_devolucion='$this->nnro_devolucion'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$devolucion=$this->pgsql->Respuesta($query);
  $this->nid_tipodocumento($devolucion['nid_tipodocumento']);
  $this->nid_devolucion($devolucion['nid_devolucion']);
  $this->nnro_devolucion($devolucion['nnro_devolucion']);
  $this->dfecha_devolucion($devolucion['dfecha_devolucion']);
  $this->nid_documentocompra($devolucion['nid_documentocompra']);
  $this->dfecha_desactivacion($devolucion['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   
  public function InsertarDetalle($user){
    $sql="INSERT INTO facturacion.tdetalle_devolucion (nid_devolucion,nlinea,cid_articulo,ncantidad_articulo,nid_motivodevolucion,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
    VALUES ((SELECT nid_devolucion FROM facturacion.tdevolucion WHERE nnro_devolucion = '$this->nnro_devolucion' AND nid_documentocompra IS NOT NULL),'$this->nlinea','$this->cid_articulo','$this->ncantidad_articulo','$this->nid_motivodevolucion',NOW(),'$user',NOW(),'$user')";
    if($this->pgsql->Ejecutar($sql)!=null)
      return true;
    else
      return false;
  }

  public function ActualizarDetalle($user){
    $sql="UPDATE facturacion.tdetalle_devolucion SET cid_articulo='$this->cid_articulo',ncantidad_articulo='$this->ncantidad_articulo',
      nid_motivodevolucion='$this->nid_motivodevolucion',dmodificado_desde=NOW(), cmodificado_por='$user' 
      WHERE nid_devolucion = (SELECT nid_devolucion FROM facturacion.tdevolucion WHERE nnro_devolucion = '$this->nnro_devolucion' AND nid_documentocompra IS NOT NULL) 
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
      $sqlx="SELECT mi.nid_movinventario,dp.cid_articulo,
      (SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tdetalle_movimiento_inventario' AND LOWER(cdescripcion) LIKE '%materia prima%') ntipo_inventario, 
      MAX(dp.ncantidad_articulo) ncantidad, 
      LAST(CASE WHEN dmi.nvalor_actual IS NULL THEN 0 ELSE dmi.nvalor_actual END) nvalor_anterior,
      LAST(CASE WHEN dmi.nvalor_actual IS NULL THEN (0-dp.ncantidad_articulo) ELSE (dmi.nvalor_actual-dp.ncantidad_articulo) END) nvalor_actual       
      FROM facturacion.vw_devolucion_proveedor dp
      INNER JOIN inventario.tmovimiento_inventario mi ON dp.nid_devolucion = mi.nid_documento 
      LEFT JOIN inventario.tdetalle_movimiento_inventario dmi ON dp.cid_articulo = dmi.cid_articulo AND dmi.ntipo_inventario = (SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tdetalle_movimiento_inventario' AND LOWER(cdescripcion) LIKE '%materia prima%')
      WHERE dp.nid_devolucion = '$documento' 
      GROUP BY dp.nlinea,1,2,3 
      ORDER BY dp.nlinea ASC";
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

  public function BuscarDatosNroRecepcion($nnro_recepcion){
    $sql="SELECT r.nid_documentocompra,r.nnro_recepcion,TO_CHAR(r.dfecha_documento,'DD/MM/YYYY') dfecha_documento,r.cid_articulo,a.cdescripcion articulo,r.nlinea,
    (MAX(r.ncantidad_articulo)-SUM(CASE WHEN dp.ncantidad_articulo IS NULL THEN 0 ELSE dp.ncantidad_articulo END)) ncantidad_articulo
    FROM facturacion.vw_recepcion r 
    LEFT JOIN facturacion.vw_devolucion_proveedor dp ON r.nid_documentocompra = dp.nid_documentocompra AND r.cid_articulo = dp.cid_articulo 
    INNER JOIN inventario.tarticulo a ON r.cid_articulo = a.cid_articulo 
    WHERE r.nnro_recepcion = '$nnro_recepcion' 
    GROUP BY r.nid_documentocompra,r.nnro_recepcion,r.dfecha_documento,r.nlinea,r.cid_articulo,a.cdescripcion,r.nlinea
    HAVING (MAX(r.ncantidad_articulo)-SUM(CASE WHEN dp.ncantidad_articulo IS NULL THEN 0 ELSE dp.ncantidad_articulo END)) <> 0 
    ORDER BY r.nnro_recepcion ASC";
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