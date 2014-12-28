<?php
require_once("class_bd.php");
class Documento{
	private $nid_documento;
	private $nnro_orden; 
	private $nnro_ent_recib; 
	private $nid_tipodocumento;
	private $dfecha_documento; 
	private $dfecha_ent_recib; 
	private $crif_persona; 
	private $cnombreproveedor; 
	private $cdireccionproveedor; 
	private $nid_condicionpago; 
	private $nid_almacen; 
	private $cestado_documento; 
	private $caccion_documento; 
	private $nmonto_base; 
	private $nmonto_total; 
	private $dfecha_desactivacion; 
	private $estatus_documento; 
	private $pgsql; 
	 
	public function __construct(){
		$this->nid_documento=null;
		$this->nnro_orden=null;
		$this->nid_tipodocumento=null;
		$this->dfecha_documento=null;
		$this->crif_persona=null;
		$this->cnombreproveedor=null;
		$this->cdireccionproveedor=null;
		$this->nid_condicionpago=null;
		$this->nid_almacen=null;
		$this->cestado_documento=null;
		$this->caccion_documento=null;
		$this->nmonto_base=null;
		$this->nmonto_total=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_documento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_documento;

		if($Num_Parametro>0){
			$this->nid_documento=func_get_arg(0);
		}
    }
   
    public function nnro_orden(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nnro_orden;
     
		if($Num_Parametro>0){
	   		$this->nnro_orden=func_get_arg(0);
	 	}
    }
   
    public function nnro_ent_recib(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nnro_ent_recib;
     
		if($Num_Parametro>0){
	   		$this->nnro_ent_recib=func_get_arg(0);
	 	}
    }

    public function nid_tipodocumento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_tipodocumento;

