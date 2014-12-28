<?php
require_once("class_bd.php");
class Conversion{
	private $nid_um_conversion; 
	private $cid_articulo; 
	private $cdescripcion;
	private $nid_unidadmedida;
	private $nid_um_hasta;
	private $nfactor_multiplicador;
	private $nfactor_divisor;
	private $dfecha_desactivacion; 
	private $estatusconversion; 
	private $pgsql; 
	 
	public function __construct(){
		$this->cid_articulo=null;
		$this->cdescripcion=null;
		$this->nid_um_conversion=null;
		$this->nid_unidadmedida=null;
		$this->nid_um_hasta=null;
		$this->nfactor_multiplicador=null;
		$this->nfactor_divisor=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_um_conversion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_um_conversion;

		if($Num_Parametro>0){
			$this->nid_um_conversion=func_get_arg(0);
		}
    }
    public function cid_articulo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cid_articulo;

		if($Num_Parametro>0){
			$this->cid_articulo=func_get_arg(0);
		}
    }
    public function cdescripcion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cdescripcion;

		if($Num_Parametro>0){
			$this->cdescripcion=func_get_arg(0);
		}
    }
    public function nid_unidadmedida(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_unidadmedida;

		if($Num_Parametro>0){
			$this->nid_unidadmedida=func_get_arg(0);
		}
    }
    public function nid_um_hasta(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_um_hasta;

		if($Num_Parametro>0){
			$this->nid_um_hasta=func_get_arg(0);
		}
    }
    public function nfactor_multiplicador(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nfactor_multiplicador;

		if($Num_Parametro>0){
			$this->nfactor_multiplicador=func_get_arg(0);
		}
    }
    public function nfactor_divisor(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nfactor_divisor;

		if($Num_Parametro>0){
			$this->nfactor_divisor=func_get_arg(0);
		}
    }
    public function estatusconversion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatusconversion;

		if($Num_Parametro>0){
			$this->estatusconversion=func_get_arg(0);
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
	    $sql="INSERT INTO inventario.tum_conversion (cid_articulo,nid_um_desde,nid_um_hasta,nfactor_multiplicador,nfactor_divisor,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cid_articulo','$this->nid_unidadmedida','$this->nid_um_hasta','$this->nfactor_multiplicador','$this->nfactor_divisor',NOW(),'$user',NOW(),'$user')";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE inventario.tum_conversion SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_um_conversion='$this->nid_um_conversion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
	    $sql="UPDATE inventario.tum_conversion SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_um_conversion='$this->nid_um_conversion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE inventario.tum_conversion SET cid_articulo='$this->cid_articulo',nid_um_desde='$this->nid_unidadmedida',nid_um_hasta='$this->nid_um_hasta',nfactor_multiplicador='$this->nfactor_multiplicador',nfactor_divisor='$this->nfactor_divisor',dmodificado_desde=NOW(), 
	    cmodificado_por='$user' WHERE nid_um_conversion='$this->nid_um_conversion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT TRIM(umc.cid_articulo) cid_articulo,a.cdescripcion,umc.nid_um_conversion,umc.nid_um_desde,umc.nid_um_hasta
	    ,umc.nfactor_multiplicador,umc.nfactor_divisor,umc.dfecha_desactivacion,
	    (CASE WHEN umc.dfecha_desactivacion IS NULL THEN 'Activo' ELSE 'Desactivado' END) AS estatusconversion 
	    FROM inventario.tum_conversion umc 
	    INNER JOIN inventario.tarticulo a ON umc.cid_articulo = a.cid_articulo 
		WHERE umc.cid_articulo='$this->cid_articulo' and umc.nid_um_desde='$this->nid_unidadmedida' AND nid_um_hasta='$this->nid_um_hasta'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$conversion=$this->pgsql->Respuesta($query);
			$this->nid_um_conversion($conversion['nid_um_conversion']);
			$this->cid_articulo($conversion['cid_articulo']);
			$this->cdescripcion($conversion['cdescripcion']);
			$this->nid_unidadmedida($conversion['nid_um_desde']);
			$this->nid_um_hasta($conversion['nid_um_hasta']);
			$this->nfactor_multiplicador($conversion['nfactor_multiplicador']);
			$this->nfactor_divisor($conversion['nfactor_divisor']);
		   	$this->estatusconversion($conversion['estatusconversion']);
			$this->dfecha_desactivacion($conversion['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM inventario.tum_conversion WHERE cid_articulo='$this->cid_articulo' 
	    AND nid_um_desde='$this->nid_unidadmedida' AND nid_um_hasta='$this->nid_um_hasta'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$conversion=$this->pgsql->Respuesta($query);
			$this->nid_um_conversion($conversion['nid_um_conversion']);
			$this->cid_articulo($conversion['cid_articulo']);
			$this->nid_unidadmedida($conversion['nid_um_desde']);
			$this->nid_um_hasta($conversion['nid_um_hasta']);
			$this->nfactor_multiplicador($conversion['nfactor_multiplicador']);
			$this->nfactor_divisor($conversion['nfactor_divisor']);
			$this->dfecha_desactivacion($conversion['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>