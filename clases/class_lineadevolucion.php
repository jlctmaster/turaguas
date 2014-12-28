<?php
require_once("class_bd.php");
class Detalle_Devolucion{
	private $nid_detalledevolucion;
	private $nid_devolucion;
	private $nnro_devolucion;
	private $nid_motivodevolucion;
	private $cid_articulo; 
	private $ncantidad_articulo;
	private $dfecha_devolucion; 
	private $pgsql; 
	 
	public function __construct(){
		$this->nid_detalledevolucion=null;
		$this->nid_devolucion=null;
		$this->nnro_devolucion=null;
		$this->nid_motivodevolucion=null;
		$this->cid_articulo=null;
		$this->ncantidad_articulo=null;
		$this->dfecha_devolucion=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_detalledevolucion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_detalledevolucion;

		if($Num_Parametro>0){
			$this->nid_detalledevolucion=func_get_arg(0);
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

    public function nid_motivodevolucion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_motivodevolucion;

		if($Num_Parametro>0){
			$this->nid_motivodevolucion=func_get_arg(0);
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

    public function estatus(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus;

		if($Num_Parametro>0){
			$this->estatus=func_get_arg(0);
		}
    }
   
	public function dfecha_devolucion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->dfecha_devolucion;

		if($Num_Parametro>0){
			$this->dfecha_devolucion=func_get_arg(0);
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
   		$sql="INSERT INTO facturacion.tdetalle_devolucion (nid_devolucion,nid_motivodevolucion,cid_articulo,ncantidad_articulo,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) 
   		VALUES ('$this->nid_devolucion','$this->nid_motivodevolucion','$this->cid_articulo','$this->ncantidad_articulo',NOW(),'$user',NOW(),'$user');";
		 if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Actualizar($user){
    	$sql="UPDATE facturacion.tdetalle_devolucion SET nid_motivodevolucion='$this->nid_motivodevolucion',cid_articulo='$this->cid_articulo',ncantidad_articulo='$this->ncantidad_articulo' 
		,dmodificado_desde=NOW(),cmodificado_por='$user'WHERE nid_devolucion='$this->nid_devolucion' AND nid_detalledevolucion = '$this->nid_detalledevolucion'";
		if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT dd.nid_detalledevolucion,d.nid_devolucion,TRIM(d.nnro_devolucion) nnro_devolucion,TO_CHAR(d.dfecha_devolucion,'DD/MM/YYYY') dfecha_devolucion,dd.nid_motivodevolucion,
	    TRIM(dd.cid_articulo) cid_articulo,dd.ncantidad_articulo
		FROM facturacion.tdevolucion d 
		LEFT JOIN facturacion.tdetalle_devolucion dd ON d.nid_devolucion = dd.nid_devolucion 
		WHERE dd.nid_devolucion='$this->nid_devolucion' AND dd.cid_articulo = '$this->cid_articulo' and dd.nid_motivodevolucion = '$this->nid_motivodevolucion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$detalle_devolucion=$this->pgsql->Respuesta($query);
			$this->nid_detalledevolucion($detalle_devolucion['nid_detalledevolucion']);
			$this->nid_devolucion($detalle_devolucion['nid_devolucion']);
			$this->nnro_devolucion($detalle_devolucion['nnro_devolucion']);
			$this->dfecha_devolucion($detalle_devolucion['dfecha_devolucion']);
			$this->nid_motivodevolucion($detalle_devolucion['nid_motivodevolucion']);
			$this->cid_articulo($detalle_devolucion['cid_articulo']);
			$this->ncantidad_articulo($detalle_devolucion['ncantidad_articulo']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	   $sql="SELECT dd.nid_detalledevolucion,d.nid_devolucion,TRIM(d.nnro_devolucion) nnro_devolucion,TO_CHAR(d.dfecha_devolucion,'DD/MM/YYYY') dfecha_devolucion,dd.nid_motivodevolucion,
	    TRIM(dd.cid_articulo) cid_articulo,dd.ncantidad_articulo
		FROM facturacion.tdevolucion d 
		LEFT JOIN facturacion.tdetalle_devolucion dd ON d.nid_devolucion = dd.nid_devolucion 
		WHERE dd.nid_devolucion='$this->nid_devolucion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$detalle_devolucion=$this->pgsql->Respuesta($query);
			$this->nid_detalledevolucion($detalle_devolucion['nid_detalledevolucion']);
			$this->nid_devolucion($detalle_devolucion['nid_devolucion']);
			$this->nnro_devolucion($detalle_devolucion['nnro_devolucion']);
			$this->dfecha_devolucion($detalle_devolucion['dfecha_devolucion']);
			$this->nid_motivodevolucion($detalle_devolucion['nid_motivodevolucion']);
			$this->cid_articulo($detalle_devolucion['cid_articulo']);
			$this->ncantidad_articulo($detalle_devolucion['ncantidad_articulo']);
			$this->dfecha_desactivacion($detalle_devolucion['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
