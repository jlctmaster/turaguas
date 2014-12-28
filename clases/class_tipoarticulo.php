<?php
require_once("class_bd.php");
class Tipoarticulo{
	private $nid_tipoarticulo; 
	private $cdescripcion;
	private $dfecha_desactivacion; 
	private $estatus_tipoarticulo; 
	private $pgsql; 
	 
	public function __construct(){
		$this->cdescripcion=null;
		$this->nid_tipoarticulo=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_tipoarticulo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_tipoarticulo;

		if($Num_Parametro>0){
			$this->nid_tipoarticulo=func_get_arg(0);
		}
    }

    public function estatus_tipoarticulo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_tipoarticulo;

		if($Num_Parametro>0){
			$this->estatus_tipoarticulo=func_get_arg(0);
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
	    $sql="INSERT INTO inventario.ttipo_articulo (cdescripcion,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cdescripcion',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE inventario.ttipo_articulo SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_tipoarticulo='$this->nid_tipoarticulo'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
		$sqlx="SELECT * FROM inventario.ttipo_articulo t WHERE nid_tipoarticulo = '$this->nid_tipoarticulo' AND EXISTS (SELECT 1 FROM inventario.tarticulo a WHERE t.nid_tipoarticulo = a.nid_tipoarticulo)";
	    $sql="UPDATE inventario.ttipo_articulo SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_tipoarticulo='$this->nid_tipoarticulo'";
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
	    $sql="UPDATE inventario.ttipo_articulo SET cdescripcion='$this->cdescripcion',dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_tipoarticulo='$this->nid_tipoarticulo'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT *,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
	    	ELSE 'Desactivado' END) AS estatus_tipoarticulo FROM inventario.ttipo_articulo 
		WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tipoarticulo=$this->pgsql->Respuesta($query);
			$this->nid_tipoarticulo($tipoarticulo['nid_tipoarticulo']);
			$this->cdescripcion($tipoarticulo['cdescripcion']);
		   	$this->estatus_tipoarticulo($tipoarticulo['estatus_tipoarticulo']);
			$this->dfecha_desactivacion($ttipoarticulo['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM inventario.ttipo_articulo WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tipoarticulo=$this->pgsql->Respuesta($query);
			$this->nid_tipoarticulo($tipoarticulo['nid_tipoarticulo']);
			$this->cdescripcion($tipoarticulo['cdescripcion']);
			$this->dfecha_desactivacion($tipoarticulo['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>