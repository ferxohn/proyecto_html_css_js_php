<?php

/**
 * Este archivo sirve contiene las funciones necesarias para poder actualizar
 * el perfil del usuario. Todo se maneja a partir de la función Operaciones_perfil.
 */


/**
 * Esta función permite actualiza el perfil del usuario.
 *
 * Parámetros.
 *
 * @param mixed entradas: La información del usuario.
 *
 * @return mixed Regresa números reales, donde 0 indica éxito
 * y cualquier otro número indica un error.
 */
function Operaciones_perfil($id, $usuario, $nombres, $apellidos, $edad, $fecha_n, $ciudad, $idioma, $pais, $fb, $twitter, $git)
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
    // Se realiza la actualización del perfil.
    $resultado = Actualizar_perfil($id, $conexion, $usuario, $nombres, $apellidos, $edad, $fecha_n, $ciudad, $idioma, $pais, $fb, $twitter, $git);

    // Se realiza la desconexión.
    $conexion = null;

    // Se regresa el resultado de la operación.
    return $resultado;
}

/**
 * Esta función permite actualiza la información del perfil
 * del usuario.
 *
 * Parámetros:
 *
 * @param mixed entradas: Toda la información del usuario.
 *
 * @return int Regresa 1 cuando hay un error en la actualización,
 * y 0 cuando la actualización fue correcta.
 */
function Actualizar_perfil($id, $conexion, $usuario, $nombres, $apellidos, $edad, $fecha_n, $ciudad, $idioma, $pais, $fb, $twitter, $git)
{
    /* Cuando no hay fecha de nacimiento en la actualización, la query
    se escribe con valor null en ese parámetro para evitar errores en la
    actualización. Si no, la query se ejecuta normal.*/
    if ($fecha_n == '') {
        $query = "UPDATE usuarios SET usuario = '$usuario', nombres = '$nombres',
        apellidos = '$apellidos', edad = '$edad', fecha_nacimiento = null,
        ciudad = '$ciudad', pais = '$pais', idioma = '$idioma',
        cuenta_facebook = '$fb', cuenta_twitter = '$twitter', cuenta_github = '$git'
        WHERE id_usuario = '$id';";
    } else {
        $query = "UPDATE usuarios SET usuario = '$usuario', nombres = '$nombres',
        apellidos = '$apellidos', edad = '$edad', fecha_nacimiento = '$fecha_n',
        ciudad = '$ciudad', pais = '$pais', idioma = '$idioma',
        cuenta_facebook = '$fb', cuenta_twitter = '$twitter' , cuenta_github = '$git'
        WHERE id_usuario = '$id';";
    }
    
    /* Se ejecuta la query de actualización con exec() para contar la cantidad de
    registros que fueron modificados.*/
    $busqueda = $conexion->exec($query);
    
    // Si se genera algún error en la búsqueda, se regresa 1.
    if ($busqueda == false) {
        return 1;
    }

    // Se regresa 0 cuando la actualización fue exitosa.
    return 0;
}
