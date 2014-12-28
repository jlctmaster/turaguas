<?php
 require_once("class_bd.php");
 class Servicios
 {
     private $nid_servicio; 
     private $cnombreservicio; 
     private $nid_formulario;
     private $cnombreformulario;
     private $estatus_servicios;
     private $dfecha_desactivacion; 
     private $pgsql; 
	 
   public function __construct(){
     $this->cnombreservicio=null;
     $this->nid_servicio=null;
     $this->nid_formulario=null;
     $this->cnombreformulario=null;
	 $this->pgsql=new Conexion();
   }
   
 public function __destruct(){}

 public function Transaccion($value){
	 if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
	 if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
	 if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	 }

   public function nid_servicio(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_servicio;
     
	 if($Num_Parametro>0){
	   $this->nid_servicio=func_get_arg(0);
	 }
   }
   public function estatus_servicios(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->estatus_servicios;
     
	 if($Num_Parametro>0){
	   $this->estatus_servicios=func_get_arg(0);
	 }
   }
   
   public function cnombreservicio(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cnombreservicio;
     
	 if($Num_Parametro>0){
	   $this->cnombreservicio=func_get_arg(0);
	 }
   }

   public function nid_formulario(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_formulario;
     
	 if($Num_Parametro>0){
	   $this->nid_formulario=func_get_arg(0);
	 }
   }

   public function cnombreformulario(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cnombreformulario;
     
	 if($Num_Parametro>0){
	   $this->cnombreformulario=func_get_arg(0);
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
    $sql="INSERT INTO seguridad.tservicio (cnombreservicio,nid_formulario,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
    ('$this->cnombreservicio','$this->nid_formulario',NOW(),'$user',NOW(),'$user');";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }
   
     public function Activar($user){
    $sql="UPDATE seguridad.tservicio SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),cmodificado_por='$user' WHERE (nid_servicio='$this->nid_servicio');";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }

    public function Desactivar($user){
    $sqlx="SELECT * FROM seguridad.tservicio serv WHERE serv.nid_servicio = '$this->nid_servicio' AND EXISTS 
    (SELECT 1 FROM seguridad.tdetalleservicio_perfil_opcion dspo WHERE serv.nid_servicio = dspo.nid_servicio)";
    $sql="UPDATE seguridad.tservicio SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),cmodificado_por='$user' WHERE (nid_servicio='$this->nid_servicio');";
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
    $sql="UPDATE seguridad.tservicio SET cnombreservicio='$this->cnombreservicio',nid_formulario='$this->nid_formulario',dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE (nid_servicio='$this->nid_servicio');";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }
   
   public function Consultar(){
    $sql="SELECT s.nid_servicio,s.cnombreservicio,s.nid_formulario,s.dfecha_desactivacion,f.cnombreformulario, 
    CASE WHEN s.dfecha_desactivacion IS NULL THEN 'Activo' ELSE 'Desactivado' END AS estatus_servicios 
    FROM seguridad.tservicio s INNER JOIN seguridad.tformulario f ON s.nid_formulario = f.nid_formulario 
    WHERE cnombreservicio='$this->cnombreservicio'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$servicio=$this->pgsql->Respuesta($query);
	$this->nid_servicio($servicio['nid_servicio']);
	$this->cnombreservicio($servicio['cnombreservicio']);
	$this->nid_formulario($servicio['nid_formulario']);
	$this->cnombreformulario($servicio['cnombreformulario']);
	$this->estatus_servicios($servicio['estatus_servicios']);
	$this->dfecha_desactivacion($servicio['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   public function Comprobar(){
    $sql="SELECT * FROM seguridad.tservicio WHERE cnombreservicio='$this->cnombreservicio'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$servicio=$this->pgsql->Respuesta($query);
	$this->nid_servicio($servicio['nid_servicio']);
	$this->cnombreservicio($servicio['cnombreservicio']);
	$this->nid_formulario($servicio['nid_formulario']);
	$this->cnombreformulario($servicio['cnombreformulario']);
	$this->dfecha_desactivacion($servicio['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
}
?>