<?php
require_once("conf.php");
require_once("dato_system.php");
/*Esta es la clase que permite  la coneccion con la base de datos*/
class Conexion{
           private $conexion;
           private $clave;
           private $usuario;
           private $servidor;
           private $puerto;
           private $basedato;
//Constructor de la clase 
function __construct(){
    $this->clave=PASSWORD;
    $this->usuario=USER;
    $this->servidor=SERVER;
    $this->puerto=PORT;
    $this->basedato=BD;
	$this->conexion=pg_connect("host=$this->servidor port=$this->puerto user=$this->usuario password=$this->clave dbname=$this->basedato") 
	or die('No pudo conectarse: ' . pg_last_error(pg_connect("host=$this->servidor port=$this->puerto user=$this->usuario password=$this->clave dbname=$this->basedato")));
	}
	
    //Este es para traer la consulta a la base de datos como insertar,modificar  etc...
   public function Ejecutar($sql){
    // echo "<br>".$sql."<br>";
   	//pg_query("SET CHARACTER SET utf8");
	$cso=getOs();
	$sistema=getBrowser();
	$cip=$_SERVER['REMOTE_ADDR'];
	$cnav=$sistema['name'];
	$VARau=pg_escape_string($sql);
	@$sqlAUDITORIA="INSERT INTO seguridad.tbitacora (cip, cso, cnavegador, cusuario_base_de_datos, cquery, dfecha, cusuario_aplicacion) 
	VALUES ('$cip', '$cso', '$cnav', CURRENT_USER,'$VARau' ,NOW(), '".$_SESSION['user_name']."');";
	$cortar_texto=explode(" ",trim($sql));

    if($query=pg_query($this->conexion,$sql)){ 
    	if(strtoupper($cortar_texto[0])!="SELECT"){
        pg_query($this->conexion,$sqlAUDITORIA); 
      }
        return $query;
    }
	else return null;
   }
	   
 //el siguiente metodos se usa para informacion o los datos que vienen de la base de datos
    public function Respuesta($sql){
    return @pg_fetch_array($sql);
    }
	 public function Respuesta_assoc($sql){
    return @pg_fetch_assoc($sql);
    }
    //esta function es para saber cuantas filas trae la consulta.
    public function Total_Filas($query){
        return @pg_num_rows($query);
    }
    //Returns values from a result resource
    public function Obtener_Resultado($sql,$row,$field){
      return pg_fetch_result($sql, $row, $field);
    }
	
	 public function Liberar_Resultado($query)
      {
        return pg_free_result($query);
      }
      
      public function Incializar_Transaccion()
	  {
	     pg_query("BEGIN",$this->conexion);
	  }
	  
	  public function Finalizar_Transaccion()
	  {
	     pg_query("COMMIT",$this->conexion);
		 		 $this->Desconectar();

	  }
	  
	  public function Cancelar_Transaccion()
	  {
	     pg_query("ROLLBACK",$this->conexion);
		 $this->Desconectar();
	  }
//una vez terminar la interaccion con la bd usamos este para cerrar la coneccion    
 private function Desconectar(){ return @pg_close($this->conexion);} 
     
    }
?>