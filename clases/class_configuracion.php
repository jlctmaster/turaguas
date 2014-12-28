<?php
 require_once("class_bd.php");
 class Configuracion
 {
     private $nid_configuracion; 
     private $cdescripcion; 
     private $nlongitud_minclave; 
     private $nlongitud_maxclave; 
     private $ncantidad_letrasmayusculas; 
     private $ncantidad_letrasminusculas; 
     private $ncantidad_caracteresespeciales; 
     private $ncantidad_numeros; 
     private $ndias_vigenciaclave; 
     private $ndias_aviso; 
     private $nintentos_fallidos; 
     private $nnumero_preguntas; 
     private $nnumero_respuestasaresponder; 
     private $estatus_configuracion;
     private $dfecha_desactivacion; 
     private $pgsql; 
	 
   public function __construct(){
     $this->nid_configuracion=null;
     $this->cdescripcion=null;
     $this->nlongitud_minclave=null;
     $this->nlongitud_maxclave=null;
     $this->ncantidad_letrasmayusculas=null;
     $this->ncantidad_letrasminusculas=null;
     $this->ncantidad_caracteresespeciales=null;
     $this->ncantidad_numeros=null;
     $this->ndias_vigenciaclave=null;
     $this->ndias_aviso=null;
     $this->nintentos_fallidos=null;
     $this->nnumero_preguntas=null;
     $this->nnumero_respuestasaresponder=null;
	 $this->pgsql=new Conexion();
   }
   
 public function __destruct(){}

 public function Transaccion($value){
	 if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
	 if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
	 if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	 }

   public function nid_configuracion(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nid_configuracion;
     
	 if($Num_Parametro>0){
	   $this->nid_configuracion=func_get_arg(0);
	 }
   }

   public function cdescripcion(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->cdescripcion;
     
	 if($Num_Parametro>0){
	   $this->cdescripcion=func_get_arg(0);
	 }
   }

   public function nlongitud_minclave(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nlongitud_minclave;
     
	 if($Num_Parametro>0){
	   $this->nlongitud_minclave=func_get_arg(0);
	 }
   }

   public function nlongitud_maxclave(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nlongitud_maxclave;
     
	 if($Num_Parametro>0){
	   $this->nlongitud_maxclave=func_get_arg(0);
	 }
   }

   public function ncantidad_letrasminusculas(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->ncantidad_letrasminusculas;
     
	 if($Num_Parametro>0){
	   $this->ncantidad_letrasminusculas=func_get_arg(0);
	 }
   }

   public function ncantidad_letrasmayusculas(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->ncantidad_letrasmayusculas;
     
	 if($Num_Parametro>0){
	   $this->ncantidad_letrasmayusculas=func_get_arg(0);
	 }
   }

   public function ncantidad_caracteresespeciales(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->ncantidad_caracteresespeciales;
     
	 if($Num_Parametro>0){
	   $this->ncantidad_caracteresespeciales=func_get_arg(0);
	 }
   }

   public function ncantidad_numeros(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->ncantidad_numeros;
     
	 if($Num_Parametro>0){
	   $this->ncantidad_numeros=func_get_arg(0);
	 }
   }

   public function ndias_vigenciaclave(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->ndias_vigenciaclave;
     
	 if($Num_Parametro>0){
	   $this->ndias_vigenciaclave=func_get_arg(0);
	 }
   }

   public function ndias_aviso(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->ndias_aviso;
     
	 if($Num_Parametro>0){
	   $this->ndias_aviso=func_get_arg(0);
	 }
   }

   public function nintentos_fallidos(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nintentos_fallidos;
     
	 if($Num_Parametro>0){
	   $this->nintentos_fallidos=func_get_arg(0);
	 }
   }

   public function nnumero_preguntas(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nnumero_preguntas;
     
	 if($Num_Parametro>0){
	   $this->nnumero_preguntas=func_get_arg(0);
	 }
   }

   public function nnumero_respuestasaresponder(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nnumero_respuestasaresponder;
     
	 if($Num_Parametro>0){
	   $this->nnumero_respuestasaresponder=func_get_arg(0);
	 }
   }
   
   public function estatus_configuracion(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->estatus_configuracion;
     
	 if($Num_Parametro>0){
	   $this->estatus_configuracion=func_get_arg(0);
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
	    $sql="INSERT INTO seguridad.tconfiguracion (cdescripcion,nlongitud_minclave,nlongitud_maxclave,ncantidad_letrasmayusculas
	    ,ncantidad_letrasminusculas,ncantidad_caracteresespeciales,ncantidad_numeros,ndias_vigenciaclave,ndias_aviso,nintentos_fallidos
	    ,nnumero_preguntas,nnumero_respuestasaresponder,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->cdescripcion','$this->nlongitud_minclave','$this->nlongitud_maxclave','$this->ncantidad_letrasmayusculas','$this->ncantidad_letrasminusculas'
	    ,'$this->ncantidad_caracteresespeciales','$this->ncantidad_numeros','$this->ndias_vigenciaclave','$this->ndias_aviso'
	    ,'$this->nintentos_fallidos','$this->nnumero_preguntas','$this->nnumero_respuestasaresponder',NOW(),'$user',NOW(),'$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   public function Activar($user){
	    $sql="UPDATE seguridad.tconfiguracion SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='$user' WHERE nid_configuracion='$this->nid_configuracion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   public function Desactivar($user){
   		$sqlx="SELECT * FROM seguridad.tconfiguracion tconfig WHERE EXISTS 
   		(SELECT 1 FROM seguridad.tperfil tper WHERE tconfig.nid_configuracion = tper.nid_configuracion) 
   		AND nid_configuracion = '$this->nid_configuracion'";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
		    $sql="UPDATE seguridad.tconfiguracion SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
		    cmodificado_por='$user' WHERE nid_configuracion='$this->nid_configuracion'";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}else
			return false;
   	}
    public function Actualizar($user){
	    $sql="UPDATE seguridad.tconfiguracion SET cdescripcion='$this->cdescripcion',nlongitud_minclave='$this->nlongitud_minclave',nlongitud_maxclave='$this->nlongitud_maxclave'
	    ,ncantidad_letrasmayusculas='$this->ncantidad_letrasmayusculas',ncantidad_letrasminusculas='$this->ncantidad_letrasminusculas',ncantidad_caracteresespeciales='$this->ncantidad_caracteresespeciales'
	    ,ncantidad_numeros='$this->ncantidad_numeros',ndias_vigenciaclave='$this->ndias_vigenciaclave',ndias_aviso='$this->ndias_aviso',nintentos_fallidos='$this->nintentos_fallidos'
	    ,nnumero_preguntas='$this->nnumero_preguntas',nnumero_respuestasaresponder='$this->nnumero_respuestasaresponder',dmodificado_desde=NOW(),cmodificado_por='$user' 
	    WHERE nid_configuracion='$this->nid_configuracion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   public function Consultar(){
	    $sql="SELECT *,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
	    	ELSE 'Desactivado' END) AS estatus_configuracion FROM seguridad.tconfiguracion 
		WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tconfiguracion=$this->pgsql->Respuesta($query);
			$this->nid_configuracion($tconfiguracion['nid_configuracion']);
			$this->cdescripcion($tconfiguracion['cdescripcion']);
			$this->nlongitud_minclave($tconfiguracion['nlongitud_minclave']);
			$this->nlongitud_maxclave($tconfiguracion['nlongitud_maxclave']);
			$this->ncantidad_letrasminusculas($tconfiguracion['ncantidad_letrasminusculas']);
			$this->ncantidad_letrasmayusculas($tconfiguracion['ncantidad_letrasmayusculas']);
			$this->ncantidad_caracteresespeciales($tconfiguracion['ncantidad_caracteresespeciales']);
			$this->ncantidad_numeros($tconfiguracion['ncantidad_numeros']);
			$this->ndias_vigenciaclave($tconfiguracion['ndias_vigenciaclave']);
			$this->ndias_aviso($tconfiguracion['ndias_aviso']);
			$this->nintentos_fallidos($tconfiguracion['nintentos_fallidos']);
			$this->nnumero_preguntas($tconfiguracion['nnumero_preguntas']);
			$this->nnumero_respuestasaresponder($tconfiguracion['nnumero_respuestasaresponder']);
			$this->estatus_configuracion($tconfiguracion['estatus_configuracion']);
			$this->dfecha_desactivacion($tconfiguracion['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
   public function Comprobar(){
	    $sql="SELECT * FROM seguridad.tconfiguracion WHERE cdescripcion='$this->cdescripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tconfiguracion=$this->pgsql->Respuesta($query);
			$this->nid_configuracion($tconfiguracion['nid_configuracion']);
			$this->cdescripcion($tconfiguracion['cdescripcion']);
			$this->nlongitud_minclave($tconfiguracion['nlongitud_minclave']);
			$this->nlongitud_maxclave($tconfiguracion['nlongitud_maxclave']);
			$this->ncantidad_letrasminusculas($tconfiguracion['ncantidad_letrasminusculas']);
			$this->ncantidad_letrasmayusculas($tconfiguracion['ncantidad_letrasmayusculas']);
			$this->ncantidad_caracteresespeciales($tconfiguracion['ncantidad_caracteresespeciales']);
			$this->ncantidad_numeros($tconfiguracion['ncantidad_numeros']);
			$this->ndias_vigenciaclave($tconfiguracion['ndias_vigenciaclave']);
			$this->ndias_aviso($tconfiguracion['ndias_aviso']);
			$this->nintentos_fallidos($tconfiguracion['nintentos_fallidos']);
			$this->nnumero_preguntas($tconfiguracion['nnumero_preguntas']);
			$this->nnumero_respuestasaresponder($tconfiguracion['nnumero_respuestasaresponder']);
			$this->dfecha_desactivacion($tconfiguracion['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>