<?php
require_once("class_bd.php");
class Condicionpago{
	private $nid_condicionpago; 
	private $cdescripcion;
	private $dfecha_desactivacion; 
	private $estatus_condicionpago; 
	private $pgsql; 
	 
	public function __construct(){
		$this->cdescripcion=null;
		$this->nid_condicionpago=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_condicionpago(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_condicionpago;

		if($Num_Parametro>0){
			$this->nid_condicionpago=func_get_arg(0);
		}
    }

    public function estatus_condicionpago(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_condicionpago;

		if($Num_Parametro>0){
			$this->estatus_condicionpago=func_get_arg(0);
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
	    $sql="INSERT INTO facturacion.tcondicion_pago (cdescripcion,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cdescripcion',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE facturacion.tcondicion_pago SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_condicionpago='$this->nid_condicionpago'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
		$sqlx="SELECT * FROM facturacion.tcondicion_pago cp WHERE nid_condicionpago = '$this->nid_condicionpago' AND EXISTS (SELECT 1 FROM general.tpersona p WHERE cp.nid_condicionpago = p.nid_condicionpago) OR EXISTS (SELECT 1 FROM facturacion.tdocumento d WHERE cp.nid_condicionpago = d.nid_condicionpago)";
	    $sql="UPDATE facturacion.tcondicion_pago SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_condicionpago='$this->nid_condicionpago'";
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
	    $sql="UPDATE facturacion.tcondicion_pago SET cdescripcion='$this->cdescripcion',dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_condicionpago='$this->nid_condicionpago'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT *,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
	    	ELSE 'Desactivado' END) AS estatus_condicionpago FROM facturacion.tcondicion_pago 
		WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$condicionpago=$this->pgsql->Respuesta($query);
			$this->nid_condicionpago($condicionpago['nid_condicionpago']);
			$this->cdescripcion($condicionpago['cdescripcion']);
		   	$this->estatus_condicionpago($condicionpago['estatus_condicionpago']);
			$this->dfecha_desactivacion($tcondicionpago['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM facturacion.tcondicion_pago WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$condicionpago=$this->pgsql->Respuesta($query);
			$this->nid_condicionpago($condicionpago['nid_condicionpago']);
			$this->cdescripcion($condicionpago['cdescripcion']);
			$this->dfecha_desactivacion($condicionpago['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>