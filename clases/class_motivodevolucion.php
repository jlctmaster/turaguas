<?php
require_once("class_bd.php");
class MotivoDev{
	private $nid_motivodevolucion;
	private $cdescripciongrupo; 
	private $nid_motivodevolucion_padre; 
	private $cdescripcionmotivo; 
	private $dfecha_desactivacion; 
	private $estatus_motivo; 
	private $pgsql; 
	 
	public function __construct(){
		$this->nid_motivodevolucion_padre=null;
		$this->cdescripciongrupo=null;
		$this->nid_motivodevolucion=null;
		$this->cdescripcionmotivo=null;

		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_motivodevolucion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_motivodevolucion;

		if($Num_Parametro>0){
			$this->nid_motivodevolucion=func_get_arg(0);
		}
    }

    public function estatus_motivo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_almacen;

		if($Num_Parametro>0){
			$this->estatus_almacen=func_get_arg(0);
		}
    }
   
    public function cdescripciongrupo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cdescripciongrupo;

		if($Num_Parametro>0){
			$this->cdescripciongrupo=func_get_arg(0);
		}
    } 

    public function nid_motivodevolucion_padre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_motivodevolucion_padre;

		if($Num_Parametro>0){
			$this->nid_motivodevolucion_padre=func_get_arg(0);
		}
    }

    public function cdescripcionmotivo(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cdescripcionmotivo;
     
		if($Num_Parametro>0){
	   		$this->cdescripcionmotivo=func_get_arg(0);
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
	    $sql="INSERT INTO facturacion.tmotivo_devolucion(cdescripcion,nid_motivodevolucion_padre,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cdescripcionmotivo','$this->nid_motivodevolucion_padre',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE facturacion.tmotivo_devolucion SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_motivodevolucion='$this->nid_motivodevolucion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM facturacion.tmotivo_devolucion md WHERE md.nid_motivodevolucion = '$this->nid_motivodevolucion' AND 
    	EXISTS (SELECT 1 FROM facturacion.tdetalle_devolucion dd WHERE md.nid_motivodevolucion = dd.nid_motivodevolucion)";
	    $sql="UPDATE facturacion.tmotivo_devolucion SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_motivodevolucion='$this->nid_motivodevolucion'";
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
	    $sql="UPDATE facturacion.tmotivo_devolucion SET cdescripcion='$this->cdescripcion',dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_motivodevolucion='$this->nid_motivodevolucion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT m.cdescripcion, m.nid_motivodevolucion, m.nid_motivodevolucion_padre, g.cdescripcion grupo,
	    m.dfecha_desactivacion,
	    CASE WHEN m.dfecha_desactivacion IS NULL THEN 'Activo' ELSE 'Desactivado' END estatus_motivo 
		FROM facturacion.tmotivo_devolucion m 
		INNER JOIN facturacion.tmotivo_devolucion g ON m.nid_motivodevolucion_padre = g.nid_motivodevolucion 
		WHERE m.cdescripcion='$this->cdescripcionmotivo' 
		ORDER BY m.nid_motivodevolucion DESC";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$motivo=$this->pgsql->Respuesta($query);
			$this->nid_motivodevolucion($motivo['nid_motivodevolucion']);
			$this->cdescripcionmotivo($motivo['cdescripcion']);
			$this->cdescripciongrupo($motivo['grupo']);
			$this->nid_motivodevolucion_padre($motivo['nid_motivodevolucion_padre']);
		   	$this->estatus_motivo($motivo['estatus_motivo']);
			$this->dfecha_desactivacion($motivo['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM facturacion.tmotivo_devolucion  WHERE cdescripcion='$this->cdescripcionmotivo'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$motivo=$this->pgsql->Respuesta($query);
			$this->nid_motivodevolucion($motivo['nid_motivodevolucion']);
			$this->cdescripcionmotivo($motivo['cdescripcion']);
			$this->cdescripciongrupo($motivo['grupo']);
			$this->nid_motivodevolucion_padre($motivo['nid_motivodevolucion_padre']);
			$this->dfecha_desactivacion($motivo['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
