<?php
   require_once("class_bd.php");
class Usuario{
     private $cnombreusuario;
     private $ccontrasena;
     private $ccedula;
     private $nid_perfil;
     private $pregunta1;
     private $respuesta1;
     private $pregunta2;
     private $respuesta2;
     private $pregunta3;
     private $respuesta3;

	function __construct(){
		$this->pgsql=new Conexion();
	}

	public function cnombreusuario(){
	$Num_Parametro=func_num_args();
	if($Num_Parametro==0) return $this->cnombreusuario;

	if($Num_Parametro>0){
		$this->cnombreusuario=func_get_arg(0);
	}
	}

	public function ccontrasena(){
	$Num_Parametro=func_num_args();
	if($Num_Parametro==0) return  $this->ccontrasena;

	if($Num_Parametro>0){
		$this->ccontrasena=sha1(md5(func_get_arg(0)));
	}
	}
	public function ccedula(){
	$Num_Parametro=func_num_args();
	if($Num_Parametro==0) return $this->ccedula;

	if($Num_Parametro>0){
		$this->ccedula=func_get_arg(0);
	}
	}
	public function nid_perfil(){
	$Num_Parametro=func_num_args();
	if($Num_Parametro==0) return $this->nid_perfil;

	if($Num_Parametro>0){
		$this->nid_perfil=func_get_arg(0);
	}
	}

