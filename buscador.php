<?php
// AUTHOR: enriqvedevnet

// Primero definimos la conexion a la base de datos
define('HOST_DB', 'localhost');  //Nombre del host, nomalmente localhost
define('USER_DB', 'root');       //Usuario de la bbdd
define('PASS_DB', 'prueba123456789');           //Contraseña de la bbdd
define('NAME_DB', 'fac-eletronic'); //Nombre de la bbdd

// Definimos la conexion
function conectar(){
	global $conexion;  //Definicion global para poder utilizar en todo el contexto
	$conexion = mysql_connect(HOST_DB, USER_DB, PASS_DB)
	or die ('NO SE HA PODIDO CONECTAR AL MOTOR DE LA BASE DE DATOS');
	mysql_select_db(NAME_DB)
	or die ('NO SE ENCUENTRA LA BASE DE DATOS ' . NAME_DB);
}
function desconectar(){
	global $conexion;
	mysql_close($conexion);
}

//Variable que contendra el resultado de la busqueda
$texto = '';
//Variable que contendra el numero de resgistros encontrados
$registros = '';

if($_POST){
	
  $busqueda = trim($_POST['buscar']);

  $entero = 0;
  
  if (empty($busqueda)){
	  $texto = 'Busqueda sin resultados';
  }else{
	  // Si hay informacion para buscar, abrimos la conexion
	  conectar();
      mysql_set_charset('utf8');  // mostramos la informacion en utf-8
	  
	  //Contulta para la base de datos, se utiliza un comparador LIKE para acceder a todo lo que contenga la cadena a buscar
	  $sql = "SELECT * FROM doc_tab WHERE doc_electro LIKE '%" .$busqueda. "%' ORDER BY doc_electro";
	  
	  $resultado = mysql_query($sql); //Ejecucion de la consulta
      //Si hay resultados...
	  if (mysql_num_rows($resultado) > 0){ 
	     // Se recoge el numero de resultados
		 $registros = '<p>HEMOS ENCONTRADO ' . mysql_num_rows($resultado) . ' registros </p>';
	     // Se almacenan las cadenas de resultado
		 while($fila = mysql_fetch_assoc($resultado)){ 
              $texto .= $fila['doc_electro'] . '<br />';
			 }
	  
	  }else{
			   $texto = "NO HAY RESULTADOS EN LA BBDD";	
	  }
	  // Cerramos la conexion (por seguridad, no dejar conexiones abiertas)
	  mysql_close($conexion);
  }
}
?>
<!DOCTYPE html>
<html lang="es-ES">
<head> 
<meta charset='utf-8'>
<head> 
<body>
<h1>Ejemplo de buscador: by <a href="https://webreunidos.es" title="Mas tutoriales en nuestra web" target="_self">webreunidos.es</a></h1> 
<form id="buscador" name="buscador" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>"> 
    <input id="buscar" name="buscar" type="search" placeholder="Buscar aqui..." autofocus >
    <input type="submit" name="buscador" class="boton peque aceptar" value="buscar">
</form>
<?php 
// Resultado, numero de registros y contenido.
echo $registros;
echo $texto; 
?>
</body>
</html>