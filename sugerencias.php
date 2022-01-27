<?php
require "validaciones.php";
  /**
	 * Establece la conexión con la base de datos y comprueba que se ha establecido correctamente.
   * 
	 * @param string $servidor nombre del servidor donde se aloja la BD
	 * @param string $usuario nombre del usuario con permisos sobre la BD
   * @param string $contrasena constraseña del usuario
   * @param string $bd nombre de la base de datos
	 * @return object $conexion devuelve un objeto que representa la conexión con la BD
	 * @return null si la conexión no se ha podido establecer correctamente
   */
function conexion($servidor, $usuario, $contrasena, $bd)
{
    @$conexion = new mysqli($servidor, $usuario, $contrasena, $bd);
    if (!$conexion->connect_errno) {
        $conexion->set_charset("utf8");
        return $conexion;
    } else {
        return null;
        }
}
/**
	 * Retorna un array asociativo con el nombre y apellidos de los autores almacenados en la BD
	 *  
	 * @param object objeto que representa la conexión con la BD
	 * @return array $info_libros con todos los libros
	 * @return null nulo si hay algún problema.
	 */
function get_lista_autores($conexion){
  $info_libros = array();
  $sql = "SELECT nombre, apellidos FROM autor";
  if(!$conexion){
    return null;
  }else{
    $consulta = $conexion->query($sql);
    if($consulta->num_rows > 0){
      $info_libros = $consulta->fetch_all(MYSQLI_ASSOC);
      return $info_libros;
    }
  }
}
  /**
	 * Retorna un array asociativo con el titulo de los libros cuyo autor es el que se pasa por parámetro
	 *  
	 * @param object objeto que representa la conexión con la BD
   * @param string nombre del autor
	 * @return array $info_libros con los libros especificados
	 * @return null nulo si hay algún problema.
	 */
function get_lista_libros($conexion, $nombre){
    $info_libros = array();
    $sql = "SELECT l.titulo FROM autor a 
    INNER JOIN libro l ON (a.id = l.id_autor) where nombre = '$nombre'";
    if(!$conexion){
      return null;
    }else{
      $consulta = $conexion->query($sql);
      if($consulta->num_rows > 0){
        $info_libros = $consulta->fetch_all(MYSQLI_ASSOC);
        return $info_libros;
      }
    }
}

$conexion = conexion("servidor", "nombre", "contraseña", "nombreBD");
$autores = get_lista_autores($conexion);
sugerencias($autores, $conexion);

/**
	*Si encuentra coincidencia retorna la coincidencia 
  *y sino una frase indicando que no ha encontrado nada
	*  
  * @param object objeto que representa la conexión con la BD*
	* @param array nombre y apellidos de los autores almacenados en la BD
	* @return string $sugerencias con las sugerencias encontradas
	* @return string si no encuentra sugerencias
	*/
function sugerencias($autores, $conexion){
  $q = $_REQUEST["q"];
  $sugerencias = "";
  $au = "";
  if($q != "" && es_texto($q)){
      $q = strtolower($q);
      $len = strlen($q);
      foreach($autores as $autor){
          if(stristr($q, substr($autor["nombre"], 0, $len))){
            $sugerencias .= "<br>".$autor["nombre"]. " " . $autor["apellidos"] . " =>";
            $au = $autor["nombre"];
            $libros = get_lista_libros($conexion, $au);
            foreach($libros as $libro){
              $sugerencias .= " | ". $libro["titulo"];
            }
          }
      }
      echo $sugerencias === "" ? "no se encuentran sugerencias" : $sugerencias;
  }
  
}

