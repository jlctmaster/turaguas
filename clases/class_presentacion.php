<?php
require_once("class_bd.php");
class Presentacion{
	private $nid_presentacion; 
	private $cdescripcion;
	private $nunidades;
	private $ncapacidad;
	private $nid_unidadmedida;
	private $dfecha_desactivacion; 
	private $estatus_presentacion; 
	private $pgsql; 
	 
	public function __construct(){
		$this->cdescripcion=null;
		$this->nid_presentacion=null;
		$this->nunidades=null;
		$this->ncapacidad=null;
		$this->nid_unidadmedida=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_presentacion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_presentacion;

		if($Num_Parametro>0){
			$this->nid_presentacion=func_get_arg(0);
		}
    }

    public function estatus_presentacion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_presentacion;

		if($Num_Parametro>0){
			$this->estatus_presentacion=func_get_arg(0);
		}
    }
   
    public function cdescripcion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cdescripcion;
     
		if($Num_Parametro>0){
	   		$this->cdescripcion=func_get_arg(0);
	 	}
    }
   
   public function nunidades(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nunidades;
     
		if($Num_Parametro>0){
	   		$this->nunidades=func_get_arg(0);
	 	}
    }

    public function ncapacidad(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->ncapacidad;
     
		if($Num_Parametro>0){
	   		$this->ncapacidad=func_get_arg(0);
	 	}
    }

    public function nid_unidadmedida(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_unidadmedida;
     
		if($Num_Parametro>0){
	   		$this->nid_unidadmedida=func_get_arg(0);
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
	    $sql="INSERT INTO inventario.tpresentacion (cdescripcion,nunidades,ncapacidad,nid_unidadmedida,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cdescripcion','$this->nunidades','$this->ncapacidad','$this->nid_unidadmedida',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE inventario.tpresentacion SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_presentacion='$this->nid_presentacion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
		$sqlx="SELECT * FROM inventario.tpresentacion p WHERE nid_presentacion = '$this->nid_presentacion' AND EXISTS (SELECT 1 FROM inventario.tarticulo a WHERE p.nid_presentacion = a.nid_presentacion)";
	    $sql="UPDATE inventario.tpresentacion SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_presentacion='$this->nid_presentacion'";
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
	    $sql="UPDATE inventario.tpresentacion SET cdescripcion='$this->cdescripcion',nunidades='$this->nunidades',ncapacidad='$this->ncapacidad',nid_unidadmedida='$this->nid_unidadmedida',dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_presentacion='$this->nid_presentacion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT *,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
	    	ELSE 'Desactivado' END) AS estatus_presentacion FROM inventario.tpresentacion 
		WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$presentacion=$this->pgsql->Respuesta($query);
			$this->nid_presentacion($presentacion['nid_presentacion']);
			$this->cdescripcion($presentacion['cdescripcion']);
			$this->nunidades($presentacion['nunidades']);
			$this->ncapacidad($presentacion['ncapacidad']);
			$this->nid_unidadmedida($presentacion['nid_unidadmedida']);
		   	$this->estatus_presentacion($presentacion['estatus_presentacion']);
			$this->dfecha_desactivacion($presentacion['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM inventario.tpresentacion WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$presentacion=$this->pgsql->Respuesta($query);
			$this->nid_presentacion($presentacion['nid_presentacion']);
			$this->cdescripcion($presentacion['cdescripcion']);
			$this->nunidades($presentacion['nunidades']);
			$this->ncapacidad($presentacion['ncapacidad']);
			$this->nid_unidadmedida($presentacion['nid_unidadmedida']);
			$this->dfecha_desactivacion($presentacion['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>