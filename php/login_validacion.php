<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <title>Validacion de Cuenta...</title>
    <link rel="stylesheet" href="../styles/estilos.css">
</head>
<body>
    <?php
    // Se requerirán las funciones de otro php.
    require 'operacionesusuarios_funciones.php';
    
    // Se declaran las variables obtenidas por el usuario
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    
    // Se busca dentro de la base de datos que el usuario realmente exista.
    $busqueda = Operaciones_usuarios($correo, $password, 3);

    // De regresar un -2 quiere decir que no encontró nada, y se debe redirigir a la página del login.
    if ($busqueda == -2) {
        print '<meta http-equiv="refresh" content="2; url=../pages/publicaciones.php">';
        echo "<h1>El usuario NO existe. Redirigiendo a la página anterior...</h1>";

        // Se declara exit con status 1 de erros.
        exit(1);
    } else {
        // Si existe, le creamos una sesión activa, y guardamos en $_SESSION los datos del usuario.
        session_start();

        $_SESSION['usuario'] = $busqueda['usuario'];
        $_SESSION['correo_electronico'] = $busqueda['correo_electronico'];
        $_SESSION['id_usuario'] = $busqueda['id_usuario'];

        // Se redirige a la página principal.
        print '<meta http-equiv="refresh" content="2; url=../pages/publicaciones.php">';
        echo "<h1>Redirigiendo a la Página Principal...</h1>";

        // Se declara exit con status 0 de éxito.
        exit(0);
    }
    ?>
</body>
</html>