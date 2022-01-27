<?php
    /**
	 * Retorna el resultado de comparar una expresión regular con una cadena
	 *  
	 * @param string cadena que se va a comparar
	 * @return array $info_libros con todos los libros
	 * @return int 1 si se encuentra una coincidencia, 0 si no se encuentran coincidencias 
     * y falso si se produce un error
	 */
function es_texto($cadena){
    $patron = '/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s,.]+$/';
    return (preg_match($patron, $cadena));
}
?>