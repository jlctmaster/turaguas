<?php
 require_once("class_bd.php");
 class Modulo
 {
     private $nid_modulo; 
     private $cnombremodulo; 
     private $cicono; 
     private $norden; 
     private $estatus_modulo;
     private $dfecha_desactivacion; 
     private $pgsql; 
	 
   public function __construct(){
     $this->cnombremodulo=null;
     $this->nid_modulo=null;
     $this->cicono=null;
     $this->norden=null;
	 $this->pgsql=new Conexion();
   }
   
 public function __destruct(){}

 public function Transaccion($value){
	 if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
	 if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
	 if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	 }

   public function nid_modulo(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_modulo;
     
	 if($Num_Parametro>0){
	   $this->nid_modulo=func_get_arg(0);
	 }
   }
   
   public function estatus_modulo(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->estatus_modulo;
     
	 if($Num_Parametro>0){
	   $this->estatus_modulo=func_get_arg(0);
	 }
   }

   public function cnombremodulo(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cnombremodulo;
     
	 if($Num_Parametro>0){
	   $this->cnombremodulo=func_get_arg(0);
	 }
   }

   public function cicono(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cicono;
     
	 if($Num_Parametro>0){
	   $this->cicono=func_get_arg(0);
	 }
   }

   public function norden(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->norden;
     
	 if($Num_Parametro>0){
	   $this->norden=func_get_arg(0);
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
	    $sql="INSERT INTO seguridad.tmodulo (cnombremodulo,cicono,norden,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cnombremodulo','$this->cicono','$this->norden',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   public function Activar($user){
	    $sql="UPDATE seguridad.tmodulo SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_modulo='$this->nid_modulo'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   public function Desactivar($user){
   		$sqlx="SELECT * FROM seguridad.tmodulo mod WHERE mod.nid_modulo = '$this->nid_modulo' AND EXISTS 
   		(SELECT 1 FROM seguridad.tformulario form WHERE mod.nid_modulo = form.nid_modulo)";
	    $sql="UPDATE seguridad.tmodulo SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_modulo='$this->nid_modulo'";
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
	    $sql="UPDATE seguridad.tmodulo SET cnombremodulo='$this->cnombremodulo',cicono='$this->cicono',norden='$this->norden',
	    dmodificado_desde=NOW(),cmodificado_por='$user' WHERE nid_modulo='$this->nid_modulo'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   public function Consultar(){
	    $sql="SELECT *,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
	    	ELSE 'Desactivado' END) AS estatus_modulo FROM seguridad.tmodulo 
		WHERE cnombremodulo='$this->cnombremodulo'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tmodulo=$this->pgsql->Respuesta($query);
			$this->nid_modulo($tmodulo['nid_modulo']);
			$this->cnombremodulo($tmodulo['cnombremodulo']);
			$this->cicono($tmodulo['cicono']);
			$this->norden($tmodulo['norden']);
			$this->estatus_modulo($tmodulo['estatus_modulo']);
			$this->dfecha_desactivacion($tmodulo['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
   public function Comprobar(){
	    $sql="SELECT * FROM seguridad.tmodulo WHERE cnombremodulo='$this->cnombremodulo'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tmodulo=$this->pgsql->Respuesta($query);
			$this->nid_modulo($tmodulo['nid_modulo']);
			$this->cnombremodulo($tmodulo['cnombremodulo']);
			$this->cicono($tmodulo['cicono']);
			$this->norden($tmodulo['norden']);
			$this->dfecha_desactivacion($tmodulo['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>