<?php
require_once("class_bd.php");
class Tipodocumento{
	private $nid_tipodocumento; 
	private $cdescripcion;
	private $nfactor;
	private $ctipo_transaccion;
	private $dfecha_desactivacion; 
	private $estatus_tipodocumento; 
	private $pgsql; 
	 
	public function __construct(){
		$this->cdescripcion=null;
		$this->nid_tipodocumento=null;
		$this->nfactor=null;
		$this->ctipo_transaccion=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_tipodocumento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_tipodocumento;

		if($Num_Parametro>0){
			$this->nid_tipodocumento=func_get_arg(0);
		}
    }

    public function estatus_tipodocumento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_tipodocumento;

		if($Num_Parametro>0){
			$this->estatus_tipodocumento=func_get_arg(0);
		}
    }
   
    public function cdescripcion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cdescripcion;
     
		if($Num_Parametro>0){
	   		$this->cdescripcion=func_get_arg(0);
	 	}
    }
   
   public function nfactor(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nfactor;
     
		if($Num_Parametro>0){
	   		$this->nfactor=func_get_arg(0);
	 	}
    }
   
   public function ctipo_transaccion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->ctipo_transaccion;
     
		if($Num_Parametro>0){
	   		$this->ctipo_transaccion=func_get_arg(0);
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
	    $sql="INSERT INTO facturacion.ttipo_documento (cdescripcion,nfactor,ctipo_transaccion,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cdescripcion','$this->nfactor','$this->ctipo_transaccion',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE facturacion.ttipo_documento SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_tipodocumento='$this->nid_tipodocumento'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
		$sqlx="SELECT * FROM facturacion.ttipo_documento td WHERE nid_tipodocumento = '$this->nid_tipodocumento' AND EXISTS (SELECT 1 FROM facturacion.tdocumento d WHERE td.nid_tipodocumento = d.nid_tipodocumento)";
	    $sql="UPDATE facturacion.ttipo_documento SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_tipodocumento='$this->nid_tipodocumento'";
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
	    $sql="UPDATE facturacion.ttipo_documento SET cdescripcion='$this->cdescripcion',nfactor='$this->nfactor',ctipo_transaccion='$this->ctipo_transaccion'
	    ,dmodificado_desde=NOW(),cmodificado_por='$user' WHERE nid_tipodocumento='$this->nid_tipodocumento'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT *,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
	    	ELSE 'Desactivado' END) AS estatus_tipodocumento FROM facturacion.ttipo_documento 
		WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tipodocumento=$this->pgsql->Respuesta($query);
			$this->nid_tipodocumento($tipodocumento['nid_tipodocumento']);
			$this->cdescripcion($tipodocumento['cdescripcion']);
			$this->nfactor($tipodocumento['nfactor']);
			$this->ctipo_transaccion($tipodocumento['ctipo_transaccion']);
		   	$this->estatus_tipodocumento($tipodocumento['estatus_tipodocumento']);
			$this->dfecha_desactivacion($ttipo_documento['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM facturacion.ttipo_documento WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tipodocumento=$this->pgsql->Respuesta($query);
			$this->nid_tipodocumento($tipodocumento['nid_tipodocumento']);
			$this->cdescripcion($tipodocumento['cdescripcion']);
			$this->nfactor($tipodocumento['nfactor']);
			$this->ctipo_transaccion($tipodocumento['ctipo_transaccion']);
			$this->dfecha_desactivacion($tipodocumento['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>