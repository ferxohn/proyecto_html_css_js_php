<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <title>Registrando usuario...</title>
    <link rel="stylesheet" href="../styles/estilos.css">
</head>
<body>
    <?php
    /**
     * Esta página sirve como redireccionamiento cuando el usuario se registra,
     * ejecutando las query's correspondientes sobre la base de datos.
     *
     * @return void
     */
    
    // Se incluye la página de funciones para poder realizar el registro del usuario.
    require 'operacionesusuarios_funciones.php';
    
    // Se inicializan las variables con los valores recibidos del formulario.
    $correo = $_POST['correo'];
    $password = $_POST['password2'];
    
    // Se busca primero que el usuario no exista en la base de datos.
    $busqueda = Operaciones_usuarios($correo, $password, 2);

    // Si se comprueba que no existe, se registra en la base de datos.
    if ($busqueda == -2) {
        // Se ejecuta la operación de registro.
        $registro = Operaciones_usuarios($correo, $password, 1);

        /**
         * Antes de seguir, una pequeña explicación a
         *
         * <meta http-equiv="refresh" content="2; url=../pages/perfil.php">
         *
         * Este atributo de HTML es una cabecera HTTP (header HTTP).
         * En general, estas cabeceras permiten al cliente y al servidor
         * enviar información adicional junto a una petición o respuesta.
         *
         * Esta cabecera en especial (http-equiv) le brinda al atributo content
         * de la etiqueta meta simular una cabecera de respuesta (response header),
         * ya que con el atributo refresh y el 2 de content indican que la página
         * se refrescará 2 segundos después, y el url dentro del content indica hacia
         * que lugar se dirigirá el nuevo contenido.
         *
         * De forma simple, es una forma de indicar que el contenido de la página
         * actual se refrescará 2 segundos después de abrirse, y se redirigirá hacia
         * una nueva página, por lo que la página actual sirve como redirección
         * temporal hacia una página que se indique.
         *
         */
        
        if ($registro == 0) {
            /* Si se registra correctamente, se redirige a la página del perfil del
            nuevo usuario. Para ello, primero se inicia una sesión.*/
            session_start();
            
            /* Como no se tiene más información del usuario, se guarda el correo
            dentro de $_SESSION como usuario y como correo. */
            $_SESSION['usuario'] = $correo;
            $_SESSION['correo_electronico'] = $correo;

            // Se busca el nuevo id de usuario.
            $registro = Operaciones_usuarios($correo, $password, 3);
            $_SESSION['id_usuario'] = $registro['id_usuario'];
            
            // Finalmente se redirige a la página de perfil.
            print '<meta http-equiv="refresh" content="2; url=../pages/perfil.php">';
            echo "<h1>Usuario creado correctamente. Redirigiendo al nuevo
            perfil...</h1>";
            exit(0);
        } else {
            /* Si hay errores en el registro, se redirige a la página de registro
            nuevamente. */
            print '<meta http-equiv="refresh" content="2; url=../pages/registro.html">';
            echo "<h1>Se produjo un error al crear el usuario. Redirigiendo a la
            página anterior..</h1>";
            exit(1);
        }
    } else {
        // Si el usuario ya existe, se redirige a la página de registro nuevamente.
        print '<meta http-equiv="refresh" content="2; url=../pages/registro.html">';
        echo "<h1>El usuario ya existe. Redirigiendo a la página anterior..</h1>";
        exit(2);
    }
    ?>
</body>
</html>