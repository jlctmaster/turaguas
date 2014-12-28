<?php
require_once("class_bd.php");
class Impuesto{
	private $nid_impuesto; 
	private $cdescripcion;
	private $nporcentaje; 
	private $dfecha_desactivacion; 
	private $estatus_impuesto; 
	private $pgsql; 
	 
	public function __construct(){
		$this->cdescripcion=null;
		$this->nid_impuesto=null;
		$this->nporcentaje=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_impuesto(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_impuesto;

		if($Num_Parametro>0){
			$this->nid_impuesto=func_get_arg(0);
		}
    }

    public function estatus_impuesto(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_impuesto;

		if($Num_Parametro>0){
			$this->estatus_impuesto=func_get_arg(0);
		}
    }
   
    public function cdescripcion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cdescripcion;
     
		if($Num_Parametro>0){
	   		$this->cdescripcion=func_get_arg(0);
	 	}
    }

   	public function nporcentaje(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nporcentaje;

		if($Num_Parametro>0){
			$this->nporcentaje=func_get_arg(0);
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
	    $sql="INSERT INTO facturacion.timpuesto (cdescripcion,nporcentaje,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cdescripcion','$this->nporcentaje',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE facturacion.timpuesto SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_impuesto='$this->nid_impuesto'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM facturacion.timpuesto i WHERE nid_impuesto = '$this->nid_impuesto' 
    	AND EXISTS (SELECT 1 FROM inventario.tarticulo a WHERE i.nid_impuesto = a.nid_impuesto) OR 
    	EXISTS (SELECT 1 FROM facturacion.tdetalle_documento d WHERE i.nid_impuesto = d.nid_impuesto)";
	    $sql="UPDATE facturacion.timpuesto SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_impuesto='$this->nid_impuesto'";
	    $query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
   	}
   
    public function Actualizar($user){
		$sql="UPDATE facturacion.timpuesto SET cdescripcion='$this->cdescripcion',nporcentaje='$this->nporcentaje',dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_impuesto='$this->nid_impuesto'";
		if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT *,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
	    	ELSE 'Desactivado' END) AS estatus_impuesto FROM facturacion.timpuesto 
		WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$impuesto=$this->pgsql->Respuesta($query);
			$this->nid_impuesto($impuesto['nid_impuesto']);
			$this->cdescripcion($impuesto['cdescripcion']);
			$this->nporcentaje($impuesto['nporcentaje']);
		   	$this->estatus_impuesto($impuesto['estatus_impuesto']);
			$this->dfecha_desactivacion($timpuesto['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM facturacion.timpuesto WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$impuesto=$this->pgsql->Respuesta($query);
			$this->nid_impuesto($impuesto['nid_impuesto']);
			$this->cdescripcion($impuesto['cdescripcion']);
			$this->nporcentaje($impuesto['nporcentaje']);
			$this->dfecha_desactivacion($impuesto['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>