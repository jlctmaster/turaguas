<?php
require_once("class_bd.php");
class Rol{
	private $nid_rol; 
	private $cdescripcion;
	private $dfecha_desactivacion; 
	private $estatus_rol; 
	private $pgsql; 
	 
	public function __construct(){
		$this->cdescripcion=null;
		$this->nid_rol=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_rol(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_rol;

		if($Num_Parametro>0){
			$this->nid_rol=func_get_arg(0);
		}
    }

    public function estatus_rol(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_rol;

		if($Num_Parametro>0){
			$this->estatus_rol=func_get_arg(0);
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
	    $sql="INSERT INTO general.trol (cdescripcion,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cdescripcion',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE general.trol SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_rol='$this->nid_rol'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
		$sqlx="SELECT * FROM general.trol r WHERE nid_rol = '$this->nid_rol' AND EXISTS (SELECT 1 FROM general.tpersona p WHERE r.nid_rol = p.nid_rol)";
	    $sql="UPDATE general.trol SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_rol='$this->nid_rol'";
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
	    $sql="UPDATE general.trol SET cdescripcion='$this->cdescripcion',dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_rol='$this->nid_rol'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT *,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
	    	ELSE 'Desactivado' END) AS estatus_rol FROM general.trol 
		WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$rol=$this->pgsql->Respuesta($query);
			$this->nid_rol($rol['nid_rol']);
			$this->cdescripcion($rol['cdescripcion']);
		   	$this->estatus_rol($rol['estatus_rol']);
			$this->dfecha_desactivacion($trol['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM general.trol WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$rol=$this->pgsql->Respuesta($query);
			$this->nid_rol($rol['nid_rol']);
			$this->cdescripcion($rol['cdescripcion']);
			$this->dfecha_desactivacion($rol['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>