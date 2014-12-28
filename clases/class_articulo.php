<?php
require_once("class_bd.php");
class Articulo{
	private $cid_articulo;
	private $cdescripcionarticulo; 
	private $nid_impuesto; 
	private $nid_tipoarticulo; 
	private $nid_presentacion; 
	private $nid_categoria; 
	private $nid_marca;
	private $ncantidad_min;
	private $ncantidad_max; 
	private $dfecha_desactivacion; 
	private $estatusarticulo; 
	private $pgsql; 
	 
	public function __construct(){
		$this->nid_tipoarticulo=null;
		$this->nid_presentacion=null;
		$this->nid_impuesto=null;
		$this->nid_categoria=null;
		$this->nid_marca=null;
		$this->ncantidad_min=null;
		$this->ncantidad_max=null;
		$this->cdescripcionarticulo=null;
		$this->cid_articulo=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function cid_articulo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cid_articulo;

		if($Num_Parametro>0){
			$this->cid_articulo=func_get_arg(0);
		}
    }

    public function estatusarticulo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatusarticulo;

		if($Num_Parametro>0){
			$this->estatusarticulo=func_get_arg(0);
		}
    }
   
   public function ncantidad_min(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->ncantidad_min;

		if($Num_Parametro>0){
			$this->ncantidad_min=func_get_arg(0);
		}
    }

    public function ncantidad_max(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->ncantidad_max;

		if($Num_Parametro>0){
			$this->ncantidad_max=func_get_arg(0);
		}
    }
    public function nid_tipoarticulo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_tipoarticulo;

		if($Num_Parametro>0){
			$this->nid_tipoarticulo=func_get_arg(0);
		}
    }

    public function nid_impuesto(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_impuesto;

		if($Num_Parametro>0){
			$this->nid_impuesto=func_get_arg(0);
		}
    }

    public function nid_presentacion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_presentacion;

		if($Num_Parametro>0){
			$this->nid_presentacion=func_get_arg(0);
		}
    }   

    public function nid_categoria(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_categoria;

		if($Num_Parametro>0){
			$this->nid_categoria=func_get_arg(0);
		}
    }

    public function nid_marca(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_marca;

		if($Num_Parametro>0){
			$this->nid_marca=func_get_arg(0);
		}
    }

    public function cdescripcionarticulo(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cdescripcionarticulo;
     
		if($Num_Parametro>0){
	   		$this->cdescripcionarticulo=func_get_arg(0);
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
   		if ($this->nid_marca==0)
   		{
   			$sql="INSERT INTO inventario.tarticulo (cid_articulo,nid_tipoarticulo,nid_presentacion,nid_categoria,cdescripcion,ncantidad_min,ncantidad_max,nid_impuesto,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cid_articulo','$this->nid_tipoarticulo','$this->nid_presentacion','$this->nid_categoria','$this->cdescripcionarticulo','$this->ncantidad_min','$this->ncantidad_max','$this->nid_impuesto',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   		}else
   		{
   			$sql="INSERT INTO inventario.tarticulo (cid_articulo,nid_tipoarticulo,nid_presentacion,nid_categoria,nid_marca,cdescripcion,ncantidad_min,ncantidad_max,nid_impuesto,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cid_articulo','$this->nid_tipoarticulo','$this->nid_presentacion','$this->nid_categoria','$this->nid_marca','$this->cdescripcionarticulo','$this->ncantidad_min','$this->ncantidad_max','$this->nid_impuesto',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   		}
   	}
   
    public function Activar($user){
	    $sql="UPDATE inventario.tarticulo SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE cid_articulo='$this->cid_articulo'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM inventario.tarticulo a WHERE a.cid_articulo = '$this->cid_articulo' AND (EXISTS 
		(SELECT 1 FROM inventario.tarticulo af WHERE a.cid_articulo = af.cid_articulo_final)
		OR EXISTS (SELECT 1 FROM inventario.tconfiguracion_articulo ca WHERE ca.cid_servicio = a.cid_articulo OR ca.cid_insumo = a.cid_articulo) 
		OR EXISTS (SELECT 1 FROM inventario.tum_conversion umc WHERE umc.cid_articulo = a.cid_articulo) 
		OR EXISTS (SELECT 1 FROM inventario.tinventario i WHERE i.cid_articulo = a.cid_articulo) 
		OR EXISTS (SELECT 1 FROM facturacion.tdetalle_devolucion ddev WHERE ddev.cid_articulo = a.cid_articulo)
		OR EXISTS (SELECT 1 FROM facturacion.tdetalle_lista_precio dlp WHERE dlp.cid_articulo = a.cid_articulo)
		OR EXISTS (SELECT 1 FROM facturacion.tdetalle_documento dd WHERE dd.cid_articulo = a.cid_articulo) 
		OR EXISTS (SELECT 1 FROM inventario.tdetalle_movimiento_inventario dmi WHERE dmi.cid_articulo = a.cid_articulo))";
	    $sql="UPDATE inventario.tarticulo SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE cid_articulo='$this->cid_articulo'";
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
    	if ($this->nid_marca==0)
   		{
   			$sql="UPDATE inventario.tarticulo SET cdescripcion='$this->cdescripcionarticulo',nid_tipoarticulo='$this->nid_tipoarticulo',
	    nid_presentacion='$this->nid_presentacion', nid_impuesto='$this->nid_impuesto',
	    nid_categoria='$this->nid_categoria',ncantidad_min='$this->ncantidad_min',ncantidad_max='$this->ncantidad_max',
	    dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE cid_articulo='$this->cid_articulo'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   		}else
   		{
   			$sql="UPDATE inventario.tarticulo SET cdescripcion='$this->cdescripcionarticulo',nid_tipoarticulo='$this->nid_tipoarticulo',
	    nid_presentacion='$this->nid_presentacion', nid_impuesto='$this->nid_impuesto',
	    nid_categoria='$this->nid_categoria',nid_marca='$this->nid_marca',ncantidad_min='$this->ncantidad_min',ncantidad_max='$this->ncantidad_max',
	    dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE cid_articulo='$this->cid_articulo'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   		}
	    
   	}
   
   	public function Consultar(){
	    $sql="SELECT TRIM(cid_articulo) cid_articulo,nid_tipoarticulo,nid_presentacion,nid_categoria,
	    nid_marca,cdescripcion,nid_impuesto,ncantidad_min,ncantidad_max,dfecha_desactivacion,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' ELSE 'Desactivado' END) AS estatusarticulo 
	    FROM inventario.tarticulo 
		WHERE cid_articulo='$this->cid_articulo'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$articulo=$this->pgsql->Respuesta($query);
			$this->cid_articulo($articulo['cid_articulo']);
			$this->nid_tipoarticulo($articulo['nid_tipoarticulo']);
			$this->nid_presentacion($articulo['nid_presentacion']);
			$this->nid_categoria($articulo['nid_categoria']);
			$this->nid_marca($articulo['nid_marca']);
			$this->cdescripcionarticulo($articulo['cdescripcion']);
			$this->nid_impuesto($articulo['nid_impuesto']);
			$this->ncantidad_min($articulo['ncantidad_min']);
			$this->ncantidad_max($articulo['ncantidad_max']);
		   	$this->estatusarticulo($articulo['estatusarticulo']);
			$this->dfecha_desactivacion($articulo['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM inventario.tarticulo  WHERE cid_articulo='$this->cid_articulo'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$articulo=$this->pgsql->Respuesta($query);
			$this->cid_articulo($articulo['cid_articulo']);
			$this->cdescripcionarticulo($articulo['cdescripcion']);
			$this->nid_tipoarticulo($articulo['nid_tipoarticulo']);
			$this->nid_presentacion($articulo['nid_presentacion']);
			$this->nid_categoria($articulo['nid_categoria']);
			$this->nid_marca($articulo['nid_marca']);
			$this->ncantidad_min($articulo['ncantidad_min']);
			$this->ncantidad_max($articulo['ncantidad_max']);
			$this->nid_impuesto($articulo['nid_impuesto']);
			$this->dfecha_desactivacion($articulo['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function GenerarNombreArticulo($categoria,$marca,$presentacion){
   		if($marca==0){
   			$sql="SELECT p.cdescripcion||' '||c.cdescripcion||' ('||p.nunidades||'X'||p.ncapacidad||um.csimbolo||')' AS nombre 
			FROM inventario.tpresentacion p INNER JOIN inventario.tunidad_medida um ON p.nid_unidadmedida = um.nid_unidadmedida,inventario.tcategoria c 
			WHERE p.nid_presentacion = '$presentacion' AND c.nid_categoria = '$categoria'";
   		}else{
   			$sql="SELECT p.cdescripcion||' '||c.cdescripcion||' '||m.cdescripcion||' ('||p.nunidades||'X'||p.ncapacidad||um.csimbolo||')' AS nombre 
			FROM inventario.tpresentacion p INNER JOIN inventario.tunidad_medida um ON p.nid_unidadmedida = um.nid_unidadmedida,inventario.tcategoria c,inventario.tmarca m 
			WHERE p.nid_presentacion = '$presentacion' AND m.nid_marca = '$marca' AND c.nid_categoria = '$categoria'";
   		}
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
