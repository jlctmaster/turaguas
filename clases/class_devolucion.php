<?php
require_once("class_bd.php");
class Devolucion{
	private $nid_devolucion;
	private $nid_documento;
	private $nnro_devolucion; 
	private $nid_tipodocumento;
	private $dfecha_devolucion; 
	private $cestado_devolucion; 
	private $caccion_devolucion; 
	private $dfecha_desactivacion; 
	private $estatus_devolucion; 
	private $pgsql; 
	 
	public function __construct(){
		$this->nid_devolucion=null;
		$this->nid_documento=null;
		$this->nnro_devolucion=null;
		$this->nid_tipodocumento=null;
		$this->dfecha_devolucion=null;
		$this->cestado_devolucion=null;
		$this->caccion_devolucion=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_devolucion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_devolucion;

		if($Num_Parametro>0){
			$this->nid_devolucion=func_get_arg(0);
		}
    }

    public function nid_documento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_documento;

		if($Num_Parametro>0){
			$this->nid_documento=func_get_arg(0);
		}
    }
   
    public function nnro_devolucion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nnro_devolucion;
     
		if($Num_Parametro>0){
	   		$this->nnro_devolucion=func_get_arg(0);
	 	}
    }

    public function nid_tipodocumento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_tipodocumento;

		if($Num_Parametro>0){
			$this->nid_tipodocumento=func_get_arg(0);
		}
    }
   
    public function dfecha_devolucion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->dfecha_devolucion;
     
		if($Num_Parametro>0){
	   		$this->dfecha_devolucion=func_get_arg(0);
	 	}
    }

    public function cestado_devolucion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cestado_devolucion;

		if($Num_Parametro>0){
			$this->cestado_devolucion=func_get_arg(0);
		}
    }
   
    public function caccion_devolucion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->caccion_devolucion;
     
		if($Num_Parametro>0){
	   		$this->caccion_devolucion=func_get_arg(0);
	 	}
    }
   
    public function estatus_devolucion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_devolucion;

		if($Num_Parametro>0){
			$this->estatus_devolucion=func_get_arg(0);
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
	    $sql="INSERT INTO facturacion.tdevolucion (nnro_devolucion,nid_tipodocumento,dfecha_devolucion,nid_documento,
	    cestado_devolucion,caccion_devolucion,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->nnro_devolucion','$this->nid_tipodocumento','$this->dfecha_devolucion','$this->nid_documento',
	    '$this->cestado_devolucion','$this->caccion_devolucion',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE facturacion.tdevolucion SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_devolucion='$this->nid_devolucion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM facturacion.tdevolucion WHERE cestado_devolucion <> 'DR' AND nid_devolucion = '$this->nid_devolucion'";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)!=0){
		    $sql="UPDATE facturacion.tdevolucion SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
		    cmodificado_por='$user' WHERE nid_devolucion='$this->nid_devolucion'";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE facturacion.tdevolucion SET nnro_devolucion='$this->nnro_devolucion',nid_tipodocumento='$this->nid_tipodocumento',
	    dfecha_devolucion='$this->dfecha_devolucion',nid_documento='$this->nid_documento',dmodificado_desde=NOW(),cmodificado_por='$user' 
	    WHERE nid_devolucion='$this->nid_devolucion' AND cestado_devolucion = 'DR'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT d.nid_devolucion,d.nnro_devolucion,d.nid_tipodocumento, d.nid_documento,TO_CHAR(d.dfecha_devolucion,'DD/MM/YYYY') dfecha_devolucion,
	    d.cestado_devolucion, d.caccion_devolucion,d.dfecha_desactivacion, 
		(CASE WHEN d.dfecha_desactivacion IS NULL THEN 'Activo' ELSE 'Desactivado' END) AS estatus_devolucion
		FROM facturacion.tdevolucion d 
		LEFT JOIN facturacion.tdetalle_devolucion dd ON d.nid_devolucion = dd.nid_devolucion 
		WHERE nnro_devolucion='$this->nnro_devolucion' 
		GROUP BY d.nid_devolucion,d.nnro_devolucion,d.nid_tipodocumento,d.dfecha_devolucion,
		d.cestado_devolucion,d.caccion_devolucion,d.dfecha_desactivacion";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$devolucion=$this->pgsql->Respuesta($query);
			$this->nid_devolucion($devolucion['nid_devolucion']);
			$this->nnro_devolucion($devolucion['nnro_devolucion']);
			$this->nid_tipodocumento($devolucion['nid_tipodocumento']);
			$this->nid_documento($devolucion['nid_documento']);
			$this->dfecha_devolucion($devolucion['dfecha_devolucion']);
			$this->cestado_devolucion($devolucion['cestado_devolucion']);
			$this->caccion_devolucion($devolucion['caccion_devolucion']);
		   	$this->estatus_devolucion($devolucion['estatus_devolucion']);
			$this->dfecha_desactivacion($devolucion['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM facturacion.tdevolucion WHERE nnro_devolucion='$this->nnro_devolucion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$devolucion=$this->pgsql->Respuesta($query);
			$this->nid_devolucion($devolucion['nid_devolucion']);
			$this->nid_documento($devolucion['nid_documento']);
			$this->nnro_devolucion($devolucion['nnro_devolucion']);
			$this->nid_tipodocumento($devolucion['nid_tipodocumento']);
			$this->dfecha_devolucion($devolucion['dfecha_devolucion']);
			$this->cestado_devolucion($devolucion['cestado_devolucion']);
			$this->caccion_devolucion($devolucion['caccion_devolucion']);
			$this->dfecha_desactivacion($devolucion['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function BuscarEstatus($devolucion){
   		$sql="SELECT cestado_devolucion as estatus FROM facturacion.tdevolucion WHERE nid_devolucion = '$devolucion'";
		$query = $this->pgsql->Ejecutar($sql);
        while($Obj=$this->pgsql->Respuesta_assoc($query)){
                $rows[]=array_map("utf8_encode",$Obj);
            }
            if(!empty($rows)){
                $json = json_encode($rows);
            }
            else{
                $rows[] = array("msj" => "Error al Buscar Registros ");
                $json = json_encode($rows);
            }
        return $json;
   	}

   	public function CambiarEstatus($estatus,$devolucion,$user){
   		if($estatus=="CO"){
   			$sql="UPDATE facturacion.tdevolucion SET cestado_devolucion='$estatus',caccion_devolucion='CL',dmodificado_desde=NOW(),cmodificado_por='$user' 
   			WHERE nid_devolucion = '$devolucion'";
   			$msj="La devolución ha sido Completado con exito!";
   		}else if($estatus=="CL"){
			$sql="UPDATE facturacion.tdevolucion SET cestado_devolucion='$estatus',caccion_devolucion='--',dmodificado_desde=NOW(),cmodificado_por='$user' 
   			WHERE nid_devolucion = '$devolucion'";
   			$msj="La devolución ha sido Cerrado con exito!";
   		}else if($estatus=="VO"){
			$sql="UPDATE facturacion.tdevolucion SET cestado_devolucion='$estatus',caccion_devolucion='--',nnro_devolucion=(nnro_devolucion || '^'),dmodificado_desde=NOW(),cmodificado_por='$user' 
   			WHERE nid_devolucion = '$devolucion'";
   			$msj="La devolución ha sido Anulado con exito!";
   		}
        if($this->pgsql->Ejecutar($sql)!=null){
            $rows[] = array("msj" => $msj);
            $json = json_encode($rows);
        }
        else{
            $rows[] = array("msj" => "Error al modificar el registro");
            $json = json_encode($rows);
        }
        return $json;
   	}
}
?>