	public function Cambiar_Clave($user){
		$sqlx="UPDATE seguridad.tcontrasena SET nestado=0,dmodificado_desde=NOW(),cmodificado_por='$user' WHERE cnombreusuario='$this->cnombreusuario'";
		if($this->pgsql->Ejecutar($sqlx)!=null){
			$sql="INSERT INTO seguridad.tcontrasena (ccontrasena,cnombreusuario,nestado,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
			('$this->ccontrasena','$this->cnombreusuario',1,NOW(),'$user',NOW(),'$user')";
			if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
	}

	public function Buscar_ultimas_3_clave(){
	    $sql="SELECT ccontrasena FROM seguridad.tcontrasena 
	    WHERE cnombreusuario='$this->cnombreusuario' 
	    ORDER BY dmodificado_desde DESC LIMIT 3";
	   	$ABC=false;
		$query=$this->pgsql->Ejecutar($sql);
	   	while($a=$this->pgsql->Respuesta($query)){
		    if($a['ccontrasena']==$this->ccontrasena)
		        $ABC=true;
	    }
	    return $ABC;  
	 }

    public function Actualizar($user,$pold,$pnew,$rnew){
    	$con=0;
    	for($i=0;$i<count($pnew);$i++){
			$sql1="UPDATE seguridad.trespuesta_secreta SET cpregunta = '".$pnew[$i]."',
			crespuesta =  '".$rnew[$i]."',dmodificado_desde = NOW(),cmodificado_por = '$user' 
			WHERE cnombreusuario='$this->cnombreusuario' AND cpregunta = '".$pold[$i]."'";
			if($this->pgsql->Ejecutar($sql1)!=null)
				$con++;
			else
				$con--;
    	}
    	if($con==count($pnew))
    		return true;
    	else
    		return false;
	}
   
	public function Registrar($user){
		$sqlx="INSERT INTO seguridad.tusuario (ccedula,cnombreusuario,nid_perfil,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
		('$this->ccedula','$this->cnombreusuario','$this->nid_perfil',NOW(),'$user',NOW(),'$user')";
		if($this->pgsql->Ejecutar($sqlx)!=null){
			$this->ccontrasena("123456");
			$sql="INSERT INTO seguridad.tcontrasena (nestado,cnombreusuario,ccontrasena,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
			(3,'$this->cnombreusuario','$this->ccontrasena',NOW(),'$user',NOW(),'$user')";
			$this->pgsql->Ejecutar($sql);
				return true;
		}
		else
			return false;
	}

	public function Intento_Fallido($bool){
		if($bool==true){
			$sql="UPDATE seguridad.tusuario SET nintentos_fallidos=(nintentos_fallidos+1),dmodificado_desde=NOW(),cmodificado_por='$this->cnombreusuario' WHERE cnombreusuario='$this->cnombreusuario'";
		}else{ 
			$sql="UPDATE seguridad.tusuario SET nintentos_fallidos=0,dmodificado_desde=NOW(),cmodificado_por='$this->cnombreusuario' WHERE cnombreusuario='$this->cnombreusuario'";
		}
		if($this->pgsql->Ejecutar($sql)!=null){
			return true;
		}else
			return false;
	}

	public function Bloquear_Usuario(){
		$sql="SELECT u.nintentos_fallidos FROM seguridad.tusuario u 
		INNER JOIN seguridad.tperfil p ON u.nid_perfil = p.nid_perfil 
		INNER JOIN seguridad.tconfiguracion c ON p.nid_configuracion = c.nid_configuracion 
		WHERE u.cnombreusuario='$this->cnombreusuario' AND u.nintentos_fallidos >= c.nintentos_fallidos";
		$sql_action="UPDATE seguridad.tcontrasena set nestado=4,dmodificado_desde=NOW(),cmodificado_por='$this->cnombreusuario' where cnombreusuario='$this->cnombreusuario' and nestado=1";
		$query=$this->pgsql->Ejecutar($sql);
		if($this->pgsql->Total_Filas($query)>0){
			$query=$this->pgsql->Ejecutar($sql_action);
			return true;
		}
		else{
			return false;
		}
	}

	public function DesbloquearUsuario(){
		$sql="UPDATE seguridad.tcontrasena SET nestado=1 WHERE cnombreusuario='$this->cnombreusuario' AND nestado = 4";
		if($this->pgsql->Ejecutar($sql)!=null){
			return true;
		}else
			return false;
	}

	public function Buscar(){
    $sql="SELECT nestado AS estado,p.cnombre AS fullname_user, 
    (CASE WHEN (NOW() - CAST(conf.ndias_vigenciaclave || ' DAY' AS INTERVAL)) < pas.dmodificado_desde THEN '0' ELSE '1' END) AS caducidad,    
    pf.cnombreperfil AS perfil,pf.nid_perfil AS codigo_perfil, 
	u.cnombreusuario AS name, pas.ccontrasena AS contrasena, 
	u.ccedula AS cedula,
	rs.cpregunta AS preguntas,
	rs.crespuesta AS respuestas,
    conf.ndias_aviso,
    conf.nnumero_preguntas,
    conf.nnumero_respuestasaresponder 
	FROM general.tpersona AS p 
	INNER JOIN seguridad.tusuario AS u ON u.ccedula = p.crif_persona
	INNER JOIN seguridad.tperfil AS pf ON pf.nid_perfil = u.nid_perfil 
	INNER JOIN seguridad.tconfiguracion AS conf ON pf.nid_configuracion = conf.nid_configuracion 
	INNER JOIN seguridad.tcontrasena AS pas ON pas.cnombreusuario=u.cnombreusuario
	LEFT JOIN seguridad.trespuesta_secreta AS rs ON u.cnombreusuario = rs.cnombreusuario 
	WHERE u.cnombreusuario='$this->cnombreusuario' 
	AND pas.ccontrasena='$this->ccontrasena' AND pas.nestado<>0 AND u.dfecha_desactivacion IS NULL ORDER BY pas.dmodificado_desde DESC";
	$query=$this->pgsql->Ejecutar($sql);
	while($Obj[]=$this->pgsql->Respuesta_assoc($query))
		$rows=$Obj;
	if(!empty($rows))
   		return $rows;
	else
	   return null;
	}

	public function Generar_NombreUsuario($cedula,$perfil){
		$sql="SELECT CONCAT(SUBSTRING(cnombreperfil,1,4),'-','$cedula') nombreusuario FROM seguridad.tperfil WHERE nid_perfil = '$perfil'";
		$query = $this->pgsql->Ejecutar($sql);
		if($Obj=$this->pgsql->Respuesta($query)){
			return $Obj['nombreusuario'];
		}
		else return false;
	}

	public function Consultar_personal(){
	$sql="SELECT * FROM general.tpersona p 
	INNER JOIN general.trol r ON p.nid_rol = r.nid_rol 
	WHERE crif_persona='$this->ccedula'";
	$query=$this->pgsql->Ejecutar($sql);
	if($this->pgsql->Total_Filas($query)>0)
		return true;
	else
		return false;
}

	public function Buscar_1(){
	$sql="SELECT p.cnombre as fullname_user,
	u.nid_perfil,
	pf.cnombreperfil AS perfil, 
	u.cnombreusuario AS name,
	c.ccontrasena AS password,
	u.ccedula as ccedula,
	rs.cpregunta as preguntas,
	rs.crespuesta as respuestas,
	c.nestado as estado_clave,
    conf.nnumero_preguntas,
    conf.nnumero_respuestasaresponder 
	FROM general.tpersona AS p 
	INNER JOIN seguridad.tusuario AS u ON u.ccedula = p.crif_persona
	INNER JOIN seguridad.tcontrasena c ON u.cnombreusuario = c.cnombreusuario AND c.nestado <> 0
	INNER JOIN seguridad.tperfil AS pf ON pf.nid_perfil = u.nid_perfil 
	INNER JOIN seguridad.tconfiguracion AS conf ON pf.nid_configuracion = conf.nid_configuracion 
	LEFT JOIN seguridad.trespuesta_secreta rs ON u.cnombreusuario = rs.cnombreusuario 
	WHERE u.cnombreusuario='$this->cnombreusuario' and u.dfecha_desactivacion IS NULL
	ORDER BY RANDOM()";
	$query=$this->pgsql->Ejecutar($sql);
	while($Obj[]=$this->pgsql->Respuesta_assoc($query))
		$rows=$Obj;
	if(!empty($rows))
   		return $rows;
	else
	   return null;
	}

	public function CompletarDatos($user,$pnew,$rnew){
    	$con=0;
    	for($i=0;$i<count($pnew);$i++){
			$sql1="INSERT INTO seguridad.trespuesta_secreta (cnombreusuario,cpregunta,crespuesta,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por)
			VALUES ('$this->cnombreusuario','".$pnew[$i]."','".$rnew[$i]."',NOW(),'$user',NOW(),'$user')";
			if($this->pgsql->Ejecutar($sql1)!=null)
				$con++;
			else
				$con--;
    	}
    	if($con==count($pnew))
    		return true;
    	else
    		return false;
	}

}
?>