		if($Num_Parametro>0){
			$this->nid_tipodocumento=func_get_arg(0);
		}
    }
   
    public function dfecha_documento(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->dfecha_documento;
     
		if($Num_Parametro>0){
	   		$this->dfecha_documento=func_get_arg(0);
	 	}
    }
   
    public function dfecha_ent_recib(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->dfecha_ent_recib;
     
		if($Num_Parametro>0){
	   		$this->dfecha_ent_recib=func_get_arg(0);
	 	}
    }

    public function crif_persona(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->crif_persona;

		if($Num_Parametro>0){
			$this->crif_persona=func_get_arg(0);
		}
    }

    public function cnombreproveedor(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cnombreproveedor;

		if($Num_Parametro>0){
			$this->cnombreproveedor=func_get_arg(0);
		}
    }

    public function cdireccionproveedor(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cdireccionproveedor;

		if($Num_Parametro>0){
			$this->cdireccionproveedor=func_get_arg(0);
		}
    }
   
    public function nid_condicionpago(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_condicionpago;
     
		if($Num_Parametro>0){
	   		$this->nid_condicionpago=func_get_arg(0);
	 	}
    }
   
    public function nid_almacen(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_almacen;
     
		if($Num_Parametro>0){
	   		$this->nid_almacen=func_get_arg(0);
	 	}
    }

    public function cestado_documento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cestado_documento;

		if($Num_Parametro>0){
			$this->cestado_documento=func_get_arg(0);
		}
    }
   
    public function caccion_documento(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->caccion_documento;
     
		if($Num_Parametro>0){
	   		$this->caccion_documento=func_get_arg(0);
	 	}
    }
   
    public function nmonto_base(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nmonto_base;
     
		if($Num_Parametro>0){
	   		$this->nmonto_base=func_get_arg(0);
	 	}
    }
   
    public function nmonto_total(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nmonto_total;
     
		if($Num_Parametro>0){
	   		$this->nmonto_total=func_get_arg(0);
	 	}
    }

    public function estatus_documento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_documento;

		if($Num_Parametro>0){
			$this->estatus_documento=func_get_arg(0);
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
	    $sql="INSERT INTO facturacion.tdocumento (nnro_ent_recib,dfecha_ent_recib,nnro_orden,ctipo_transaccion,nid_tipodocumento,dfecha_documento,crif_persona,nid_condicionpago,nid_almacen
	    ,cestado_documento,caccion_documento,nmonto_total,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->nnro_ent_recib','$this->dfecha_ent_recib','$this->nnro_orden','C','$this->nid_tipodocumento','$this->dfecha_documento','$this->crif_persona','$this->nid_condicionpago','$this->nid_almacen'
	    ,'$this->cestado_documento','$this->caccion_documento','$this->nmonto_total',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null){
	    	$sqlx="SELECT d.nid_almacen,d.cid_articulo,d.nlinea,
			d.ncantidad_articulo-(CASE WHEN de.ncantidad_articulo IS NULL THEN 0 ELSE de.ncantidad_articulo END) ncantidad_articulo,
			d.nid_impuesto,d.nprecio,d.npreciolista 
			FROM facturacion.vw_orden_compra_venta d 
			LEFT JOIN facturacion.vw_orden_entrega_recibo de ON d.nnro_orden = de.nnro_orden AND d.cid_articulo = de.cid_articulo 
			WHERE d.nnro_orden = '$this->nnro_orden' AND d.ctipo_transaccion = 'C' ";
	    	$query = $this->pgsql->Ejecutar($sqlx);
	    	while ($obj=$this->pgsql->Respuesta($query)){
	    		$sql1 = "INSERT INTO facturacion.tdetalle_documento (nid_documento,nlinea,cid_articulo,ncantidad_articulo,nid_impuesto
			    ,nprecio,npreciolista,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
				((SELECT nid_documento FROM facturacion.tdocumento WHERE nnro_ent_recib = '$this->nnro_ent_recib' AND ctipo_transaccion = 'C'),'".$obj['nlinea']."'
				,'".$obj['cid_articulo']."','".$obj['ncantidad_articulo']."','".$obj['nid_impuesto']."','".$obj['nprecio']."','".$obj['npreciolista']."'
				,NOW(),'$user',NOW(),'$user')";
				$this->pgsql->Ejecutar($sql1);
	    	}
			return true;
	    }
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE facturacion.tdocumento SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_documento='$this->nid_documento'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM facturacion.tdocumento WHERE cestado_documento <> 'DR' AND nid_documento = '$this->nid_documento'";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)!=0){
		    $sql="UPDATE facturacion.tdocumento SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
		    cmodificado_por='$user' WHERE nid_documento='$this->nid_documento'";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE facturacion.tdocumento SET nnro_ent_recib='$this->nnro_ent_recib',dfecha_ent_recib='$this->dfecha_ent_recib'
	    ,nnro_orden='$this->nnro_orden',nid_tipodocumento='$this->nid_tipodocumento',dfecha_documento='$this->dfecha_documento'
	    ,crif_persona='$this->crif_persona',nid_condicionpago='$this->nid_condicionpago',nid_almacen='$this->nid_almacen',nmonto_total='$this->nmonto_total'
	    ,dmodificado_desde=NOW(),cmodificado_por='$user' 
	    WHERE nid_documento='$this->nid_documento' AND cestado_documento = 'DR'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT d.nid_documento,TRIM(d.nnro_ent_recib) nnro_ent_recib,TO_CHAR(d.dfecha_ent_recib,'DD/MM/YYYY') dfecha_ent_recib,
	    TRIM(d.nnro_orden) nnro_orden,d.nid_tipodocumento,TO_CHAR(d.dfecha_documento,'DD/MM/YYYY') dfecha_documento,
	    d.crif_persona,p.cnombre,p.cdireccion,d.nid_condicionpago,d.nid_almacen,d.cestado_documento, d.caccion_documento,d.dfecha_desactivacion,
		(CASE WHEN d.dfecha_desactivacion IS NULL THEN 'Activo' ELSE 'Desactivado' END) AS estatus_documento, 
		ROUND(SUM(CASE WHEN (d.ncantidad_articulo*d.nprecio) IS NULL THEN 0 ELSE (d.ncantidad_articulo*d.nprecio) END),2) nmonto_base,
		ROUND(SUM(nmonto_total),2) nmonto_total 
		FROM facturacion.vw_orden_entrega_recibo d 
		LEFT JOIN general.tpersona p ON d.crif_persona = p.crif_persona 
		WHERE d.nnro_ent_recib='$this->nnro_ent_recib' AND d.ctipo_transaccion = 'C' 
		GROUP BY d.nid_documento,d.nnro_ent_recib,d.nnro_orden,d.nid_tipodocumento,d.dfecha_ent_recib,d.dfecha_documento,d.crif_persona,p.cnombre,p.cdireccion,
		d.nid_condicionpago,d.nid_almacen,d.cestado_documento,d.caccion_documento,d.dfecha_desactivacion";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$documento=$this->pgsql->Respuesta($query);
			$this->nid_documento($documento['nid_documento']);
			$this->nnro_orden($documento['nnro_orden']);
			$this->nnro_ent_recib($documento['nnro_ent_recib']);
			$this->nid_tipodocumento($documento['nid_tipodocumento']);
			$this->dfecha_documento($documento['dfecha_documento']);
			$this->dfecha_ent_recib($documento['dfecha_ent_recib']);
			$this->crif_persona($documento['crif_persona']);
			$this->cnombreproveedor($documento['cnombre']);
			$this->cdireccionproveedor($documento['cdireccion']);
			$this->nid_condicionpago($documento['nid_condicionpago']);
			$this->nid_almacen($documento['nid_almacen']);
			$this->cestado_documento($documento['cestado_documento']);
			$this->caccion_documento($documento['caccion_documento']);
			$this->nmonto_base($documento['nmonto_base']);
			$this->nmonto_total($documento['nmonto_total']);
		   	$this->estatus_documento($documento['estatus_documento']);
			$this->dfecha_desactivacion($documento['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM facturacion.tdocumento WHERE nnro_ent_recib='$this->nnro_ent_recib' AND ctipo_transaccion = 'C'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$documento=$this->pgsql->Respuesta($query);
			$this->nid_documento($documento['nid_documento']);
			$this->nnro_orden($documento['nnro_orden']);
			$this->nnro_ent_recib($documento['nnro_ent_recib']);
			$this->nid_tipodocumento($documento['nid_tipodocumento']);
			$this->dfecha_documento($documento['dfecha_documento']);
			$this->dfecha_ent_recib($documento['dfecha_ent_recib']);
			$this->crif_persona($documento['crif_persona']);
			$this->nid_condicionpago($documento['nid_condicionpago']);
			$this->cestado_documento($documento['cestado_documento']);
			$this->caccion_documento($documento['caccion_documento']);
			$this->nmonto_total($documento['nmonto_total']);
			$this->dfecha_desactivacion($documento['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

	public function ComprobarAlmacen($articulo,$almacen,$cant_articulos,$signo,$user){
		$sql="SELECT * FROM inventario.tinventario WHERE cid_articulo = '$articulo' AND nid_almacen = '$almacen'
		AND nestatus_inventario = (SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tinventario' 
		AND (LOWER(cdescripcion) LIKE '%insumo%'))";
		$query=$this->pgsql->Ejecutar($sql);
		if($this->pgsql->Total_Filas($query)!=null){
			$sqlx="UPDATE inventario.tinventario SET nexistencia=nexistencia".$signo.$cant_articulos.",dmodificado_desde=NOW(),cmodificado_por='$user' 
			WHERE cid_articulo = '$articulo' AND nid_almacen = '$almacen' AND nestatus_inventario = 
			(SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tinventario' 
			AND (LOWER(cdescripcion) LIKE '%insumo%'))";
			if($this->pgsql->Ejecutar($sqlx)!=null){
				if($signo=="+")
					$signo="-";
				else
					$signo="+";
				$sqlx1="UPDATE inventario.tinventario SET nexistencia=nexistencia".$signo.$cant_articulos.",dmodificado_desde=NOW(),cmodificado_por='$user' 
				WHERE cid_articulo = '$articulo' AND nid_almacen = '$almacen' AND nestatus_inventario = 
				(SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tinventario' 
				AND (LOWER(cdescripcion) LIKE '%ordenado%' OR LOWER(cdescripcion) LIKE '%productos ordenados%'))";
				if($this->pgsql->Ejecutar($sqlx1)!=null)
					return true;
				else
					return false;
			}
			else
				return false;
		}
		else{
			$sqlx="INSERT INTO inventario.tinventario (cid_articulo,nid_almacen,nexistencia,nestatus_inventario,
			dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES ('$articulo','$almacen','$cant_articulos',
			(SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tinventario' 
			AND (LOWER(cdescripcion) LIKE '%insumo%')),NOW(),'$user',NOW(),'$user')";
			if($this->pgsql->Ejecutar($sqlx)!=null){
				if($signo=="+")
					$signo="-";
				else
					$signo="+";
				$sqlx1="UPDATE inventario.tinventario SET nexistencia=nexistencia".$signo.$cant_articulos.",dmodificado_desde=NOW(),cmodificado_por='$user' 
				WHERE cid_articulo = '$articulo' AND nid_almacen = '$almacen' AND nestatus_inventario = 
				(SELECT nid_combovalor FROM general.tcombo_valor WHERE ctabla = 'tinventario' 
				AND (LOWER(cdescripcion) LIKE '%ordenado%' OR LOWER(cdescripcion) LIKE '%productos ordenados%'))";
				if($this->pgsql->Ejecutar($sqlx1)!=null)
					return true;
				else
					return false;
			}
			else
				return false;
		}
	}

	public function GenerarMovimientoInventario($documento,$fecha,$tipo,$user){
		$sql="INSERT INTO inventario.tmovimiento_inventario (nid_documento,dfecha_movinventario,ctipo_movinventario,
		dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES ('$documento','$fecha','$tipo',NOW(),'$user',NOW(),'$user')";
		if($this->pgsql->Ejecutar($sql)!=null){
			$sqlx="SELECT mi.nid_movinventario,dd.cid_articulo,i.nid_inventario,dd.ncantidad_articulo 
			FROM facturacion.tdocumento d 
			INNER JOIN facturacion.tdetalle_documento dd ON d.nid_documento = dd.nid_documento 
			INNER JOIN inventario.tinventario i ON d.nid_almacen = i.nid_almacen AND dd.cid_articulo = i.cid_articulo 
			INNER JOIN inventario.tmovimiento_inventario mi ON d.nid_documento = mi.nid_documento 
			WHERE d.nid_documento = '$documento' AND i.nestatus_inventario = (SELECT nid_combovalor FROM general.tcombo_valor 
			WHERE ctabla = 'tinventario' AND LOWER(cdescripcion) LIKE '%insumo%')";
			$query = $this->pgsql->Ejecutar($sqlx);
			while($rows=$this->pgsql->Respuesta($query)){
				$sql1 = "INSERT INTO inventario.tdetalle_movimiento_inventario (nid_movinventario,cid_articulo,nid_inventario,ncantidad,
				dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES (".$rows['nid_movinventario'].",'".$rows['cid_articulo']."',
				".$rows['nid_inventario'].",".$rows['ncantidad_articulo'].",NOW(),'$user',NOW(),'$user')";
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

   	public function BuscarNroOrden(){
   		$sql="SELECT MAX(CAST(nnro_ent_recib AS NUMERIC))+1 nnro_ent_recib FROM facturacion.tdocumento 
   		WHERE ctipo_transaccion = 'C' AND cestado_documento <> 'VO'";
		$query = $this->pgsql->Ejecutar($sql);
		$numero =$this->pgsql->Total_Filas($query);
		if($numero>0){
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
		}
        return $json;
   	}

   	public function BuscarDatosNroOrden($nnro_orden){
   		$sql="SELECT TO_CHAR(d.dfecha_documento,'DD/MM/YYYY') dfecha_documento,p.crif_persona,p.cnombre,p.cdireccion,d.nid_almacen,
   		p.nid_condicionpago,ROUND(SUM(CASE WHEN ((d.ncantidad_articulo-(CASE WHEN de.ncantidad_articulo IS NULL THEN 0 ELSE de.ncantidad_articulo END))*d.nprecio) IS NULL THEN 0 
		ELSE ((d.ncantidad_articulo-(CASE WHEN de.ncantidad_articulo IS NULL THEN 0 ELSE de.ncantidad_articulo END))*d.nprecio) END),2) nmonto_base,
		ROUND(SUM(d.nmonto_total-(CASE WHEN de.nmonto_total IS NULL THEN 0 ELSE de.nmonto_total END)),2) nmonto_total 
   		FROM general.tpersona p 
   		INNER JOIN facturacion.vw_orden_compra_venta d ON p.crif_persona = d.crif_persona 
        LEFT JOIN facturacion.vw_orden_entrega_recibo de ON de.nnro_orden = d.nnro_orden and d.cid_articulo = de.cid_articulo
   		WHERE d.nnro_orden = '$nnro_orden' AND d.ctipo_transaccion = 'C' 
   		GROUP BY d.dfecha_documento,p.crif_persona,p.cnombre,p.cdireccion,d.nid_almacen,p.nid_condicionpago
";
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
   		$sql="SELECT crif_persona,cnombre,cdireccion,nid_condicionpago FROM general.tpersona WHERE crif_persona = '$proveedor'";
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

   	public function BuscarEstatus($documento){
   		$sql="SELECT nnro_orden,cestado_documento as estatus,caccion_documento as accion FROM facturacion.tdocumento WHERE nid_documento = '$documento'";
		$query = $this->pgsql->Ejecutar($sql);
        while($Obj=$this->pgsql->Respuesta_assoc($query)){
                $rows[]=array_map("utf8_encode",$Obj);
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

   	public function CambiarEstatus($estatus,$documento,$user,$motivorazon){
   		if($estatus!="VO" && $motivorazon!="0"){
	   		$sqlx="SELECT * FROM facturacion.tdetalle_documento WHERE nid_documento = '$documento'";
	   		$query = $this->pgsql->Ejecutar($sqlx);
	   		if($this->pgsql->Total_Filas($query)!=0){
		   		if($estatus=="CO"){
		   			$sql="UPDATE facturacion.tdocumento SET cestado_documento='$estatus',caccion_documento='CL',dmodificado_desde=NOW(),cmodificado_por='$user' 
		   			WHERE nid_documento = '$documento'";
		   			$msj="El documento ha sido Completado con exito!";
		   		}else if($estatus=="CL"){
					$sql="UPDATE facturacion.tdocumento SET cestado_documento='$estatus',caccion_documento='--',dmodificado_desde=NOW(),cmodificado_por='$user' 
		   			WHERE nid_documento = '$documento'";
		   			$msj="El documento ha sido Cerrado con exito!";
		   		}
		        if($this->pgsql->Ejecutar($sql)!=null){
		        	if($estatus=="CO"){
			        	$sql1="SELECT d.nid_almacen,dd.cid_articulo,dd.ncantidad_articulo,d.dfecha_ent_recib FROM facturacion.tdocumento d 
			        	INNER JOIN facturacion.tdetalle_documento dd ON d.nid_documento = dd.nid_documento 
			        	WHERE d.nid_documento = '$documento'";
			        	$query1 = $this->pgsql->Ejecutar($sql1);
			        	while($lineas=$this->pgsql->Respuesta($query1)){
			        		$fecha=$lineas['dfecha_ent_recib'];
			        		$this->ComprobarAlmacen($lineas['cid_articulo'],$lineas['nid_almacen'],$lineas['ncantidad_articulo'],'+',$user);
			        	}
			        	$this->GenerarMovimientoInventario($documento,$fecha,'E',$user);
		        	}
		            $rows[] = array("msj" => $msj);
		            $json = json_encode($rows);
		        }
		        else{
		            $rows[] = array("msj" => "Error al modificar el registro");
		            $json = json_encode($rows);
		        }
	   		}else{
	   			$rows[] = array("msj" => "Error el documento no posee lineas.");
		        $json = json_encode($rows);
	   		}
   		}else{
   			$sqlx="SELECT * FROM facturacion.tdocumento oc 
   			INNER JOIN facturacion.tdocumento orecib ON oc.nnro_orden = orecib.nnro_orden 
			WHERE oc.nid_documento = '$documento' AND orecib.nnro_ent_recib IS NOT NULL";
			$query = $this->pgsql->Ejecutar($sqlx);
	   		if($this->pgsql->Total_Filas($query)==0){
	   			$sql="UPDATE facturacion.tdocumento SET cestado_documento='$estatus',caccion_documento='--',nnro_orden=(nnro_orden || '^'),nid_motivorazon='$motivorazon',dmodificado_desde=NOW(),cmodificado_por='$user' 
		   		WHERE nid_documento = '$documento'";
		   		$msj="El documento ha sido Anulado con exito!";
		   		if($this->pgsql->Ejecutar($sql)!=null){
		   			$sql1="SELECT d.nid_almacen,dd.cid_articulo,dd.ncantidad_articulo FROM facturacion.tdocumento d 
		        	INNER JOIN facturacion.tdetalle_documento dd ON d.nid_documento = dd.nid_documento 
		        	WHERE d.nid_documento = '$documento'";
		        	$query1 = $this->pgsql->Ejecutar($sql1);
		        	while($lineas=$this->pgsql->Respuesta($query1)) {
		        		$listo = $this->ComprobarAlmacen($lineas['cid_articulo'],$lineas['nid_almacen'],$lineas['ncantidad_articulo'],'-',$user);
		        		if($listo==true){
		        			$this->GenerarMovimientoInventario($documento,'S',$user);
		        		}
		        	}
		            $rows[] = array("msj" => $msj);
		            $json = json_encode($rows);
		        }
		        else{
		            $rows[] = array("msj" => "Error al modificar el registro");
		            $json = json_encode($rows);
		        }
   			}else{
	   			$rows[] = array("msj" => "Error el documento esta asociado a una orden de recibo por lo tanto no se puede anular, primero anule la orden de recibo.");
		        $json = json_encode($rows);
	   		}
   		}
        return $json;
   	}
}
?>
