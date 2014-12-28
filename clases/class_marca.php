<?php
require_once("class_bd.php");
class Marca{
	private $nid_marca; 
	private $cdescripcion;
	private $dfecha_desactivacion; 
	private $estatus_marca; 
	private $pgsql; 
	 
	public function __construct(){
		$this->cdescripcion=null;
		$this->nid_marca=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_marca(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_marca;

		if($Num_Parametro>0){
			$this->nid_marca=func_get_arg(0);
		}
    }

    public function estatus_marca(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_marca;

		if($Num_Parametro>0){
			$this->estatus_marca=func_get_arg(0);
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
	    $sql="INSERT INTO inventario.tmarca (cdescripcion,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cdescripcion',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE inventario.tmarca SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_marca='$this->nid_marca'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
		$sqlx="SELECT * FROM inventario.tmarca m WHERE nid_marca = '$this->nid_marca' AND EXISTS (SELECT 1 FROM inventario.tarticulo a WHERE m.nid_marca = a.nid_marca)";
	    $sql="UPDATE inventario.tmarca SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_marca='$this->nid_marca'";
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
	    $sql="UPDATE inventario.tmarca SET cdescripcion='$this->cdescripcion',dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_marca='$this->nid_marca'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT *,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
	    	ELSE 'Desactivado' END) AS estatus_marca FROM inventario.tmarca 
		WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$marca=$this->pgsql->Respuesta($query);
			$this->nid_marca($marca['nid_marca']);
			$this->cdescripcion($marca['cdescripcion']);
		   	$this->estatus_marca($marca['estatus_marca']);
			$this->dfecha_desactivacion($tmarca['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM inventario.tmarca WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$marca=$this->pgsql->Respuesta($query);
			$this->nid_marca($marca['nid_marca']);
			$this->cdescripcion($marca['cdescripcion']);
			$this->dfecha_desactivacion($marca['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>