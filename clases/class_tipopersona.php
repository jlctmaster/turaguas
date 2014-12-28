<?php
require_once("class_bd.php");
class Tipopersona{
	private $nid_tipopersona; 
	private $cdescripcion;
	private $dfecha_desactivacion; 
	private $estatus_tipopersona; 
	private $pgsql; 
	 
	public function __construct(){
		$this->cdescripcion=null;
		$this->nid_tipopersona=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_tipopersona(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_tipopersona;

		if($Num_Parametro>0){
			$this->nid_tipopersona=func_get_arg(0);
		}
    }

    public function estatus_tipopersona(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_tipopersona;

		if($Num_Parametro>0){
			$this->estatus_tipopersona=func_get_arg(0);
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
	    $sql="INSERT INTO general.ttipo_persona (cdescripcion,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cdescripcion',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE general.ttipo_persona SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_tipopersona='$this->nid_tipopersona'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
	    $sql="UPDATE general.ttipo_persona SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_tipopersona='$this->nid_tipopersona'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE general.ttipo_persona SET cdescripcion='$this->cdescripcion',dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_tipopersona='$this->nid_tipopersona'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT *,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
	    	ELSE 'Desactivado' END) AS estatus_tipopersona FROM general.ttipo_persona 
		WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tipopersona=$this->pgsql->Respuesta($query);
			$this->nid_tipopersona($tipopersona['nid_tipopersona']);
			$this->cdescripcion($tipopersona['cdescripcion']);
		   	$this->estatus_tipopersona($tipopersona['estatus_tipopersona']);
			$this->dfecha_desactivacion($ttipopersona['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM general.ttipo_persona WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tipopersona=$this->pgsql->Respuesta($query);
			$this->nid_tipopersona($tipopersona['nid_tipopersona']);
			$this->cdescripcion($tipopersona['cdescripcion']);
			$this->dfecha_desactivacion($tipopersona['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>