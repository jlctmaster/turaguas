<?php
 require_once("class_bd.php");
 class Formularios
 {
     private $nid_formulario; 
     private $cnombreformulario; 
     private $nid_modulo;
     private $curl;
     private $norden;
     private $estatus_formularios;
     private $dfecha_desactivacion; 
     private $pgsql; 
	 
   public function __construct(){
     $this->cnombreformulario=null;
     $this->nid_formulario=null;
     $this->nid_modulo=null;
     $this->curl=null;
	 $this->pgsql=new Conexion();
   }
   
 public function __destruct(){}

 public function Transaccion($value){
	 if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
	 if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
	 if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	 }

   public function nid_formulario(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_formulario;
     
	 if($Num_Parametro>0){
	   $this->nid_formulario=func_get_arg(0);
	 }
   }
   public function estatus_formularios(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->estatus_formularios;
     
	 if($Num_Parametro>0){
	   $this->estatus_formularios=func_get_arg(0);
	 }
   }
   
   public function cnombreformulario(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cnombreformulario;
     
	 if($Num_Parametro>0){
	   $this->cnombreformulario=func_get_arg(0);
	 }
   }

   public function nid_modulo(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_modulo;
     
	 if($Num_Parametro>0){
	   $this->nid_modulo=func_get_arg(0);
	 }
   }

   public function curl(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->curl;
     
	 if($Num_Parametro>0){
	   $this->curl=func_get_arg(0);
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
    $sql="INSERT INTO seguridad.tformulario (cnombreformulario,nid_modulo,curl,norden,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
    ('$this->cnombreformulario','$this->nid_modulo','$this->curl','$this->norden',NOW(),'$user',NOW(),'$user');";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }
   
     public function Activar($user){
    $sql="UPDATE seguridad.tformulario SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),cmodificado_por='$user' WHERE (nid_formulario='$this->nid_formulario');";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }
    public function Desactivar($user){
    $sqlx="SELECT * FROM seguidad.tformulario form WHERE form.nid_formulario = '$this->nid_formulario' AND EXISTS 
    (SELECT 1 FROM seguridad.tservicio serv WHERE form.nid_formulario = serv.nid_formulario)";
    $sql="UPDATE seguridad.tformulario SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),cmodificado_por='$user' WHERE (nid_formulario='$this->nid_formulario');";
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
    $sql="UPDATE seguridad.tformulario SET cnombreformulario='$this->cnombreformulario',nid_modulo='$this->nid_modulo',curl='$this->curl',norden='$this->norden',dmodificado_desde=NOW(),cmodificado_por='$user' 
    WHERE (nid_formulario='$this->nid_formulario');";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }
   
   public function Consultar(){
    $sql="SELECT *,
    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
    	ELSE 'Desactivado' END) AS estatus_formularios FROM seguridad.tformulario WHERE cnombreformulario='$this->cnombreformulario'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$formulario=$this->pgsql->Respuesta($query);
	$this->nid_formulario($formulario['nid_formulario']);
	$this->cnombreformulario($formulario['cnombreformulario']);
	$this->estatus_formularios($formulario['estatus_formularios']);
	$this->nid_modulo($formulario['nid_modulo']);
	$this->curl($formulario['curl']);
	$this->norden($formulario['norden']);
	$this->dfecha_desactivacion($formulario['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
   public function Comprobar(){
    $sql="SELECT * FROM seguridad.tformulario WHERE cnombreformulario='$this->cnombreformulario'";
	$query=$this->pgsql->Ejecutar($sql);
    if($this->pgsql->Total_Filas($query)!=0){
	$formulario=$this->pgsql->Respuesta($query);
	$this->nid_formulario($formulario['nid_formulario']);
	$this->cnombreformulario($formulario['cnombreformulario']);
	$this->nid_modulo($formulario['nid_modulo']);
	$this->curl($formulario['curl']);
	$this->norden($formulario['norden']);
	$this->dfecha_desactivacion($formulario['dfecha_desactivacion']);
	return true;
	}
	else{
	return false;
	}
   }
}
?>