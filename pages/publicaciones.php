<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <title>Página Principal</title>
    <link rel="stylesheet" href="../styles/estilos.css">
</head>
<body>
    <nav>
        <ul class"nav">
            <li class="nav"><a class="enlaces" href="perfil.php">Editar</a></li>
            <!-- Este es el enlace para cerrar la sesión -->
            <li class="nav"><a class="enlaces" href="../php/cerrando_sesion.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
    <article class="principal">
        <?php
        // Se declara la sesión activa.
        session_start();
    
        // Pregunta si está regresando de cerrar la sesión.
        if (empty($_SESSION)) {
            // De serlo, sólo se redirige a la página del login.
            header('Location: ../index.html');

            // Se declara exit con status 0 de éxito.
            exit(0);
        }

        // Si no es así, se recuperan las variables de $_SESSION.
        $id = $_SESSION['id_usuario'];

        /* Si usuario en $_SESSION está vacío, se guarda como $usuario
        el correo electrónico.*/
        if (empty($_SESSION['usuario'])) {
            $usuario = $_SESSION['correo_electrónico'];
        } else {
            $usuario = $_SESSION['usuario'];
        }
        
        // Se muestra el título con el nombre de usuario.
        echo "<h1>Bienvenido Usuario: ". $usuario . "</h1>";
        ?>
    <br>
    <br>
    <h2>¡PUBLICA ALGO NUEVO!</h2>
    <!-- Comienza el form para las publicaciones. -->
    <form class ="publicacion" action="../php/validacion_publicacion.php" method="post">
        <p> 
            <!-- Tengo mis 2 campos: titulo y texto y 2 boton uno de reset y otro de enviar/publicar -->
            <label for="titulo">Titulo</label>
            <input type="text" placeholder="Ingresa el título" name="titulo" required>
        </p>
            <label for="texto">Texto</label>
            <textarea name="texto" cols="50" rows"2" placeholder="Ingrese publicación" required></textarea><br>
        <section class="botones">
        <input type="submit" name="submit" value="Enviar">
        <input type="reset" value="Reestablecer">
        </section>
    </form>
    <br>
    <br>
    <h2>ESTAS SON TUS PUBLICACIONES:</h2>
        <?php

        // Declaro que usaré las funciones de otro php.
        require '../php/operacionespublicacion_funciones.php';

        /* Aqui comienza la incersión de mis datos en una tabla.
        Como es php se debe hacer con las concatenaciones.*/
        $tabla = "<table>";

        //<tr> me hace saltos de línea; cada vez que yo abro y cierro una se hace una fila.
        //<th> es para declarar los títulos de cada campo de mi tabla.
        $tabla .= "<tr><th>Titulo</th>";
        $tabla .= "<th>Publicacion</th>";
        $tabla .= "</tr>";

        // Obtengo las publicaciones con base en el id (realizo una búsqueda comparándolo).
        $publicaciones = Operaciones_publicacion($id, 0, 0, 1);

        // Si se regresa -2 quiere decir que la búsqueda no encontró nada.
        if ($publicaciones == -2) {
            // Por lo que sólo se imprime en la tabla que no hay información.
            $tabla .= "<tr>";
            $tabla .= "<td>¡Aún no has publicado nada, Publica algo!</td>";
            $tabla .= "<td>:(</td>";
            $tabla .= "</tr>";
        } else {
            /** Si encuentra algo, entonces, por cada uno de los elementos
            * guardados en $publicaciones, el procedimiento para imprimirlas
            * en la tabla es el siguiente:
            *
            * 1. $publicacion es un índice que utiliza el programa
            * para poder saber en que número están los datos que obtuvo;
            * por así decirlo es un contador.
            *
            * 2. $contenido es donde se va guardando toda la fila con sus campos
            * (lo que venga de $publicacion).
            *
            * 3. Solo ahí queda filtrarlo para obtener el título y el texto).
            */
            foreach ($publicaciones as $publicacion => $contenido) {
                $tabla .= "<tr>";
                
                // Aquí se filtra, guardas lo que tengas en contenido en el campo titulo en $titulo.
                $titulo =$contenido['titulo'];

                // td sirve para pasarte al siguiente campo de cada fila.
                $tabla .= "<td>$titulo</td>";

                // Aquí se filtra el texto, guardas lo que tengas en contenido en el campo texto en $texto.
                $texto = $contenido['texto'];
                $tabla .= "<td>$texto</td>";
                $tabla .= "</tr>";
            }
        }
        
        // Y por último cierras la tabla e imprimes tabla.
        $tabla .= "</table>";
        echo $tabla;
        ?>
</body>
</html>