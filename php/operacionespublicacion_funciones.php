<?php

/**
 * Este archivo contiene las funciones para poder operar las
 * publicaciones. Se usa invocando a la función Operaciones_publicación.
 */

/**
 * Esta función permite operar con las publicaciones.
 * 
 * Parámetros:
 * 
 * @param mixed entradas La información de las publicaciones.
 * 
 * @return mixed Regresa números enteros o el aray asociativo
 * de las publicaciones.
 */
function Operaciones_publicacion($id, $titulo, $texto, $tipo)
{
    // Variables con la información de la conexión a la base de datos.
    $host = "localhost";
    $usuario_bd = "programacionweb";
    $password_bd = "Web@18";
    $bd = "informacion_usuarios";

    // Se declara el nombre de origen de datos o DSN.
    $origen = "mysql:dbname=$bd;host=$host";

    // Se realiza la conexión usando try ("intentar" la conexión).
    try {
        $conexion = new PDO($origen, $usuario_bd, $password_bd);
    } catch (PDOException $error) {
        // Si falla la conexión, se cacha y muestra el error, y se regresa -1.
        echo 'Falló la conexión: ' . $error->getMessage();
        return -1;
    }

    // Se elige entre si imprimir la información de las publicaciones del usuario o crear una publicación.
    if ($tipo == 1) {
        $resultado = Desplegar_publicaciones($conexion, $id);
    } elseif ($tipo == 2) {
        $resultado = Nueva_publicacion($conexion, $id, $titulo, $texto);
    }

    // Se realiza la desconexión.
    $conexion = null;

    // Se regresa el resultado de la función.
    return $resultado;
}

// Esta función permite imprimir todas las publicaciones de un usuario.
function Desplegar_publicaciones($conexion, $id)
{
    // Selecciona todas las filas que concuerden con el id ingresado
    $query = "SELECT * FROM publicaciones WHERE id_usuario='$id';";

    // Se ejecuta query().
    $busqueda = $conexion->query($query);

    // Si se genera algún error en la búsqueda, se regresa 1.
    if ($busqueda == false) {
        return -2;
    }

    /* Finalmente se comprueba la cantidad de registros encontrados usando 
    fectchAll(), cuyo resultado es un array vacío o de 1 o más registros. */
    $resultado = $busqueda->fetchAll();

    // Si el array resultante está vacío, se regresa 1.
    if (empty($resultado)) {
        return -2;
    }
    
    /* Si todo sale bien, se regresa el array asociativo con las publicaciones
    del usuario.*/
    return $resultado;
}

// En esta función se guarda la publicación en la base de datos.
function Nueva_publicacion($conexion, $id, $titulo, $texto)
{
    // Se declara la query .
    $query = "INSERT INTO publicaciones(titulo, texto, id_usuario)
    VALUES('$titulo','$texto','$id');";

    // Se ejecuta la query con exec() para obtener el número de filas modificadas.
    $resultado = $conexion->exec($query);

    /* El resultado de la operación puede devolver 0 o false, donde false implica
    que hubo un error al realizar la inserción en la tabla. De cualquier forma,
    se maneja como el mismo error que las filas afectadas sean 0.*/
    if ($resultado == false) {
        return -2;
    }
    
    // Si no hubo errores, se regresa 0.
    return 0;
}
?>