<?php
require_once("class_bd.php");
class Unidad{
	private $nid_unidadmedida;
	private $cdescripcion; 
	private $csimbolo; 
	private $dfecha_desactivacion; 
	private $estatus_unidad; 
	private $pgsql; 
	 
	public function __construct(){
		$this->nid_unidadmedida=null;
		$this->cdescripcion=null;
		$this->csimbolo=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_unidadmedida(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_unidadmedida;

		if($Num_Parametro>0){
			$this->nid_unidadmedida=func_get_arg(0);
		}
    }

    public function estatus_unidad(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_unidad;

		if($Num_Parametro>0){
			$this->estatus_unidad=func_get_arg(0);
		}
    }
   
    public function csimbolo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->csimbolo;

		if($Num_Parametro>0){
			$this->csimbolo=func_get_arg(0);
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
	    $sql="INSERT INTO inventario.tunidad_medida (csimbolo,cdescripcion,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->csimbolo','$this->cdescripcion',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE inventario.tunidad_medida SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_unidadmedida='$this->nid_unidadmedida'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
		$sqlx="SELECT * FROM inventario.tunidad_medida u WHERE nid_unidadmedida = '$this->nid_unidadmedida' AND EXISTS (SELECT 1 FROM inventario.tum_conversion c WHERE u.nid_unidadmedida = c.nid_um_desde) OR EXISTS (SELECT 1 FROM inventario.tum_conversion c WHERE u.nid_unidadmedida = c.nid_um_hasta)";
	    $sql="UPDATE inventario.tunidad_medida SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_unidadmedida='$this->nid_unidadmedida'";
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
	    $sql="UPDATE inventario.tunidad_medida SET cdescripcion='$this->cdescripcion',csimbolo='$this->csimbolo',dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_unidadmedida='$this->nid_unidadmedida'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT *,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
	    	ELSE 'Desactivado' END) AS estatus_unidad FROM inventario.tunidad_medida 
		WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$unidad=$this->pgsql->Respuesta($query);
			$this->nid_unidadmedida($unidad['nid_unidadmedida']);
			$this->csimbolo($unidad['csimbolo']);
			$this->cdescripcion($unidad['cdescripcion']);
		   	$this->estatus_unidad($unidad['estatus_unidad']);
			$this->dfecha_desactivacion($unidad['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM inventario.tunidad_medida  WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$unidad=$this->pgsql->Respuesta($query);
			$this->nid_unidadmedida($unidad['nid_unidadmedida']);
			$this->cdescripcion($unidad['cdescripcion']);
			$this->csimbolo($unidad['csimbolo']);
			$this->dfecha_desactivacion($unidad['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
