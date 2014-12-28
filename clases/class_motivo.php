<?php
require_once("class_bd.php");
class Motivo{
	private $nid_motivorazon; 
	private $cdescripcion;
	private $dfecha_desactivacion; 
	private $estatus_motivo; 
	private $pgsql; 
	 
	public function __construct(){
		$this->cdescripcion=null;
		$this->nid_motivorazon=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_motivorazon(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_motivorazon;

		if($Num_Parametro>0){
			$this->nid_motivorazon=func_get_arg(0);
		}
    }

    public function estatus_motivo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_motivo;

		if($Num_Parametro>0){
			$this->estatus_motivo=func_get_arg(0);
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
	    $sql="INSERT INTO facturacion.tmotivo_razon (cdescripcion,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cdescripcion',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE facturacion.tmotivo_razon SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_motivorazon='$this->nid_motivorazon'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
	    $sqlx="SELECT * FROM facturacion.tmotivo_razon m WHERE nid_motivorazon = '$this->nid_motivorazon' 
	    AND (EXISTS (SELECT 1 FROM facturacion.tdocumento d WHERE m.nid_motivorazon = d.nid_motivorazon) OR EXISTS 
	    (SELECT 1 FROM facturacion.tdevolucion de WHERE m.nid_motivorazon = de.nid_motivorazon)";
		$sql="UPDATE facturacion.tmotivo_razon SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_motivorazon='$this->nid_motivorazon'";
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
	    $sql="UPDATE facturacion.tmotivo_razon SET cdescripcion='$this->cdescripcion',dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_motivorazon='$this->nid_motivorazon'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT *,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
	    	ELSE 'Desactivado' END) AS estatus_motivo FROM facturacion.tmotivo_razon 
		WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$motivo=$this->pgsql->Respuesta($query);
			$this->nid_motivorazon($motivo['nid_motivorazon']);
			$this->cdescripcion($motivo['cdescripcion']);
		   	$this->estatus_motivo($motivo['estatus_motivo']);
			$this->dfecha_desactivacion($tmotivo_razon['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM facturacion.tmotivo_razon WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$motivo=$this->pgsql->Respuesta($query);
			$this->nid_motivorazon($motivo['nid_motivorazon']);
			$this->cdescripcion($motivo['cdescripcion']);
			$this->dfecha_desactivacion($motivo['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
