<?php
 require_once("class_bd.php");
 class Produccion
 {
   private $nid_produccion; 
   private $nid_tipodocumento;
   private $nnro_produccion; 
   private $dfecha_documento;
   private $cid_articulo;
   private $ncantidad; 
   private $nlinea;
   private $cid_insumo;
   private $ncantidad_a_usar; 
   private $ntotal_a_usar; 
   private $estatus; 
   private $dfecha_desactivacion; 
   private $pgsql; 
	 
   public function __construct(){
     $this->nid_produccion=null;
     $this->nid_tipodocumento=null;
     $this->nnro_produccion=null;
     $this->dfecha_documento=null;
     $this->cid_articulo=null;
     $this->ncantidad=null;
     $this->nlinea=null;
     $this->cid_insumo=null;
     $this->ncantidad_a_usar=null;
     $this->ntotal_a_usar=null;
  	 $this->pgsql=new Conexion();
   }
   
 public function __destruct(){}

  public function Transaccion($value){
    if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
    if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
    if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();

  }
  public function nid_produccion(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_produccion;
     
	 if($Num_Parametro>0){
	   $this->nid_produccion=func_get_arg(0);
	 }
   }
   
   public function nid_tipodocumento(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_tipodocumento;
     
	 if($Num_Parametro>0){
	   $this->nid_tipodocumento=func_get_arg(0);
	 }
   }

   public function nnro_produccion(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nnro_produccion;
     
	 if($Num_Parametro>0){
	   $this->nnro_produccion=func_get_arg(0);
	 }
   }
   
   public function dfecha_documento(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->dfecha_documento;
     
	 if($Num_Parametro>0){
	   $this->dfecha_documento=func_get_arg(0);
	 }
   }

   public function cid_articulo(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->cid_articulo;
     
   if($Num_Parametro>0){
     $this->cid_articulo=func_get_arg(0);
   }
   }

   public function ncantidad(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->ncantidad;
     
	 if($Num_Parametro>0){
	   $this->ncantidad=func_get_arg(0);
	 }
   }

   public function nlinea(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nlinea;
     
   if($Num_Parametro>0){
     $this->nlinea=func_get_arg(0);
   }
   }

   public function cid_insumo(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->cid_insumo;
     
   if($Num_Parametro>0){
     $this->cid_insumo=func_get_arg(0);
   }
   }

   public function ncantidad_a_usar(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->ncantidad_a_usar;
     
   if($Num_Parametro>0){
     $this->ncantidad_a_usar=func_get_arg(0);
   }
   }

   public function ntotal_a_usar(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->ntotal_a_usar;
     
   if($Num_Parametro>0){
     $this->ntotal_a_usar=func_get_arg(0);
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
    $sql="SELECT MAX(CAST(nnro_produccion AS NUMERIC)) nnro_produccion FROM inventario.tproduccion";
    $query=$this->pgsql->Ejecutar($sql);
    if($row=$this->pgsql->Respuesta($query)){
      $numero=$row['nnro_produccion'];
      while (strlen($numero)<10){
        $numero="0".$numero;
      }
      return $numero;
    }else{
      return 0;
    }
   }

  public function GenerarNroProduccion(){
    $sql="SELECT CASE WHEN MAX(CAST(nnro_produccion AS NUMERIC)) IS NULL THEN 1 ELSE MAX(CAST(nnro_produccion AS NUMERIC))+1 END nnro_produccion 
    FROM inventario.tproduccion";
    $query=$this->pgsql->Ejecutar($sql);
    if($row=$this->pgsql->Respuesta($query)){
      $numero=$row['nnro_produccion'];
      while (strlen($numero)<10){
        $numero="0".$numero;
      }
      return $numero;
    }else{
      return 0;
    }
  }

   public function Registrar($user){
    $this->nnro_produccion($this->GenerarNroProduccion());
    $sql="INSERT INTO inventario.tproduccion (nnro_produccion,nid_tipodocumento,dfecha_documento,cid_articulo,ncantidad,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
    VALUES ('$this->nnro_produccion','$this->nid_tipodocumento','$this->dfecha_documento','$this->cid_articulo',$this->ncantidad,NOW(),'$user',NOW(),'$user')";
    if($this->pgsql->Ejecutar($sql)!=null)
    	return true;
		else
			return false;
   }
   
    public function Activar($user){
    $sql="UPDATE inventario.tproduccion SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),cmodificado_por='$user' WHERE nid_produccion = '$this->nid_produccion'";
      if($this->pgsql->Ejecutar($sql)!=null)
  	return true;
  	else
  	return false;
   }

    public function Desactivar($user){
    $sqlx="SELECT * FROM inventario.tproduccion p WHERE p.nid_produccion = '$this->nid_produccion'
    AND EXISTS (SELECT 1 FROM inventario.tmovimiento_inventario mi WHERE mi.nid_documento = p.nid_produccion AND mi.nid_tipodocumento = p.nid_tipodocumento)";
    $sql="UPDATE inventario.tproduccion SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),cmodificado_por='$user' WHERE nid_produccion = '$this->nid_produccion'";
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
    $sql="UPDATE inventario.tproduccion SET dfecha_documento='$this->dfecha_documento',cid_articulo='$this->cid_articulo',
    ncantidad='$this->ncantidad',dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE nnro_produccion='$this->nnro_produccion'";
    if($this->pgsql->Ejecutar($sql)!=null)
  	 return true;
  	else
  	 return false;
   }
   
  public function Consultar(){
    $sql="SELECT DISTINCT nid_produccion,nid_tipodocumento,nnro_produccion,TO_CHAR(dfecha_documento,'DD/MM/YYYY') dfecha_documento,
    TRIM(productoterminado) AS productoterminado,cantidad_a_producir,dfecha_desactivacion,(CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' ELSE 'Desactivado' END) AS estatus 
    FROM inventario.vw_produccion WHERE nnro_produccion='$this->nnro_produccion'";
    $query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
      $produccion=$this->pgsql->Respuesta($query);
      $this->nid_produccion($produccion['nid_produccion']);
      $this->nid_tipodocumento($produccion['nid_tipodocumento']);
      $this->nnro_produccion($produccion['nnro_produccion']);
      $this->dfecha_documento($produccion['dfecha_documento']);
      $this->cid_articulo($produccion['productoterminado']);
      $this->ncantidad($produccion['cantidad_a_producir']);
      $this->estatus($produccion['estatus']);
      $this->dfecha_desactivacion($produccion['dfecha_desactivacion']);
      return true;
    }
    else{
      return false;
    }
  }

   public function Comprobar(){
    $sql="SELECT * FROM inventario.vw_produccion WHERE nnro_produccion='$this->nnro_produccion'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$produccion=$this->pgsql->Respuesta($query);
  $this->nnro_produccion($produccion['produccion']);
  $this->nid_tipodocumento($produccion['nid_tipodocumento']);
  $this->nnro_produccion($produccion['nnro_produccion']);
  $this->cid_articulo($produccion['cid_articulo']);
  $this->ncantidad($produccion['ncantidad']);
  $this->dfecha_documento($produccion['dfecha_documento']);
  $this->dfecha_desactivacion($produccion['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   
  public function InsertarDetalle($user){
    $sql="INSERT INTO inventario.tdetalle_produccion (nlinea,nid_produccion,cid_insumo,ncantidad,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
    VALUES ('$this->nlinea',(SELECT nid_produccion FROM inventario.tproduccion WHERE nnro_produccion = '$this->nnro_produccion'),'$this->cid_insumo','$this->ntotal_a_usar',NOW(),'$user',NOW(),'$user')";
    if($this->pgsql->Ejecutar($sql)!=null)
      return true;
    else
      return false;
  }

  public function ActualizarDetalle($user){
    $sql="UPDATE inventario.tdetalle_produccion SET cid_insumo='$this->cid_insumo',
      ncantidad='$this->ntotal_a_usar',dmodificado_desde=NOW(), cmodificado_por='$user' 
      WHERE nlinea = '$this->nlinea' AND nid_produccion = '$this->nid_produccion'";
      if($this->pgsql->Ejecutar($sql)!=null)
        return true;
      else
        return false;
  }

   public function CrearSalida($user){
    $this->nnro_produccion($this->BuscarNuevoRegistro());
    $sql="SELECT nid_produccion,nid_tipodocumento,dfecha_documento,'S' AS tipo 
    FROM inventario.tproduccion WHERE nnro_produccion = '$this->nnro_produccion'";
    $query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=null){
      $datos=$this->pgsql->Respuesta($query);
      if($this->GenerarSalidaInventario($datos['nid_produccion'],$datos['nid_tipodocumento'],$datos['dfecha_documento'],$datos['tipo'],$user)==true)
        return true;
      else
        return false;
    }
    else
      return false;
   }

   public function CrearEntrada($user){
    $this->nnro_produccion($this->BuscarNuevoRegistro());
    $sql="SELECT nid_produccion,nid_tipodocumento,dfecha_documento,'E' AS tipo 
    FROM inventario.tproduccion WHERE nnro_produccion = '$this->nnro_produccion'";
    $query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=null){
      $datos=$this->pgsql->Respuesta($query);
      if($this->GenerarEntradaInventario($datos['nid_produccion'],$datos['nid_tipodocumento'],$datos['dfecha_documento'],$datos['tipo'],$user)==true)
        return true;
      else
        return false;
    }
    else
      return false;
   }

   public function ModificarSalida($user){
    $logico=false;
    $sql="SELECT mi.nid_movinventario,p.materiaprima cid_articulo,p.cantidad_usada ncantidad, dmi.nvalor_actual+(dmi.ncantidad-p.cantidad_usada) nvalor_actual 
    FROM inventario.vw_produccion p 
    INNER JOIN inventario.tmovimiento_inventario mi ON p.nid_produccion = mi.nid_documento 
    INNER JOIN inventario.tdetalle_movimiento_inventario dmi ON mi.nid_movinventario = dmi.nid_movinventario AND p.materiaprima = dmi.cid_articulo 
    WHERE p.nnro_produccion = '$this->nnro_produccion' 
    ORDER BY p.nlinea ASC";
    $query=$this->pgsql->Ejecutar($sql);
    while($datos=$this->pgsql->Respuesta($query)){
      if($this->ModificarMovimientoInventario($datos['nid_movinventario'],$datos['cid_articulo'],$datos['ncantidad'],$datos['nvalor_actual'],$user)==true)
        $logico=true;
      else
        $logico=false;
    }
    return $logico;
   }

   public function ModificarEntrada($user){
    $logico=false;
    $sql="SELECT DISTINCT mi.nid_movinventario,p.productoterminado cid_articulo,p.cantidad_a_producir ncantidad, dmi.nvalor_actual-(dmi.ncantidad-p.cantidad_a_producir) nvalor_actual 
    FROM inventario.vw_produccion p 
    INNER JOIN inventario.tmovimiento_inventario mi ON p.nid_produccion = mi.nid_documento 
    INNER JOIN inventario.tdetalle_movimiento_inventario dmi ON mi.nid_movinventario = dmi.nid_movinventario AND p.productoterminado = dmi.cid_articulo 
    WHERE p.nnro_produccion = '$this->nnro_produccion'";
    $query=$this->pgsql->Ejecutar($sql);
    while($datos=$this->pgsql->Respuesta($query)){
      if($this->ModificarMovimientoInventario($datos['nid_movinventario'],$datos['cid_articulo'],$datos['ncantidad'],$datos['nvalor_actual'],$user)==true)
        $logico=true;
      else
        $logico=false;
    }
    return $logico;
   }

  public function ModificarMovimientoInventario($movimiento,$articulo,$cantidad,$valor_actual,$user){
    $sql="UPDATE inventario.tdetalle_movimiento_inventario SET ncantidad=$cantidad,nvalor_actual=$valor_actual,dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE nid_movinventario = $movimiento AND cid_articulo = '$articulo'";
    if($this->pgsql->Ejecutar($sql)!=null)
      return true;
    else
      return false;
  }

  public function GenerarSalidaInventario($documento,$tipodocumento,$fecha,$tipo,$user){
    $sql="INSERT INTO inventario.tmovimiento_inventario (nid_documento,nid_tipodocumento,dfecha_movinventario,ctipo_movinventario,
    dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES ('$documento','$tipodocumento','$fecha','$tipo',NOW(),'$user',NOW(),'$user')";
    if($this->pgsql->Ejecutar($sql)!=null){
      $sqlx="SELECT mi.nid_movinventario,dp.cid_insumo,
      (SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tdetalle_movimiento_inventario' AND LOWER(cdescripcion) LIKE '%materia prima%') ntipo_inventario, 
      MAX(dp.ncantidad) ncantidad, 
      LAST(CASE WHEN dmi.nvalor_actual IS NULL THEN 0 ELSE dmi.nvalor_actual END) nvalor_anterior,
      LAST(CASE WHEN dmi.nvalor_actual IS NULL THEN (0-dp.ncantidad) ELSE (dmi.nvalor_actual-dp.ncantidad) END) nvalor_actual 
      FROM inventario.tproduccion p 
      INNER JOIN inventario.tdetalle_produccion dp ON p.nid_produccion = dp.nid_produccion 
      INNER JOIN inventario.tmovimiento_inventario mi ON p.nid_produccion = mi.nid_documento AND mi.ctipo_movinventario = 'S' 
      LEFT JOIN inventario.tdetalle_movimiento_inventario dmi ON dp.cid_insumo = dmi.cid_articulo 
      WHERE p.nid_produccion = '$documento'
      GROUP BY dp.nlinea,1,2,3 
      ORDER BY dp.nlinea,1,2,3 ASC";
      $query = $this->pgsql->Ejecutar($sqlx);
      while($rows=$this->pgsql->Respuesta($query)){
        $sql1 = "INSERT INTO inventario.tdetalle_movimiento_inventario (nid_movinventario,cid_articulo,ncantidad,nvalor_anterior,nvalor_actual,ntipo_inventario,
        dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES (".$rows['nid_movinventario'].",'".$rows['cid_insumo']."',
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

  public function GenerarEntradaInventario($documento,$tipodocumento,$fecha,$tipo,$user){
    $sql="INSERT INTO inventario.tmovimiento_inventario (nid_documento,nid_tipodocumento,dfecha_movinventario,ctipo_movinventario,
    dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES ('$documento','$tipodocumento','$fecha','$tipo',NOW(),'$user',NOW(),'$user')";
    if($this->pgsql->Ejecutar($sql)!=null){
      $sqlx="SELECT MAX(mi.nid_movinventario) AS nid_movinventario,p.cid_articulo,
      (SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tdetalle_movimiento_inventario' AND LOWER(cdescripcion) LIKE '%productos terminados%') ntipo_inventario, 
      MAX(p.ncantidad) ncantidad, 
      LAST(CASE WHEN dmi.nvalor_actual IS NULL THEN 0 ELSE dmi.nvalor_actual END) nvalor_anterior,
      LAST(CASE WHEN dmi.nvalor_actual IS NULL THEN (p.ncantidad+0) ELSE (p.ncantidad+dmi.nvalor_actual) END) nvalor_actual 
      FROM inventario.tproduccion p 
      INNER JOIN inventario.tmovimiento_inventario mi ON p.nid_produccion = mi.nid_documento AND mi.ctipo_movinventario = 'E' 
      LEFT JOIN inventario.tdetalle_movimiento_inventario dmi ON p.cid_articulo = dmi.cid_articulo 
      WHERE p.nid_produccion = '$documento' 
      GROUP BY 2,3";
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

  public function BuscarConfiguracion($productoterminado){
    $sql="SELECT productoterminado,cantidad_disponible,cantidad_disponible AS cant_disp_a_usar,ca.cid_insumo,ROUND((cantidad_disponible*ca.ncantidad),2) cant_a_usar,
    um.csimbolo,ROUND(((cantidad_disponible*ca.ncantidad)*umc.nfactor_divisor),2) total_a_usar,
    CASE WHEN ((cantidad_disponible*ca.ncantidad)*umc.nfactor_divisor) > 1 THEN p.cdescripcion||'S' ELSE p.cdescripcion END presentacion,
    a.cdescripcion articulo  
    FROM inventario.vw_produccion_disponible pd 
    LEFT JOIN inventario.tconfiguracion_articulo ca ON pd.productoterminado = ca.cid_servicio 
    INNER JOIN inventario.tarticulo a ON ca.cid_insumo = a.cid_articulo 
    INNER JOIN inventario.tum_conversion umc ON a.cid_articulo = umc.cid_articulo 
    INNER JOIN inventario.tpresentacion p ON a.nid_presentacion = p.nid_presentacion AND p.nid_unidadmedida = umc.nid_um_hasta 
    INNER JOIN inventario.tunidad_medida um ON p.nid_unidadmedida = um.nid_unidadmedida 
    WHERE productoterminado = '$productoterminado' 
    ORDER BY insumobase ASC ";
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

  public function BuscarConfiguracionPorDisponibilidad($productoterminado,$cantidad){
    $sql="SELECT productoterminado,cantidad_disponible,$cantidad as cant_disp_a_usar,ca.cid_insumo,ROUND(($cantidad*ca.ncantidad),2) cant_a_usar,
    um.csimbolo,ROUND((($cantidad*ca.ncantidad)*umc.nfactor_divisor),2) total_a_usar,
    CASE WHEN (($cantidad*ca.ncantidad)*umc.nfactor_divisor) > 1 THEN p.cdescripcion||'S' ELSE p.cdescripcion END presentacion,
    a.cdescripcion articulo 
    FROM inventario.vw_produccion_disponible pd 
    LEFT JOIN inventario.tconfiguracion_articulo ca ON pd.productoterminado = ca.cid_servicio 
    INNER JOIN inventario.tarticulo a ON ca.cid_insumo = a.cid_articulo 
    INNER JOIN inventario.tum_conversion umc ON a.cid_articulo = umc.cid_articulo 
    INNER JOIN inventario.tpresentacion p ON a.nid_presentacion = p.nid_presentacion AND p.nid_unidadmedida = umc.nid_um_hasta 
    INNER JOIN inventario.tunidad_medida um ON p.nid_unidadmedida = um.nid_unidadmedida 
    WHERE productoterminado = '$productoterminado' 
    ORDER BY insumobase ASC ";
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