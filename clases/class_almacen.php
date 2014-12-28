<?php
require_once("class_bd.php");
class Almacen{
	private $nid_ubicacion;
	private $cdescripcion; 
	private $cnombreubicacion; 
	private $nid_almacen; 
	private $dfecha_desactivacion; 
	private $estatus_almacen; 
	private $pgsql; 
	 
	public function __construct(){
		$this->nid_almacen=null;
		$this->cdescripcion=null;
		$this->nid_ubicacion=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_ubicacion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_ubicacion;

		if($Num_Parametro>0){
			$this->nid_ubicacion=func_get_arg(0);
		}
    }

    public function estatus_almacen(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_almacen;

		if($Num_Parametro>0){
			$this->estatus_almacen=func_get_arg(0);
		}
    }
   
    public function cnombreubicacion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cnombreubicacion;

		if($Num_Parametro>0){
			$this->cnombreubicacion=func_get_arg(0);
		}
    } 

    public function nid_almacen(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_almacen;

		if($Num_Parametro>0){
			$this->nid_almacen=func_get_arg(0);
		}
    }

    public function cdescripcion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cdescripcion;
     
		if($Num_Parametro>0){
	   		$this->cdescripcion=func_get_arg(0);
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
	    $sql="INSERT INTO inventario.talmacen(nid_ubicacion,cdescripcion,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->nid_ubicacion','$this->cdescripcion',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE inventario.talmacen SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_almacen='$this->nid_almacen'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
		$sqlx="SELECT * FROM inventario.talmacen a WHERE nid_almacen = '$this->nid_almacen' AND EXISTS (SELECT 1 FROM inventario.tinventario i WHERE a.nid_almacen = i.nid_almacen)";
	    $sql="UPDATE inventario.talmacen SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_almacen='$this->nid_almacen'";
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
	    $sql="UPDATE inventario.talmacen SET cdescripcion='$this->cdescripcion',dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_almacen='$this->nid_almacen'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT a.nid_almacen,a.cdescripcion,a.nid_ubicacion,u.cdescripcion cnombreubicacion,
	    (CASE WHEN a.dfecha_desactivacion IS NULL THEN 'Activo' ELSE 'Desactivado' END) AS estatus_almacen 
	    FROM inventario.talmacen a 
	    INNER JOIN inventario.tubicacion u ON a.nid_ubicacion = u.nid_ubicacion 
		WHERE a.cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$almacen=$this->pgsql->Respuesta($query);
			$this->nid_ubicacion($almacen['nid_ubicacion']);
			$this->cnombreubicacion($almacen['cnombreubicacion']);
			$this->nid_almacen($almacen['nid_almacen']);
			$this->cdescripcion($almacen['cdescripcion']);
		   	$this->estatus_almacen($almacen['estatus_almacen']);
			$this->dfecha_desactivacion($almacen['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM inventario.talmacen  WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$almacen=$this->pgsql->Respuesta($query);
			$this->nid_ubicacion($almacen['nid_ubicacion']);
			$this->cdescripcion($almacen['cdescripcion']);
			$this->ncantidad_min($almacen['ncantidad_min']);
			$this->ncantidad_max($almacen['ncantidad_max']);
			$this->nid_almacen($almacen['nid_almacen']);
			$this->dfecha_desactivacion($almacen['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
