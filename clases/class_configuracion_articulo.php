<?php
require_once("class_bd.php");
class Configuracion_Articulo{
	private $nid_configuracion_articulo; 
	private $cid_articulo;
	private $articulo;
	private $cid_insumo;
	private $ncantidad;
	private $nmerma;
	private $csimbolo;
	private $cinsumobase;
	private $estatusconfiguracion; 
	private $pgsql; 
	 
	public function __construct(){
		$this->cid_articulo=null;
		$this->articulo=null;
		$this->nid_configuracion_articulo=null;
		$this->cid_insumo=null;
		$this->ncantidad=null;
		$this->nmerma=null;
		$this->csimbolo=null;
		$this->cinsumobase=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_configuracion_articulo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_configuracion_articulo;

		if($Num_Parametro>0){
			$this->nid_configuracion_articulo=func_get_arg(0);
		}
    }
    public function cid_insumo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cid_insumo;

		if($Num_Parametro>0){
			$this->cid_insumo=func_get_arg(0);
		}
    }
  
    public function estatusconfiguracion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatusconfiguracion;

		if($Num_Parametro>0){
			$this->estatusconfiguracion=func_get_arg(0);
		}
    }
   
    public function cid_articulo(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cid_articulo;
     
		if($Num_Parametro>0){
	   		$this->cid_articulo=func_get_arg(0);
	 	}
    }
   
    public function articulo(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->articulo;
     
		if($Num_Parametro>0){
	   		$this->articulo=func_get_arg(0);
	 	}
    }
   
    public function ncantidad(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->ncantidad;
     
		if($Num_Parametro>0){
	   		$this->ncantidad=func_get_arg(0);
	 	}
    }
   
    public function nmerma(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nmerma;
     
		if($Num_Parametro>0){
	   		$this->nmerma=func_get_arg(0);
	 	}
    }
   
    public function cinsumobase(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cinsumobase;
     
		if($Num_Parametro>0){
	   		$this->cinsumobase=func_get_arg(0);
	 	}
    }
   
    public function csimbolo(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->csimbolo;
     
		if($Num_Parametro>0){
	   		$this->csimbolo=func_get_arg(0);
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
	    $sql="INSERT INTO inventario.tconfiguracion_articulo (cid_servicio,cid_insumo,ncantidad,nmerma,cinsumobase,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
	    VALUES ('$this->cid_articulo','$this->cid_insumo','$this->ncantidad','$this->nmerma','$this->cinsumobase',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE inventario.tconfiguracion_articulo SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_configuracionarticulo='$this->nid_configuracion_articulo'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
	    $sql="UPDATE inventario.tconfiguracion_articulo SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_configuracionarticulo='$this->nid_configuracion_articulo'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE inventario.tconfiguracion_articulo SET cid_insumo='$this->cid_insumo',ncantidad='$this->ncantidad',
	    nmerma='$this->nmerma',cinsumobase='$this->cinsumobase',dmodificado_desde=NOW(),cmodificado_por='$user' 
	    WHERE nid_configuracionarticulo='$this->nid_configuracion_articulo'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT ca.nid_configuracionarticulo,TRIM(ca.cid_servicio) cid_servicio,a.cdescripcion articulo,
	    TRIM(ca.cid_insumo) cid_insumo,ca.ncantidad,ca.nmerma,ca.dfecha_desactivacion,um.csimbolo,ca.cinsumobase,
	    (CASE WHEN ca.dfecha_desactivacion IS NULL THEN  'Activo' ELSE 'Desactivado' END) AS estatusconfiguracion 
	    FROM inventario.tconfiguracion_articulo ca 
	    INNER JOIN inventario.tarticulo a ON ca.cid_servicio = a.cid_articulo 
	    INNER JOIN inventario.tarticulo ain ON ca.cid_insumo = ain.cid_articulo 
	    INNER JOIN inventario.tpresentacion p ON ain.nid_presentacion = p.nid_presentacion 
	    INNER JOIN inventario.tunidad_medida um ON p.nid_unidadmedida = um.nid_unidadmedida 
		WHERE ca.cid_insumo='$this->cid_insumo' AND ca.cid_servicio='$this->cid_articulo'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$configuracion_articulo=$this->pgsql->Respuesta($query);
			$this->nid_configuracion_articulo($configuracion_articulo['nid_configuracionarticulo']);
			$this->cid_articulo($configuracion_articulo['cid_servicio']);
			$this->articulo($configuracion_articulo['articulo']);
			$this->cid_insumo($configuracion_articulo['cid_insumo']);
			$this->ncantidad($configuracion_articulo['ncantidad']);
			$this->nmerma($configuracion_articulo['nmerma']);
			$this->csimbolo($configuracion_articulo['csimbolo']);
			$this->cinsumobase($configuracion_articulo['cinsumobase']);
		   	$this->estatusconfiguracion($configuracion_articulo['estatusconfiguracion']);
			$this->dfecha_desactivacion($configuracion_articulo['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM inventario.tconfiguracion_articulo WHERE cid_insumo='$this->cid_insumo' and cid_servicio='$this->cid_articulo'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$configuracion_articulo=$this->pgsql->Respuesta($query);
			$this->nid_configuracion_articulo($configuracion_articulo['nid_configuracion_articulo']);
			$this->cid_insumo($configuracion_articulo['cid_insumo']);
			$this->cid_articulo($configuracion_articulo['cid_servicio']);
			$this->ncantidad($configuracion_articulo['ncantidad']);
			$this->nmerma($configuracion_articulo['nmerma']);
			$this->cinsumobase($configuracion_articulo['cinsumobase']);
			$this->dfecha_desactivacion($configuracion_articulo['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function BuscarUM($articulo){
   		$sql="SELECT um.csimbolo simbolo 
   		FROM inventario.tarticulo a 
   		INNER JOIN inventario.tpresentacion p ON a.nid_presentacion = p.nid_presentacion 
   		INNER JOIN inventario.tunidad_medida um ON p.nid_unidadmedida = um.nid_unidadmedida 
   		WHERE a.cid_articulo = '$articulo'";
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
