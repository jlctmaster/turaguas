<?php
require_once("class_bd.php");
class Detalle_Documento{
	private $nid_detalledocumento;
	private $nid_documento;
	private $nnro_orden;
	private $nlinea;
	private $cid_articulo; 
	private $ncantidad_articulo; 
	private $nid_impuesto; 
	private $nid_almacen; 
	private $nprecio; 
	private $npreciolista; 
	private $npreciolimite; 
	private $ndescuento;
	private $nimpuesto; 
	private $nmontoneto;
	private $nmontoimpuesto; 
	private $nmontodescuento;
	private $nmonto_total;
	private $dfecha_documento; 
	private $pgsql; 
	 
	public function __construct(){
		$this->nid_detalledocumento=null;
		$this->nid_documento=null;
		$this->nnro_orden=null;
		$this->nlinea=null;
		$this->cid_articulo=null;
		$this->ncantidad_articulo=null;
		$this->nid_impuesto=null;
		$this->nid_almacen=null;
		$this->nprecio=null;
		$this->npreciolista=null;
		$this->npreciolimite=null;
		$this->ndescuento=null;
		$this->nimpuesto=null;
		$this->nmontoneto=null;
		$this->nmontoimpuesto=null;
		$this->nmontodescuento=null;
		$this->nmonto_total=null;
		$this->dfecha_documento=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_detalledocumento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_detalledocumento;

		if($Num_Parametro>0){
			$this->nid_detalledocumento=func_get_arg(0);
		}
    }
   
    public function nid_documento(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_documento;
     
		if($Num_Parametro>0){
	   		$this->nid_documento=func_get_arg(0);
	 	}
    }
   
    public function nnro_orden(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nnro_orden;
     
		if($Num_Parametro>0){
	   		$this->nnro_orden=func_get_arg(0);
	 	}
    }

    public function nlinea(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nlinea;

		if($Num_Parametro>0){
			$this->nlinea=func_get_arg(0);
		}
    }
   
    public function cid_articulo(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cid_articulo;
     
		if($Num_Parametro>0){
	   		$this->cid_articulo=func_get_arg(0);
	 	}
    }

    public function ncantidad_articulo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->ncantidad_articulo;

