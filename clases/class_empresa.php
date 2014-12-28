<?php
 require_once("class_bd.php");
 class Empresa
 {
     private $crif_empresa; 
     private $cnombre_empresa; 
     private $ctlf_empresa; 
     private $cemail_empresa; 
     private $cclave_email_empresa; 
     private $nid_localidad; 
     private $cdireccion_empresa;
     private $cmision; 
     private $cvision; 
     private $cobjetivo; 
     private $chistoria;
     private $pgsql; 
	 
   public function __construct(){
     $this->cnombre_empresa=null;
     $this->crif_empresa=null;
     $this->ctlf_empresa=null;
     $this->cemail_empresa=null;
     $this->cclave_email_empresa=null;
     $this->nid_localidad=null;
     $this->cdireccion_empresa=null;
     $this->cmision=null;
     $this->cvision=null;
     $this->cobjetivo=null;
     $this->chistoria=null;
	 $this->pgsql=new Conexion();
   }
   
 public function __destruct(){}

 public function Transaccion($value){
	 if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
	 if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
	 if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	 }

   public function crif_empresa(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->crif_empresa;
     
	 if($Num_Parametro>0){
	   $this->crif_empresa=func_get_arg(0);
	 }
   }

   public function cnombre_empresa(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cnombre_empresa;
     
	 if($Num_Parametro>0){
	   $this->cnombre_empresa=func_get_arg(0);
	 }
   }

   public function ctlf_empresa(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->ctlf_empresa;
     
	 if($Num_Parametro>0){
	   $this->ctlf_empresa=func_get_arg(0);
	 }
   }
   
   public function cemail_empresa(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cemail_empresa;
     
	 if($Num_Parametro>0){
	   $this->cemail_empresa=func_get_arg(0);
	 }
   }
   
   public function cclave_email_empresa(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cclave_email_empresa;
     
	 if($Num_Parametro>0){
	   $this->cclave_email_empresa=func_get_arg(0);
	 }
   }
   
   public function nid_localidad(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_localidad;
     
	 if($Num_Parametro>0){
	   $this->nid_localidad=func_get_arg(0);
	 }
   }
   
   public function cdireccion_empresa(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cdireccion_empresa;
     
	 if($Num_Parametro>0){
	   $this->cdireccion_empresa=func_get_arg(0);
	 }
   }
   
   public function cmision(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cmision;
     
	 if($Num_Parametro>0){
	   $this->cmision=func_get_arg(0);
	 }
   }
   
   public function cvision(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cvision;
     
	 if($Num_Parametro>0){
	   $this->cvision=func_get_arg(0);
	 }
   }
   
   public function cobjetivo(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cobjetivo;
     
	 if($Num_Parametro>0){
	   $this->cobjetivo=func_get_arg(0);
	 }
   }
   
   public function chistoria(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->chistoria;
     
	 if($Num_Parametro>0){
	   $this->chistoria=func_get_arg(0);
	 }
   }

    public function Actualizar(){
	    $sql="UPDATE seguridad.tsistema SET crif_empresa='$this->crif_empresa',cnombre_empresa='$this->cnombre_empresa',
	    ctlf_empresa='$this->ctlf_empresa',cemail_empresa='$this->cemail_empresa',cclave_email_empresa='$this->cclave_email_empresa',
	    nid_localidad='$this->nid_localidad',cdireccion_empresa='$this->cdireccion_empresa',cmision='$this->cmision',
	    cvision='$this->cvision',cobjetivo='$this->cobjetivo',chistoria='$this->chistoria'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
}
?>