<?php
require_once("class_bd.php");
class ubicacion{
	private $nid_ubicacion;
	private $cdescripcion; 
	private $cpunto_referencia; 
	private $dfecha_desactivacion; 
	private $estatus_ubicacion; 
	private $pgsql; 
	 
	public function __construct(){
		$this->cpunto_referencia=null;
		$this->cdescripcion=null;
		$this->nid_ubicacion=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_ubicacion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_ubicacion;

		if($Num_Parametro>0){
			$this->nid_ubicacion=func_get_arg(0);
		}
    }

    public function estatus_ubicacion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_ubicacion;

		if($Num_Parametro>0){
			$this->estatus_ubicacion=func_get_arg(0);
		}
    }
   
    public function cpunto_referencia(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cpunto_referencia;

		if($Num_Parametro>0){
			$this->cpunto_referencia=func_get_arg(0);
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
	    $sql="INSERT INTO inventario.tubicacion (cpunto_referencia,cdescripcion,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cpunto_referencia','$this->cdescripcion',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE inventario.tubicacion SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_ubicacion='$this->nid_ubicacion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
		$sqlx="SELECT * FROM inventario.tubicacion u WHERE nid_ubicacion = '$this->nid_ubicacion' AND EXISTS (SELECT 1 FROM inventario.talmacen a WHERE u.nid_ubicacion = a.nid_ubicacion)";
	    $sql="UPDATE inventario.tubicacion SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_ubicacion='$this->nid_ubicacion'";
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
	    $sql="UPDATE inventario.tubicacion SET cdescripcion='$this->cdescripcion',cpunto_referencia='$this->cpunto_referencia',dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_ubicacion='$this->nid_ubicacion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT *,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
	    	ELSE 'Desactivado' END) AS estatus_ubicacion FROM inventario.tubicacion 
		WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$ubicacion=$this->pgsql->Respuesta($query);
			$this->nid_ubicacion($ubicacion['nid_ubicacion']);
			$this->cpunto_referencia($ubicacion['cpunto_referencia']);
			$this->cdescripcion($ubicacion['cdescripcion']);
		   	$this->estatus_ubicacion($ubicacion['estatus_ubicacion']);
			$this->dfecha_desactivacion($ubicacion['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM inventario.tubicacion  WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$ubicacion=$this->pgsql->Respuesta($query);
			$this->nid_ubicacion($ubicacion['nid_ubicacion']);
			$this->cdescripcion($ubicacion['cdescripcion']);
			$this->cpunto_referencia($ubicacion['cpunto_referencia']);
			$this->dfecha_desactivacion($ubicacion['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
