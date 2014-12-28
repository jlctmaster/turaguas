<?php
 require_once("class_bd.php");
 class ReembolsoCliente
 {
   private $nid_reembolso; 
   private $nid_tipodocumento;
   private $nnro_reembolso; 
   private $dfecha_documento;
   private $nid_devolucion; 
   private $nnro_devolucion; 
   private $dfecha_devolucion;
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
     $this->nid_reembolso=null;
     $this->nid_tipodocumento=null;
     $this->nnro_reembolso=null;
     $this->dfecha_documento=null;
     $this->nid_devolucion=null;
     $this->nnro_devolucion=null;
     $this->dfecha_documento=null;
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
  public function nid_reembolso(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nid_reembolso;
     
   if($Num_Parametro>0){
     $this->nid_reembolso=func_get_arg(0);
   }
   }
  public function nid_devolucion(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nid_devolucion;
     
   if($Num_Parametro>0){
     $this->nid_devolucion=func_get_arg(0);
   }
   }
   
   public function nid_tipodocumento(){
   $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nid_tipodocumento;
     
   if($Num_Parametro>0){
     $this->nid_tipodocumento=func_get_arg(0);
   }
   }

   public function nnro_devolucion(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nnro_devolucion;
     
   if($Num_Parametro>0){
     $this->nnro_devolucion=func_get_arg(0);
   }
   }
   
   public function dfecha_documento(){
   $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->dfecha_documento;
     
   if($Num_Parametro>0){
     $this->dfecha_documento=func_get_arg(0);
   }
   }

   public function nnro_reembolso(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->nnro_reembolso;
     
   if($Num_Parametro>0){
     $this->nnro_reembolso=func_get_arg(0);
   }
   }
   
   public function dfecha_devolucion(){
   $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->dfecha_devolucion;
     
   if($Num_Parametro>0){
     $this->dfecha_devolucion=func_get_arg(0);
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

  public function GenerarNroReembolso(){
    $sql="SELECT CASE WHEN MAX(CAST(nnro_reembolso AS NUMERIC)) IS NULL THEN 1 ELSE MAX(CAST(nnro_reembolso AS NUMERIC))+1 END nnro_reembolso 
    FROM facturacion.treembolso WHERE ctipo_transaccion = 'V'";
    $query=$this->pgsql->Ejecutar($sql);
    if($row=$this->pgsql->Respuesta($query)){
      $numero=$row['nnro_reembolso'];
      while (strlen($numero)<10){
        $numero="0".$numero;
      }
      return $numero;
    }else{
      return 0;
    }
  }

   public function BuscarNuevoRegistro(){
    $sql="SELECT MAX(CAST(nnro_reembolso AS NUMERIC)) nnro_reembolso 
    FROM facturacion.treembolso WHERE ctipo_transaccion = 'V'";
    $query=$this->pgsql->Ejecutar($sql);
    if($row=$this->pgsql->Respuesta($query)){
      $numero=$row['nnro_reembolso'];
      while (strlen($numero)<10){
        $numero="0".$numero;
      }
      return $numero;
    }else{
      return 0;
    }
   }

   public function CrearMovimiento($user){
    $this->nnro_reembolso($this->BuscarNuevoRegistro());
    $sql="SELECT nid_reembolso,nid_tipodocumento,dfecha_documento,'S' AS tipo 
    FROM facturacion.treembolso WHERE nnro_reembolso = '$this->nnro_reembolso' AND ctipo_transaccion = 'V'";
    $query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=null){
      $datos=$this->pgsql->Respuesta($query);
      if($this->GenerarMovimientoInventario($datos['nid_reembolso'],$datos['nid_tipodocumento'],$datos['dfecha_documento'],$datos['tipo'],$user)==true)
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
    FROM facturacion.vw_reembolso_cliente r 
    INNER JOIN inventario.tmovimiento_inventario mi ON r.nid_reembolso = mi.nid_documento 
    INNER JOIN inventario.tdetalle_movimiento_inventario dmi ON mi.nid_movinventario = dmi.nid_movinventario AND r.cid_articulo = dmi.cid_articulo 
    WHERE r.nnro_reembolso = '$this->nnro_reembolso' 
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
    $this->nnro_reembolso($this->GenerarNroReembolso());
    $sql="INSERT INTO facturacion.treembolso (ctipo_transaccion,nnro_reembolso,dfecha_documento,nid_tipodocumento,nid_devolucion,crif_persona,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
    VALUES ('V','$this->nnro_reembolso','$this->dfecha_documento','$this->nid_tipodocumento','$this->nid_devolucion','$this->crif_persona',NOW(),'$user',NOW(),'$user')";
    echo $sql;
    if($this->pgsql->Ejecutar($sql)!=null)
      return true;
    else
      return false;
   }
   
    public function Activar($user){
    $sql="UPDATE facturacion.treembolso SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE nid_reembolso = '$this->nid_reembolso'";
      if($this->pgsql->Ejecutar($sql)!=null)
    return true;
    else
    return false;
   }

    public function Desactivar($user){
    $sqlx="SELECT * FROM facturacion.treembolso rc WHERE rc.nid_reembolso = '$this->nid_reembolso'
    AND EXISTS (SELECT 1 FROM inventario.tmovimiento_inventario mi WHERE rc.nid_reembolso=mi.nid_documento AND rc.nid_tipodocumento = mi.nid_tipodocumento)";
    $sql="UPDATE facturacion.treembolso SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE nid_reembolso = '$this->nid_reembolso'";
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
    $sql="UPDATE facturacion.treembolso SET nid_tipodocumento='$this->nid_tipodocumento',crif_persona='$this->crif_persona',
    dfecha_documento='$this->dfecha_documento',nid_devolucion='$this->nid_devolucion',dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE nid_reembolso='$this->nid_reembolso'";
    if($this->pgsql->Ejecutar($sql)!=null)
     return true;
    else
     return false;
   }
   
   public function Consultar(){
    $sql="SELECT rc.nid_reembolso,rc.nid_tipodocumento,rc.nnro_reembolso,TO_CHAR(rc.dfecha_documento,'DD/MM/YYYY') dfecha_documento,
    rc.nid_devolucion,dc.nnro_devolucion,TO_CHAR(dc.dfecha_devolucion,'DD/MM/YYYY') dfecha_devolucion,rc.crif_persona,p.cnombre,
    rc.dfecha_desactivacion,(CASE WHEN rc.dfecha_desactivacion IS NULL THEN  'Activo' ELSE 'Desactivado' END) AS estatus 
    FROM facturacion.vw_reembolso_cliente rc 
    INNER JOIN facturacion.vw_devolucion_cliente dc ON dc.nid_devolucion = rc.nid_devolucion 
    INNER JOIN general.tpersona p ON rc.crif_persona = p.crif_persona 
    WHERE rc.nnro_reembolso='$this->nnro_reembolso'";
  $query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
  $reembolso=$this->pgsql->Respuesta($query);
  $this->nid_reembolso($reembolso['nid_reembolso']);
  $this->nid_tipodocumento($reembolso['nid_tipodocumento']);
  $this->nnro_reembolso($reembolso['nnro_reembolso']);
  $this->dfecha_documento($reembolso['dfecha_documento']);
  $this->nid_devolucion($reembolso['nid_devolucion']);
  $this->nnro_devolucion($reembolso['nnro_devolucion']);
  $this->dfecha_devolucion($reembolso['dfecha_devolucion']);
  $this->crif_persona($reembolso['crif_persona']);
  $this->cnombre($reembolso['cnombre']);
  $this->estatus($reembolso['estatus']);
  $this->dfecha_desactivacion($reembolso['dfecha_desactivacion']);
  return true;
  }
  else{
  return false;
  }
   }
   public function Comprobar(){
    $sql="SELECT * FROM facturacion.vw_reembolso_cliente WHERE nnro_reembolso='$this->nnro_reembolso'";
  $query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
  $reembolso=$this->pgsql->Respuesta($query);
  $this->nid_reembolso($reembolso['nid_reembolso']);
  $this->nid_tipodocumento($reembolso['nid_tipodocumento']);
  $this->nnro_reembolso($reembolso['nnro_reembolso']);
  $this->dfecha_documento($reembolso['dfecha_documento']);
  $this->nid_devolucion($reembolso['nid_devolucion']);
  $this->crif_persona($reembolso['crif_persona']);
  $this->dfecha_desactivacion($reembolso['dfecha_desactivacion']);
  return true;
  }
  else{
  return false;
  }
   }
   
  public function InsertarDetalle($user){
    $sql="INSERT INTO facturacion.tdetalle_reembolso (nid_reembolso,nlinea,cid_articulo,ncantidad_articulo,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
    VALUES ((SELECT nid_reembolso FROM facturacion.treembolso WHERE nnro_reembolso = '$this->nnro_reembolso' AND ctipo_transaccion = 'V'),'$this->nlinea','$this->cid_articulo','$this->ncantidad_articulo',NOW(),'$user',NOW(),'$user')";
    if($this->pgsql->Ejecutar($sql)!=null)
      return true;

    else
      return false;
  }

  public function ActualizarDetalle($user){
    $sql="UPDATE facturacion.tdetalle_reembolso SET nlinea='$this->nlinea',cid_articulo='$this->cid_articulo',
      ncantidad_articulo='$this->ncantidad_articulo',dmodificado_desde=NOW(), cmodificado_por='$user' 
      WHERE nid_reembolso = (SELECT nid_reembolso FROM facturacion.treembolso WHERE nnro_reembolso = '$this->nnro_reembolso' AND ctipo_transaccion = 'V') 
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
      $sqlx="SELECT mi.nid_movinventario,rc.cid_articulo,
      (SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tdetalle_movimiento_inventario' AND LOWER(cdescripcion) LIKE '%materia prima%') ntipo_inventario, 
      MAX(rc.ncantidad_articulo) ncantidad, 
      LAST(CASE WHEN dmi.nvalor_actual IS NULL THEN 0 ELSE dmi.nvalor_actual END) nvalor_anterior,
      LAST(CASE WHEN dmi.nvalor_actual IS NULL THEN (rc.ncantidad_articulo+0) ELSE (rc.ncantidad_articulo+dmi.nvalor_actual) END) nvalor_actual 
      FROM facturacion.vw_reembolso_cliente rc 
      INNER JOIN inventario.tmovimiento_inventario mi ON rc.nid_reembolso = mi.nid_documento 
      LEFT JOIN inventario.tdetalle_movimiento_inventario dmi ON rc.cid_articulo = dmi.cid_articulo  AND dmi.ntipo_inventario = (SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tdetalle_movimiento_inventario' AND LOWER(cdescripcion) LIKE '%productos terminados%')
      WHERE rc.nid_reembolso = '$documento' 
      GROUP BY rc.nlinea,1,2,3 
      ORDER BY rc.nlinea ASC";
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

  public function BuscarDatosNroDevolucion($nnro_devolucion){
    $sql="SELECT dc.nid_devolucion,dc.nnro_devolucion,TO_CHAR(dc.dfecha_devolucion,'DD/MM/YYYY') dfecha_documento,dc.nlinea,dc.cid_articulo,
    a.cdescripcion articulo,dc.crif_persona,p.cnombre,
    (MAX(dc.ncantidad_articulo)-SUM(CASE WHEN rc.ncantidad_articulo IS NULL THEN 0 ELSE rc.ncantidad_articulo END)) ncantidad_articulo 
    FROM facturacion.vw_devolucion_cliente dc 
    LEFT JOIN facturacion.vw_reembolso_cliente rc ON dc.nid_devolucion = rc.nid_devolucion AND dc.cid_articulo = rc.cid_articulo 
    INNER JOIN inventario.tarticulo a ON dc.cid_articulo = a.cid_articulo 
    INNER JOIN general.tpersona p ON dc.crif_persona = p.crif_persona 
    WHERE dc.nnro_devolucion = '$nnro_devolucion' 
    GROUP BY dc.nid_devolucion,dc.nnro_devolucion,dc.dfecha_devolucion,dc.nlinea,dc.cid_articulo,a.cdescripcion,dc.crif_persona,p.cnombre 
    HAVING (MAX(dc.ncantidad_articulo)-SUM(CASE WHEN rc.ncantidad_articulo IS NULL THEN 0 ELSE rc.ncantidad_articulo END)) <> 0 
    ORDER BY dc.nnro_devolucion,dc.nlinea ASC";
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