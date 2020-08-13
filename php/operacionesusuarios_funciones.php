<?php
/**
 * Este archivo contiene todas las funciones necesarias para operar con la
 * tabla de usuarios dentro de la base de datos informacion_usuarios.
 *
 * Para usarlo, es necesario hacer uso de la función Operaciones_usuarios.
 * También es necesario manejar los valores que regresa.
 *
 * @return void
 */

/**
 * Esta función permite definir el tipo de operación a realizar sobre la
 * tabla.
 *
 * Parámetros:
 *
 * @param string $correo   El correo del usuario.
 * @param string $password El password del usuario.
 * @param int    $tipo     El tipo de operación a realizar sobre la tabla.
 * @param int    $id       El id de usuario, es un parámetro opcional.
 *
 * @return int La función regresa un valor real, el cual
 * indica el resultado de su ejecución. Regresa -1 cuando
 * surgen problemas con la conexión a la base de datos,
 * y -2 cuando el resultado de las operaciones es negativo. Regresa
 * 0 o el array asociativo con la información del usuario cuando el resultado es positivo.
 * Esto se explica con más a detalle en cada una de las funciones que se invocan.
 */
function Operaciones_usuarios($correo, $password, $tipo, $id = 0)
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

    // Se cifra la contraseña recibida con SHA-256.
    $password = hash("sha256", $password);

    /* Se genera la query correspondiente:
    * Cuando $tipo == 1, se crea un nuevo usuario en la tabla.
    * Cuando $tipo == 2, se busca un usuario en la tabla. Esta
    * búsqueda sólo aplica cuando se va a crear un nuevo usuario,
    * ya que solo importa buscar el correo.
    * Cuando $tipo == 3, se busca un usuario en la tabla. Esta
    * búsqueda solo aplica para el inicio de sesión, ya que se
    * busca tanto el correo como la contraseña, y se regresa el
    * array asociativo con la información del usuario.
    * Cuando $tipo == 4, se busca la información de un usuario
    * a partir de su id. Se regresa el array asociativo con su información.
    */
    if ($tipo == 1) {
        // Crear un nuevo usuario.
        $resultado = Crear_usuario($conexion, $correo, $password);
    } elseif ($tipo == 2) {
        // Búsqueda de usuario para crear un nuevo usuario.
        $resultado = Buscar_usuario(1, $conexion, $correo);
    } elseif ($tipo == 3) {
        // Búsqueda de usuario para iniciar sesión.
        $resultado = Buscar_usuario(2, $conexion, $correo, $password);
    } elseif ($tipo == 4) {
        $resultado = Buscar_usuario(3, $conexion, 0, 0, $id);
    }

    // Se realiza la desconexión.
    $conexion = null;

    /* Se regresa el resultado de la operación realizada. De nuevo,
    si el resultado es 0 significa que se pudo insertar el usuario
    en la tabla, o que se encontró un usuario en la misma, y 1 implica
    que no se pudo insertar el usuario en la tabla, o que no se encontraron
    usuarios en la misma.*/
    return $resultado;
}

/**
 * Esta función permite crear un nuevo usuario en la tabla.
 *
 * Parámetros:
 *
 * @param PDO    $conexion El objeto de conexión a la BD.
 * @param string $correo   El correo electrónico del usuario.
 * @param string $password El password del usuario.
 *
 * @return int La función regresa 0 cuando la inserción del usuario
 * es correcta, mientras que regresa -2 cuando se genera un error en la
 * inserción.
 */
function Crear_usuario($conexion, $correo, $password)
{
    // Se declara la query de inserción.
    $query = "INSERT INTO usuarios(correo_electronico, password)
    VALUES('$correo','$password');";

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

/**
 * Esta función permite buscar un usuario en la tabla.
 *
 * Parámetros:
 *
 * @param int    $tipo     El tipo de búsqueda a realizar.
 * @param PDO    $conexion El objeto de conexión a la BD.
 * @param string $correo   El correo electrónico del usuario.
 * @param string $password El password del usuario. Es un parámetro opcional,
 *                         dependiendo del tipo de búsqueda a realizar. Por defecto
 *                         tiene valor 0.
 * @param int    $id       El id de usuario. Es un parámetro opcional.
 *
 * @return int La función regresa 0 cuando se encuentra un usuario en la tabla,
 * y regresa -2 cuando no se encuentra ningún usuario o se genera un error en la
 * búsqueda.
 */
function Buscar_usuario($tipo, $conexion, $correo, $password = 0, $id = 0)
{
    /* Se genera la query correspondiente:
    * Cuando $tipo == 1, solo se busca el correo en la tabla.
    * Cuando $tipo == 2, se busca tanto el correo como el password en la tabla.
    * Cuando $tipo == 3, se busca el id de usuario en la tabla.
    */
    if ($tipo == 1) {
        // Búsqueda del correo en la tabla
        $query = "SELECT * FROM usuarios WHERE correo_electronico='$correo';";
    } elseif ($tipo == 2) {
        // Búsqueda del correo y el password en la tabla.
        $query = "SELECT * FROM usuarios WHERE correo_electronico='$correo' AND
        password='$password';";
    } elseif ($tipo == 3) {
        $query = "SELECT * FROM usuarios WHERE id_usuario='$id';";
    }

    /* Se ejecuta la query con query(), cuyo resultado es un objeto de tipo
    PDOStatement, o false en caso de existir algún error en la búsqueda.
    Este resultado se almacena en $busqueda. */
    $busqueda = $conexion->query($query);

    // Si se genera algún error en la búsqueda, se regresa -2.
    if ($busqueda == false) {
        return -2;
    }

    /* Finalmente se comprueba la cantidad de registros encontrados usando
    fectchAll(), cuyo resultado es un array vacío o de 1 o más registros. */
    $resultado = $busqueda->fetchAll();

    // Si el array resultante está vacío, se regresa -2.
    if (empty($resultado)) {
        return -2;
    }

    /* Si no está vacío, se tienen 2 casos especiales:
    * Cuando $tipo == 1, solamente se busca el correo, y esta
    * función se invoca desde el ingreso de un nuevo usuario.
    * Por lo tanto, solo es necesario regresar 0.
    * Cuando $tipo == 2, se busca tanto el correo y el password,
    * y esta función se invoa desde el login. Por lo que es necesario
    * regresar el array asociativo con la información del usuario.
    */
    if ($tipo == 1) {
        // Búsqueda del correo en la tabla.
        return 0;
    }

    /* Caso del $tipo == 2 y $tipo == 3.
    Búsqueda del correo y password en la tabla. Para ello, se
    filtra el arreglo para obtener el array asociativo con la
    información del usuario y regresarlo.*/
    foreach ($resultado as $usuario => $info) {

        /* Como solamente nos importa el primer y único usuario que corresponde
        al correo, además de que no se repiten los usuarios en la tabla, entonces
        se regresa la información directamente en la primera iteración. */
        return $info;
    }
}
