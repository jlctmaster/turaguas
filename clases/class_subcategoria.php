<?php
require_once("class_bd.php");
class Subcategoria{
	private $nid_categoria_sub; 
	private $cdescripcions;
	private $cdescripcionc;
	private $nid_categoria_padre; 
	private $dfecha_desactivacion; 
	private $estatus_subcategoria; 
	private $pgsql; 
	 
	public function __construct(){
		$this->cdescripcions=null;
		$this->nid_categoria_sub=null;
		$this->nid_categoria_padre=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_categoria_sub(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_categoria_sub;

		if($Num_Parametro>0){
			$this->nid_categoria_sub=func_get_arg(0);
		}
    }
    public function nid_categoria_padre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_categoria_padre;

		if($Num_Parametro>0){
			$this->nid_categoria_padre=func_get_arg(0);
		}
    }
    public function estatus_subcategoria(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_subcategoria;

		if($Num_Parametro>0){
			$this->estatus_subcategoria=func_get_arg(0);
		}
    }
   
    public function cdescripcions(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cdescripcions;
     
		if($Num_Parametro>0){
	   		$this->cdescripcions=func_get_arg(0);
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
	    $sql="INSERT INTO inventario.tcategoria (cdescripcion,nid_categoria_padre,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cdescripcions','$this->nid_categoria_padre',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE inventario.tcategoria SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_categoria='$this->nid_categoria_sub'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM inventario.tcategoria sc WHERE sc.nid_categoria = '$this->nid_categoria_sub' AND EXISTS 
    	(SELECT 1 FROM inventario.tarticulo a WHERE sc.nid_categoria = a.nid_categoria)";
	    $sql="UPDATE inventario.tcategoria SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_categoria='$this->nid_categoria_sub'";
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
	    $sql="UPDATE inventario.tcategoria SET cdescripcion='$this->cdescripcions',dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_categoria='$this->nid_categoria_sub'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT s.nid_categoria,s.cdescripcion,s.nid_categoria_padre,s.dfecha_desactivacion,c.cdescripcion cdescripcionc, 
	    (CASE WHEN s.dfecha_desactivacion IS NULL THEN 'Activo' ELSE 'Desactivado' END) AS estatus_subcategoria 
	    FROM inventario.tcategoria s
	    INNER JOIN inventario.tcategoria c ON s.nid_categoria_padre = c.nid_categoria 
		WHERE s.cdescripcion='$this->cdescripcions'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$subcategoria=$this->pgsql->Respuesta($query);
			$this->nid_categoria_sub($subcategoria['nid_categoria']);
			$this->cdescripcions($subcategoria['cdescripcion']);
			$this->cdescripcionc($subcategoria['cdescripcionc']);
			$this->nid_categoria_padre($subcategoria['nid_categoria_padre']);
		   	$this->estatus_subcategoria($subcategoria['estatus_subcategoria']);
			$this->dfecha_desactivacion($subcategoria['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM inventario.tcategoria WHERE cdescripcion='$this->cdescripcions'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$subcategoria=$this->pgsql->Respuesta($query);
			$this->nid_categoria_sub($subcategoria['nid_categoria']);
			$this->cdescripcions($subcategoria['cdescripcion']);
			$this->nid_categoria_padre($subcategoria['nid_categoria_padre']);
			$this->dfecha_desactivacion($subcategoria['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