		if($Num_Parametro>0){
			$this->ncantidad_articulo=func_get_arg(0);
		}
    }

      public function nid_impuesto(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_impuesto;
     
		if($Num_Parametro>0){
	   		$this->nid_impuesto=func_get_arg(0);
	 	}
    }

    public function nid_almacen(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_almacen;
     
		if($Num_Parametro>0){
	   		$this->nid_almacen=func_get_arg(0);
	 	}
    }
   
    public function nprecio(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nprecio;
     
		if($Num_Parametro>0){
	   		$this->nprecio=func_get_arg(0);
	 	}
    }

    public function npreciolista(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->npreciolista;

		if($Num_Parametro>0){
			$this->npreciolista=func_get_arg(0);
		}
    }
   
    public function npreciolimite(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->npreciolimite;
     
		if($Num_Parametro>0){
	   		$this->npreciolimite=func_get_arg(0);
	 	}
    }
   
    public function ndescuento(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->ndescuento;
     
		if($Num_Parametro>0){
	   		$this->ndescuento=func_get_arg(0);
	 	}
    }
   
    public function nimpuesto(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nimpuesto;
     
		if($Num_Parametro>0){
	   		$this->nimpuesto=func_get_arg(0);
	 	}
    }
   
    public function nmontoneto(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nmontoneto;
     
		if($Num_Parametro>0){
	   		$this->nmontoneto=func_get_arg(0);
	 	}
    }
   
    public function nmontoimpuesto(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nmontoimpuesto;
     
		if($Num_Parametro>0){
	   		$this->nmontoimpuesto=func_get_arg(0);
	 	}
    }
   
    public function nmontodescuento(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nmontodescuento;
     
		if($Num_Parametro>0){
	   		$this->nmontodescuento=func_get_arg(0);
	 	}
    }
   
    public function nmonto_total(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nmonto_total;
     
		if($Num_Parametro>0){
	   		$this->nmonto_total=func_get_arg(0);
	 	}
    }
  
    public function estatus(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus;

		if($Num_Parametro>0){
			$this->estatus=func_get_arg(0);
		}
    }
   
	public function dfecha_documento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->dfecha_documento;

		if($Num_Parametro>0){
			$this->dfecha_documento=func_get_arg(0);
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
   		$sqlx="UPDATE facturacion.tdocumento SET nmonto_total = nmonto_total+$this->nmonto_total,dmodificado_desde=NOW(),cmodificado_por='$user' 
   		WHERE nid_documento = '$this->nid_documento'";
   		if($this->pgsql->Ejecutar($sqlx)!=null){
   			$sql="INSERT INTO facturacion.tdetalle_documento (nid_documento,nlinea,cid_articulo,ncantidad_articulo,nid_impuesto
		    ,nprecio,npreciolista,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
		    ('$this->nid_documento','$this->nlinea','$this->cid_articulo','$this->ncantidad_articulo','$this->nid_impuesto'
		    ,'$this->nprecio','$this->npreciolista',NOW(),'$user',NOW(),'$user');";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
   		}else
   			return false;
   	}
   
    public function Actualizar($user){
    	$sqlx="UPDATE facturacion.tdocumento SET nmonto_total = nmonto_total+$this->nmonto_total,dmodificado_desde=NOW(),cmodificado_por='$user' 
   		WHERE nid_documento = '$this->nid_documento' AND cestado_documento = 'DR'";
   		if($this->pgsql->Ejecutar($sqlx)!=null){
		    $sql="UPDATE facturacion.tdetalle_documento SET cid_articulo='$this->cid_articulo',ncantidad_articulo='$this->ncantidad_articulo'
		    ,nprecio='$this->nprecio',nid_impuesto='$this->nid_impuesto' 
		    WHERE nid_documento='$this->nid_documento' AND nlinea = '$this->nlinea'";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT dd.nid_detalledocumento,d.nid_documento,TRIM(d.nnro_orden) nnro_orden,TO_CHAR(d.dfecha_documento,'DD/MM/YYYY') dfecha_documento,dd.nlinea,
	    TRIM(dd.cid_articulo) cid_articulo,dd.ncantidad_articulo,dd.nid_impuesto,dd.nprecio,dd.npreciolista,dlp.nprecio_limite,inv.nid_almacen,
	    dlp.ndescuento,i.nporcentaje nimpuesto,ROUND((dd.ncantidad_articulo*dd.nprecio),2) nmontoneto,
	    ROUND(((dd.ncantidad_articulo*dd.nprecio)*i.nporcentaje / 100),2) nmontoimpuesto,
		ROUND(((dd.ncantidad_articulo*dd.nprecio)*dlp.ndescuento / 100),2) nmontodescuento 
		FROM facturacion.tdocumento d 
		LEFT JOIN facturacion.tdetalle_documento dd ON d.nid_documento = dd.nid_documento 
		LEFT JOIN facturacion.tdetalle_lista_precio dlp ON dd.cid_articulo = dlp.cid_articulo 
		LEFT JOIN facturacion.timpuesto i ON dd.nid_impuesto = i.nid_impuesto 
		LEFT JOIN inventario.tinventario inv ON dd.cid_articulo = inv.cid_articulo 
		WHERE dd.nid_documento='$this->nid_documento' AND dd.nlinea = '$this->nlinea'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$detalle_documento=$this->pgsql->Respuesta($query);
			$this->nid_detalledocumento($detalle_documento['nid_detalledocumento']);
			$this->nid_documento($detalle_documento['nid_documento']);
			$this->nnro_orden($detalle_documento['nnro_orden']);
			$this->dfecha_documento($detalle_documento['dfecha_documento']);
			$this->nlinea($detalle_documento['nlinea']);
			$this->cid_articulo($detalle_documento['cid_articulo']);
			$this->ncantidad_articulo($detalle_documento['ncantidad_articulo']);
			$this->nid_impuesto($detalle_documento['nid_impuesto']);
			$this->nid_almacen($detalle_documento['nid_almacen']);
			$this->nprecio($detalle_documento['nprecio']);
			$this->npreciolista($detalle_documento['npreciolista']);
			$this->npreciolimite($detalle_documento['nprecio_limite']);
			$this->ndescuento($detalle_documento['ndescuento']);
		   	$this->nimpuesto($detalle_documento['nimpuesto']);
			$this->nmontoneto($detalle_documento['nmontoneto']);
		   	$this->nmontoimpuesto($detalle_documento['nmontoimpuesto']);
			$this->nmontodescuento($detalle_documento['nmontodescuento']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT dd.nid_detalledocumento,d.nid_documento,TRIM(d.nnro_orden) nnro_orden,dd.nlinea,dd.cid_articulo,dd.ncantidad_articulo, 
		dd.nid_impuesto,dd.nprecio,dd.npreciolista,dlp.nprecio_limite,dlp.ndescuento,i.nporcentaje nimpuesto,inv.nid_almacen,
		(dd.ncantidad_articulo*dd.nprecio) nmontoneto,((dd.ncantidad_articulo*dd.nprecio)*i.nporcentaje / 100) nmontoimpuesto,
		((dd.ncantidad_articulo*dd.nprecio)*dlp.ndescuento / 100) nmontodescuento,d.dfecha_desactivacion
		FROM facturacion.tdocumento d 
		LEFT JOIN facturacion.tdetalle_documento dd ON d.nid_documento = dd.nid_documento 
		LEFT JOIN facturacion.tdetalle_lista_precio dlp ON dd.cid_articulo = dlp.cid_articulo 
		LEFT JOIN facturacion.timpuesto i ON dd.nid_impuesto = i.nid_impuesto 
		LEFT JOIN inventario.tinventario inv ON dd.cid_articulo = inv.cid_articulo 
		WHERE dd.nid_documento='$this->nid_documento' AND dd.nlinea = '$this->nlinea'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$detalle_documento=$this->pgsql->Respuesta($query);
			$this->nid_detalledocumento($detalle_documento['nid_detalledocumento']);
			$this->nid_documento($detalle_documento['nid_documento']);
			$this->nnro_orden($detalle_documento['nnro_orden']);
			$this->nlinea($detalle_documento['nlinea']);
			$this->cid_articulo($detalle_documento['cid_articulo']);
			$this->ncantidad_articulo($detalle_documento['ncantidad_articulo']);
			$this->nid_impuesto($detalle_documento['nid_impuesto']);
			$this->nid_almacen($detalle_documento['nid_almacen']);
			$this->nprecio($detalle_documento['nprecio']);
			$this->npreciolista($detalle_documento['npreciolista']);
			$this->nprecio_limite($detalle_documento['nprecio_limite']);
			$this->ndescuento($detalle_documento['ndescuento']);
		   	$this->nimpuesto($detalle_documento['nimpuesto']);
			$this->nmontoneto($detalle_documento['nmontoneto']);
		   	$this->nmontoimpuesto($detalle_documento['nmontoimpuesto']);
			$this->nmontodescuento($detalle_documento['nmontodescuento']);
			$this->dfecha_desactivacion($detalle_documento['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function BuscarPrecioLista($articulo){
   		$sql="SELECT a.cid_articulo,CASE WHEN dlp.nprecio IS NULL THEN 0 ELSE dlp.nprecio END nprecio,
		CASE WHEN dlp.nprecio_limite IS NULL THEN 0 ELSE dlp.nprecio_limite END nprecio_limite,
		CASE WHEN dlp.ndescuento IS NULL THEN 0 ELSE dlp.ndescuento END ndescuento, a.nid_impuesto, i.nporcentaje 
		FROM inventario.tarticulo a 
		LEFT JOIN facturacion.tdetalle_lista_precio dlp ON a.cid_articulo = dlp.cid_articulo 
		LEFT JOIN facturacion.timpuesto i ON a.nid_impuesto = i.nid_impuesto 
		WHERE a.cid_articulo = '$articulo'";
		$query = $this->pgsql->Ejecutar($sql);
        while($Obj=$this->pgsql->Respuesta_assoc($query)){
                $rows[]=array_map("utf8_encode",$Obj);
            }
            if(!empty($rows)){
                $json = json_encode($rows);
            }
            else{
                $rows[] = array("msj" => "Error al Buscar Registros ".$sql);
                $json = json_encode($rows);
            }
        return $json;
   	}

   	public function BuscarImpuesto($impuesto){
   		$sql="SELECT nid_impuesto,nporcentaje FROM facturacion.timpuesto WHERE nid_impuesto = '$impuesto'";
		$query = $this->pgsql->Ejecutar($sql);
        while($Obj=$this->pgsql->Respuesta_assoc($query)){
                $rows[]=array_map("utf8_encode",$Obj);
            }
            if(!empty($rows)){
                $json = json_encode($rows);
            }
            else{
                $rows[] = array("msj" => "Error al Buscar Registros ".$sql);
                $json = json_encode($rows);
            }
        return $json;
   	}
}
?>
