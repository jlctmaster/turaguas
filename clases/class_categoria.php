<?php
require_once("class_bd.php");
class Categoria{
	private $nid_categoria; 
	private $cdescripcionc;
	private $dfecha_desactivacion; 
	private $estatus_categoria; 
	private $pgsql; 
	 
	public function __construct(){
		$this->cdescripcionc=null;
		$this->nid_categoria=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_categoria(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_categoria;

		if($Num_Parametro>0){
			$this->nid_categoria=func_get_arg(0);
		}
    }

    public function estatus_categoria(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_categoria;

		if($Num_Parametro>0){
			$this->estatus_categoria=func_get_arg(0);
		}
    }
   
    public function cdescripcionc(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cdescripcionc;
     
		if($Num_Parametro>0){
	   		$this->cdescripcionc=func_get_arg(0);
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
	    $sql="INSERT INTO inventario.tcategoria (cdescripcion,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cdescripcionc',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE inventario.tcategoria SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_categoria='$this->nid_categoria'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM inventario.tcategoria c WHERE c.nid_categoria = '$this->nid_categoria' AND EXISTS 
    	(SELECT 1 FROM inventario.tcategoria sc WHERE c.nid_categoria = sc.nid_categoria_padre)";
	    $sql="UPDATE inventario.tcategoria SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_categoria='$this->nid_categoria'";
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
	    $sql="UPDATE inventario.tcategoria SET cdescripcion='$this->cdescripcionc',dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_categoria='$this->nid_categoria'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT *,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
	    	ELSE 'Desactivado' END) AS estatus_categoria FROM inventario.tcategoria 
		WHERE cdescripcion='$this->cdescripcionc'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$categoria=$this->pgsql->Respuesta($query);
			$this->nid_categoria($categoria['nid_categoria']);
			$this->cdescripcionc($categoria['cdescripcion']);
		   	$this->estatus_categoria($categoria['estatus_categoria']);
			$this->dfecha_desactivacion($tcategoria['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM inventario.tcategoria WHERE cdescripcion='$this->cdescripcionc'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$categoria=$this->pgsql->Respuesta($query);
			$this->nid_categoria($categoria['nid_categoria']);
			$this->cdescripcionc($categoria['cdescripcion']);
			$this->dfecha_desactivacion($categoria['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
