<?php
require_once("class_bd.php");
class Linea{
	private $nid_detallelistaprecio; 
	private $nid_listaprecio;
	private $cdescripcion;
	private $cid_articulo; 
	private $nprecio; 
	private $nprecio_limite; 
	private $ndescuento;
	private $dfecha_desactivacion; 
	private $estatuslinea; 
	private $pgsql; 
	 
	public function __construct(){
		$this->nid_detallelistaprecio=null;
		$this->nid_listaprecio=null;
		$this->cid_articulo=null;
		$this->nprecio=null;
		$this->nprecio_limite=null;
		$this->ndescuento=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_detallelistaprecio(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_detallelistaprecio;

		if($Num_Parametro>0){
			$this->nid_detallelistaprecio=func_get_arg(0);
		}
    }

    public function cdescripcion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cdescripcion;

		if($Num_Parametro>0){
			$this->cdescripcion=func_get_arg(0);
		}
    }

    public function estatuslinea(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatuslinea;

		if($Num_Parametro>0){
			$this->estatuslinea=func_get_arg(0);
		}
    }
   
    public function nprecio(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nprecio;

		if($Num_Parametro>0){
			$this->nprecio=func_get_arg(0);
		}
    }

    public function nid_listaprecio(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_listaprecio;

		if($Num_Parametro>0){
			$this->nid_listaprecio=func_get_arg(0);
		}
    }

    public function nprecio_limite(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nprecio_limite;

		if($Num_Parametro>0){
			$this->nprecio_limite=func_get_arg(0);
		}
    }   

    public function ndescuento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->ndescuento;

		if($Num_Parametro>0){
			$this->ndescuento=func_get_arg(0);
		}
    }

   
    public function cid_articulo(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cid_articulo;
     
		if($Num_Parametro>0){
	   		$this->cid_articulo=func_get_arg(0);
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
	    $sql="INSERT INTO facturacion.tdetalle_lista_precio (cid_articulo,nprecio,nprecio_limite,ndescuento,nid_listaprecio,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cid_articulo','$this->nprecio','$this->nprecio_limite','$this->ndescuento','$this->nid_listaprecio',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE facturacion.tdetalle_lista_precio SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_detallelistaprecio='$this->nid_detallelistaprecio'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM facturacion.tdetalle_lista_precio dlp WHERE dlp.nid_detallelistaprecio = '$this->nid_detallelistaprecio' 
    	AND EXISTS (SELECT 1 FROM inventario.tarticulo a INNER JOIN facturacion.tdetalle_documento dd ON a.cid_articulo = dd.cid_articulo 
    	WHERE dlp.cid_articulo = a.cid_articulo)";
	    $sql="UPDATE facturacion.tdetalle_lista_precio SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_detallelistaprecio='$this->nid_detallelistaprecio'";
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
	    $sql="UPDATE facturacion.tdetalle_lista_precio SET cid_articulo='$this->cid_articulo',nprecio='$this->nprecio',
	    nprecio_limite='$this->nprecio_limite',ndescuento='$this->ndescuento',
	    dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_detallelistaprecio='$this->nid_detallelistaprecio'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT *,
	    (CASE WHEN dlp.dfecha_desactivacion IS NULL THEN  'Activo' 
	    ELSE 'Desactivado' END) AS estatuslinea FROM facturacion.tdetalle_lista_precio dlp 
		INNER JOIN facturacion.tlista_precio lp ON lp.nid_listaprecio = dlp.nid_listaprecio 
		WHERE dlp.cid_articulo='$this->cid_articulo' AND dlp.nid_listaprecio = '$this->nid_listaprecio'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$linea=$this->pgsql->Respuesta($query);
			$this->cdescripcion($linea['cdescripcion']);
			$this->cid_articulo($linea['cid_articulo']);
			$this->nprecio($linea['nprecio']);
			$this->nprecio_limite($linea['nprecio_limite']);
			$this->ndescuento($linea['ndescuento']);
			$this->nid_detallelistaprecio($linea['nid_detallelistaprecio']);
			$this->nid_listaprecio($linea['nid_listaprecio']);
		   	$this->estatuslinea($linea['estatuslinea']);
			$this->dfecha_desactivacion($linea['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM facturacion.tdetalle_lista_precio  WHERE cid_articulo='$this->cid_articulo' AND nid_listaprecio = '$this->nid_listaprecio'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$linea=$this->pgsql->Respuesta($query);
			$this->cid_articulo($linea['cid_articulo']);
			$this->nprecio($linea['nprecio']);
			$this->nprecio_limite($linea['nprecio_limite']);
			$this->ndescuento($linea['ndescuento']);
			//$this->nid_marca($linea['nid_marca']);
			//$this->nid_unidadmedida($linea['nid_unidadmedida']);
			$this->nid_listaprecio($linea['nid_listaprecio']);
			$this->dfecha_desactivacion($linea['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
