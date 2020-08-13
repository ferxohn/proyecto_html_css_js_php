<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <title>Cerrando Sesión...</title>
    <link rel="stylesheet" href="../styles/estilos.css">
</head>
<body>
    <?php
    /**
     * Esta página sirve como redireccionamiento cuando el usuario cierra su sesión.
     */

    // Se declara la sesion abierta
    session_start();
    
    // Se liberan las variables de sesión registradas para protegerlo.
    $_SESSION = array();
    
    // Y se libera la sesion y cualquier variable olvidada.
    session_destroy();

    // Redirigimos a un php ya que el siguiente pedazo de código solo puede redirigir a otro php.
    print '<meta http-equiv="refresh" content="2; url=../publicaciones.php">';
    echo "<h1>Estamos cerrando su sesión. Hasta luego...</h1>";

    // Se declara exit con status 0 de éxito.
    exit(0);
    ?>
</body>
</html>