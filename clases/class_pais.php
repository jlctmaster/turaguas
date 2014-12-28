<?php
require_once("class_bd.php");
class Pais{
	private $nid_localidad; 
	private $ctabla;
	private $cdescripcion;
	private $dfecha_desactivacion; 
	private $estatus_pais; 
	private $pgsql; 
	 
	public function __construct(){
		$this->ctabla=null;
		$this->cdescripcion=null;
		$this->nid_localidad=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_localidad(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_localidad;

		if($Num_Parametro>0){
			$this->nid_localidad=func_get_arg(0);
		}
    }

    public function estatus_pais(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_pais;

		if($Num_Parametro>0){
			$this->estatus_pais=func_get_arg(0);
		}
    }
   
    public function ctabla(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->ctabla;

		if($Num_Parametro>0){
			$this->ctabla=func_get_arg(0);
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
	    $sql="INSERT INTO general.tlocalidad (ctabla,cdescripcion,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->ctabla','$this->cdescripcion',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE general.tlocalidad SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_localidad='$this->nid_localidad'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM general.tlocalidad p WHERE nid_localidad = '$this->nid_localidad' AND EXISTS (SELECT 1 FROM general.tlocalidad e WHERE p.nid_localidad = e.nid_localidad_padre AND e.ctabla ='testado')";
	    $sql="UPDATE general.tlocalidad SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_localidad='$this->nid_localidad'";
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
	    $sql="UPDATE general.tlocalidad SET cdescripcion='$this->cdescripcion',dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_localidad='$this->nid_localidad'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT *,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
	    	ELSE 'Desactivado' END) AS estatus_pais FROM general.tlocalidad 
		WHERE cdescripcion='$this->cdescripcion' AND ctabla='$this->ctabla'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$localidad=$this->pgsql->Respuesta($query);
			$this->nid_localidad($localidad['nid_localidad']);
			$this->ctabla($localidad['ctabla']);
			$this->cdescripcion($localidad['cdescripcion']);
		   	$this->estatus_pais($localidad['estatus_pais']);
			$this->dfecha_desactivacion($tlocalidad['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM general.tlocalidad WHERE cdescripcion='$this->cdescripcion' AND ctabla='$this->ctabla'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$localidad=$this->pgsql->Respuesta($query);
			$this->nid_localidad($localidad['nid_localidad']);
			$this->ctabla($localidad['ctabla']);
			$this->cdescripcion($localidad['cdescripcion']);
			$this->dfecha_desactivacion($localidad['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
