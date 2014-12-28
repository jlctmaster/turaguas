<?php
require_once("class_bd.php");
class Grupo{
	private $nid_motivodevolucion;
	private $cdescripcion; 
	private $dfecha_desactivacion; 
	private $estatus_grupo; 
	private $pgsql; 
	 
	public function __construct(){
		$this->cdescripcion=null;
		$this->nid_motivodevolucion=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_motivodevolucion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_motivodevolucion;

		if($Num_Parametro>0){
			$this->nid_motivodevolucion=func_get_arg(0);
		}
    }

    public function estatus_grupo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_grupo;

		if($Num_Parametro>0){
			$this->estatus_grupo=func_get_arg(0);
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
	    $sql="INSERT INTO facturacion.tmotivo_devolucion (cdescripcion,cacumulado,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cdescripcion','Y',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE facturacion.tmotivo_devolucion SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_motivodevolucion='$this->nid_motivodevolucion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
	    $sql="UPDATE facturacion.tmotivo_devolucion SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_motivodevolucion='$this->nid_motivodevolucion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE facturacion.tmotivo_devolucion SET cdescripcion='$this->cdescripcion',dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_motivodevolucion='$this->nid_motivodevolucion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT *,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
	    	ELSE 'Desactivado' END) AS estatus_grupo FROM facturacion.tmotivo_devolucion 
		WHERE cdescripcion='$this->cdescripcion' AND cacumulado = 'Y'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$grupo=$this->pgsql->Respuesta($query);
			$this->nid_motivodevolucion($grupo['nid_motivodevolucion']);
			$this->cdescripcion($grupo['cdescripcion']);
		   	$this->estatus_grupo($grupo['estatus_grupo']);
			$this->dfecha_desactivacion($grupo['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM facturacion.tmotivo_devolucion  WHERE cdescripcion='$this->cdescripcion' AND cacumulado = 'Y'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$grupo=$this->pgsql->Respuesta($query);
			$this->nid_motivodevolucion($grupo['nid_motivodevolucion']);
			$this->cdescripcion($grupo['cdescripcion']);
			$this->dfecha_desactivacion($grupo['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
