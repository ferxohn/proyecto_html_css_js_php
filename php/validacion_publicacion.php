<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <title>Validando la publicación...</title>
    <link rel="stylesheet" href="../styles/estilos.css">
</head>
<body>
    <?php
    /**
     * Este archivo sirve como redirección cuando el usuario crea una
     * nueva publicación.
     */

    // Se inicia la sesión.
    session_start();

    // Declaramos que necesitamos las funciones de otro php.
    require 'operacionespublicacion_funciones.php';
    
    // Declaramos las variables a necesitar
    $titulo = $_POST['titulo'];
    $texto = $_POST['texto'];
    $id = $_SESSION['id_usuario'];
    
    /* Mandamos a llamar a la función princiapl para poder ingresar
    los elementos dados por el usuario en la tabla.*/
    $resultado = Operaciones_publicacion($id, $titulo, $texto, 2);

    /* Si regresa -2 significa que no se pudo realizar la publicacion y
    se redirige la pagina del usuario. */
    if ($resultado == -2) {
        print '<meta http-equiv="refresh" content="2; url=../pages/publicaciones.php">';
        echo "<h1>No se pudo realizar la publicación. Redirigiendo a la página
        anterior...</h1>";

        // Se declara exit con status 1 de error.
        exit(1);
    } else {
        /* Si se logra entonces mandas mensaje de publicacion exitosa y
        rediriges a la pagina del usuario.*/
        print '<meta http-equiv="refresh" content="2; url=../pages/publicaciones.php">';
        echo "<h1>Publicación exitosa. Redirigiendo a la Página Principal...</h1>";

        // Se declara exit con status 0 de éxito.
        exit(0);
    }
    ?>
</body>
</html>