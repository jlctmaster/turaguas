<?php
require_once("class_bd.php");
class Listaprecio{
	private $nid_listaprecio; 
	private $cdescripcionlistaprecio;
	private $dvigencia_desde;
    private $dvigencia_hasta;
	private $dfecha_desactivacion; 
	private $estatuslistaprecio; 
	private $pgsql; 
	 
	public function __construct(){
		$this->cdescripcionlistaprecio=null;
		$this->nid_listaprecio=null;
		$this->dvigencia_desde=null;
		$this->dvigencia_hasta=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_listaprecio(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_listaprecio;

		if($Num_Parametro>0){
			$this->nid_listaprecio=func_get_arg(0);
		}
    }

    public function estatuslistaprecio(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatuslistaprecio;

		if($Num_Parametro>0){
			$this->estatuslistaprecio=func_get_arg(0);
		}
    }
   
    public function cdescripcionlistaprecio(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cdescripcionlistaprecio;
     
		if($Num_Parametro>0){
	   		$this->cdescripcionlistaprecio=func_get_arg(0);
	 	}
    }

	public function dvigencia_desde(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->dvigencia_desde;
     
	 if($Num_Parametro>0){
	   $this->dvigencia_desde=func_get_arg(0);
	 }
   }

   public function dvigencia_hasta(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->dvigencia_hasta;
     
	 if($Num_Parametro>0){
	   $this->dvigencia_hasta=func_get_arg(0);
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
	    $sql="INSERT INTO facturacion.tlista_precio (cdescripcion,dvigencia_desde,dvigencia_hasta,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cdescripcionlistaprecio','$this->dvigencia_desde','$this->dvigencia_hasta',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE facturacion.tlista_precio SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_listaprecio='$this->nid_listaprecio'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM facturacion.tlista_precio lp WHERE lp.nid_listaprecio = '$this->nid_listaprecio' AND 
    	EXISTS (SELECT 1 FROM facturacion.tdetalle_lista_precio dlp WHERE dlp.nid_listaprecio = lp.nid_listaprecio)";
	    $sql="UPDATE facturacion.tlista_precio SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_listaprecio='$this->nid_listaprecio'";
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
		$sql="SELECT * FROM facturacion.tlista_precio lp WHERE nid_listaprecio = '1' AND EXISTS (SELECT 1 FROM facturacion.tdetalle_lista_precio dlp WHERE lp.nid_listaprecio = dlp.nid_listaprecio)";
	    $sql="UPDATE facturacion.tlista_precio SET cdescripcion='$this->cdescripcionlistaprecio',dvigencia_desde='$this->dvigencia_desde',dvigencia_hasta='$this->dvigencia_hasta',dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_listaprecio='$this->nid_listaprecio'";
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
   
   	public function Consultar(){
	    $sql="SELECT nid_listaprecio,cdescripcion,to_char(dvigencia_desde,'DD/MM/YYYY') dvigencia_desde,to_char(dvigencia_hasta,'DD/MM/YYYY') dvigencia_hasta,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
	    	ELSE 'Desactivado' END) AS estatuslistaprecio FROM facturacion.tlista_precio 
		WHERE cdescripcion='$this->cdescripcionlistaprecio'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$listaprecio=$this->pgsql->Respuesta($query);
			$this->nid_listaprecio($listaprecio['nid_listaprecio']);
			$this->cdescripcionlistaprecio($listaprecio['cdescripcion']);
			$this->dvigencia_desde($listaprecio['dvigencia_desde']);
			$this->dvigencia_hasta($listaprecio['dvigencia_hasta']);
		   	$this->estatuslistaprecio($listaprecio['estatuslistaprecio']);
			$this->dfecha_desactivacion($tlistaprecio['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM facturacion.tlista_precio WHERE cdescripcion='$this->cdescripcionlistaprecio'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$listaprecio=$this->pgsql->Respuesta($query);
			$this->nid_listaprecio($listaprecio['nid_listaprecio']);
			$this->cdescripcionlistaprecio($listaprecio['cdescripcion']);
			$this->dvigencia_desde($listaprecio['dvigencia_desde']);
			$this->dvigencia_hasta($listaprecio['dvigencia_hasta']);
			$this->dfecha_desactivacion($listaprecio['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>