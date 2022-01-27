<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tarea9 DWES</title>
    <style>@import url(estilo.css);</style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="script.js"></script>
    <script>
        function mostrar_sugerencias (str){
        if(str.length == 0){
            document.getElementById("sugerencias").innerHTML="";
            return;
        }else{
            var asyncRequest = new XMLHttpRequest();
            asyncRequest.onreadystatechange = cambioEstado;
            asyncRequest.open("GET", "sugerencias.php?q="+str, true);
            asyncRequest.send(null);

            function cambioEstado(){
                if(asyncRequest.readyState == 4 && asyncRequest.status == 200){
                    document.getElementById("sugerencias").innerHTML=asyncRequest.responseText;
                }
            }
        }
    }
    </script>
    <style>@import url(estilo.css);</style>
</head>
<body id="busca">
    <h1>Autores y sus libros</h1>
    <hr>
    <h2 class="titulos">Base de datos: buscador interactivo de libros</h2>
    <div id="form">
        <form id="formulario" method="GET" action="#">
            <input type="text" id="texto" onkeyup="mostrar_sugerencias(this.value);"><br>
        </form>
        <span class='error ocultar' id="error_texto">Formato incorrecto: solo se admiten letras</span>
        </div>
        <p id="sug">Sugerencias:<span id="sugerencias"></span></p>
    
    
    <hr>
    <!-- tabla autor 1 -->
    <table id="tabla" border="1">
        <h2 class="titulos">Servicio Web: Libros de programación más vistos</h2>
        <tr>
            <th>id</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Numero de páginas</th>
            <th>Año de publicación</th>
        </tr>
    <?php
    /**
     * Devuelve un array con los libros obtenidos de un servicio web
     * 
     * @return array $datos
     */
    function obtenerDatos(){
        $url = "https://www.etnassoft.com/api/v1/get/?category=libros_programacion&criteria=most_viewed";
        //inicializa curl
        $curl = curl_init();
        //se definen opciones para la sesion curl
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //ejecuta la petición HTTP
        $response = curl_exec($curl);
        //comprueba si ha ocurrido algún error durante la solicitud
        if($e = curl_error($curl)) {
            echo $e;
        } else {
            //Si todo ha ido bien decodifica los datos JSON
            $datos = json_decode($response, true); 
            //Cierra la sesión curl
            curl_close($curl);
            return $datos;
        }
    }
        
    $libros = obtenerDatos();

    foreach ($libros as $libro){
            echo "<tr>";
            echo "<td>" . $libro["ID"] . "</td>"
                ."<td>" . $libro["title"] . "</td>"
                ."<td>" . $libro["author"] . "</td>"
                ."<td>" . $libro["pages"] . "</td>"
                ."<td>" . $libro["publisher_date"] . "</td>";
            echo "</tr>";
    }
    ?>
    </table>
</body>
</html>