<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <title>Actualizando perfil...</title>
    <link rel="stylesheet" href="../styles/estilos.css">
</head>
<body>
    <?php
    /**
     * Esta página sirve como redireccionamiento cuando el usuario actualiza
     * su perfil.
     */
    
    // Se inicia la sesión recuperando la variable $_SESSION.
    session_start();

    // Se recupera solamente el id de usuario.
    $id = $_SESSION['id_usuario'];
    
    // Se importa el archivo de operaciones.
    require 'operacionesperfil_funciones.php';

    // Se inicializan las variables con los valores recibidos del formulario.
    $usuario = $_POST['usuario'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $edad = $_POST['edad'];
    $fecha_n  = $_POST['fecha_n'];
    //$fecha_r = date("d.m.y");
    $ciudad = $_POST['ciudad'];
    $idioma = $_POST['idioma'];
    $pais = $_POST['pais'];
    $fb = $_POST['fb'];
    $twitter = $_POST['twitter'];
    $git = $_POST['git'];

    // Se invoca a la función de actualización del perfil.
    $resultado = Operaciones_perfil($id, $usuario, $nombres, $apellidos, $edad, $fecha_n, $ciudad, $idioma, $pais, $fb, $twitter, $git);

    if ($resultado == -2) {
        /* Si hay errores en la actualización, se redirige a la página de perfil
            nuevamente. */
        print '<meta http-equiv="refresh" content="2; url=../pages/perfil.php">';
        echo "<h1>Se produjo un error al actualizar la información. Redirigiendo a la
        página anterior..</h1>";

        // Se declara exit con status 1 de error.
        exit(1);
    } else {
        // Finalmente se redirige a la página principal.
        print '<meta http-equiv="refresh" content="2; url=../pages/publicaciones.php">';
        echo "<h1>Perfil actualizado correctamente. Redirigiendo a las
        publicaciones...</h1>";

        // Se declara exit con status 0 de éxito..
        exit(0);
    }
    ?>
</body>
</html>