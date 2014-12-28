<?php
require_once("class_bd.php");
class Ciudad{
	private $nid_localidad; 
	private $ctabla;
	private $cdescripcion;
	private $cnombreestado;
	private $nid_localidad_padre; 
	private $dfecha_desactivacion; 
	private $estatus_ciudad; 
	private $pgsql; 
	 
	public function __construct(){
		$this->ctabla=null;
		$this->cdescripcion=null;
		$this->nid_localidad=null;
		$this->nid_localidad_padre=null;
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

    public function nid_localidad_padre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_localidad_padre;

		if($Num_Parametro>0){
			$this->nid_localidad_padre=func_get_arg(0);
		}
    }

    public function estatus_ciudad(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_ciudad;

		if($Num_Parametro>0){
			$this->estatus_ciudad=func_get_arg(0);
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
   
    public function cnombreestado(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cnombreestado;
     
		if($Num_Parametro>0){
	   		$this->cnombreestado=func_get_arg(0);
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
	    $sql="INSERT INTO general.tlocalidad (ctabla,cdescripcion,nid_localidad_padre,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->ctabla','$this->cdescripcion','$this->nid_localidad_padre',NOW(),'$user',NOW(),'$user');";
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
    	$sqlx="SELECT * FROM general.tlocalidad c WHERE nid_localidad = '$this->nid_localidad' AND EXISTS (SELECT 1 FROM general.tlocalidad m WHERE c.nid_localidad = m.nid_localidad_padre AND m.ctabla ='tmunicipio')";
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
	    $sql="UPDATE general.tlocalidad SET cdescripcion='$this->cdescripcion',dmodificado_desde=NOW(),cmodificado_por='$user' WHERE nid_localidad='$this->nid_localidad'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT c.nid_localidad,c.cdescripcion,c.nid_localidad_padre,c.dfecha_desactivacion,e.cdescripcion cnombreestado,
	    (CASE WHEN c.dfecha_desactivacion IS NULL THEN 'Activo' ELSE 'Desactivado' END) AS estatus_ciudad 
	    FROM general.tlocalidad c 
	    INNER JOIN general.tlocalidad e ON c.nid_localidad_padre = e.nid_localidad 
		WHERE c.cdescripcion='$this->cdescripcion' AND c.ctabla='$this->ctabla'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$localidad=$this->pgsql->Respuesta($query);
			$this->nid_localidad($localidad['nid_localidad']);
			$this->cnombreestado($localidad['cnombreestado']);
			$this->cdescripcion($localidad['cdescripcion']);
			$this->nid_localidad_padre($localidad['nid_localidad_padre']);
		   	$this->estatus_ciudad($localidad['estatus_ciudad']);
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
			$this->nid_localidad_padre($localidad['nid_localidad_padre']);
			$this->dfecha_desactivacion($localidad['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>