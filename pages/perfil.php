<!DOCTYPE html>
<html>
<head>
	<html lang="es-MX">
	<meta charset="UTF-8">
	<title>Perfil</title>
	<link rel="stylesheet" href="../styles/estilos.css">
</head>
<body>
	<form class="perfil" action="../php/actualizando_perfil.php" method="post">
	
	<?php
    /**
     * Página del perfil del usuario.
     */
    
    // Se requiere el archivo de funciones.
    require '../php/operacionesusuarios_funciones.php';
    
    // Se inicia la sesión.
    session_start();

    // Se obtienen las variables de la sesión.
    $id = $_SESSION['id_usuario'];
    
    /* Si usuario en $_SESSION está vacío, se guarda como $usuario
        el correo electrónico.*/
    if (empty($_SESSION['usuario'])) {
        $usuario = $_SESSION['correo_electrónico'];
    } else {
        $usuario = $_SESSION['usuario'];
    }

    // Se recupera la información del usuario para desplegarla.
    $info = Operaciones_usuarios(0, 0, 4, $id);

    $usuario = $info['usuario'];
    $nombres = $info['nombres'];
    $apellidos = $info['apellidos'];
    $edad = $info['edad'];
    $fecha_n = $info['fecha_nacimiento'];
    $fecha_r = $info['fecha_registro'];
    $ciudad = $info['ciudad'];
    $pais = $info['pais'];
    $idioma = $info['idioma'];
    $fb = $info['cuenta_facebook'];
    $twitter = $info['cuenta_twitter'];
    $git = $info['cuenta_github'];
    ?>

<form class="perfil" action="../php/actualizando_perfil.php" method="post">
	<p>
		<label for="usuario">Usuario </label>
		<input type="text" class="usuario" name="usuario" value = "<?php echo $usuario ?>">
	</p>
	<p>
		<label for="nombres">Nombres </label>
		<input type="text" class="nombres" value = "<?php echo $nombres ?>" name="nombres">
	</p>
	<p>
		<label for="apellidos">Apellidos </label>
		<input type="text" class="apellidos" value = "<?php echo $apellidos ?>" name="apellidos">
	</p>
	<p>
		<label for="edad">Edad </label>
		<input type="text" class="edad" value = "<?php echo $edad ?>" name="edad" >
	</p>
	<p>
		<label for="fecha_n">Fecha de nacimiento </label>
		<input type="date" class="fecha_n" value = "<?php echo $fecha_n ?>" name="fecha_n">
	</p>
	<p>
		<label for="ciudad">Ciudad </label>
		<input type="text" class="ciudad" value = "<?php echo $ciudad ?>"  name="ciudad">
	</p>
	<p>
		<label for="idioma">Idioma </label>
		<input type="text" class="idioma" value = "<?php echo $idioma ?>"  name="idioma">
	</p>
	<p>
		<label for="pais">País </label>
		<input type="text" class="pais" value = "<?php echo $pais ?>"  name="pais">
	</p>
	<p>
		<label for="fb">Cuenta de Facebook </label>
		<input type="text" class="fb" value = "<?php echo $fb?>" name="fb">
	</p>
	<p>
		<label for="twitter">Cuenta de Twitter </label>
		<input type="text" class="twitter" value = "<?php echo $twitter ?>" name="twitter">
	</p>
	<p>
		<label for="git">Cuenta de Github </label>
		<input type="text" class="git" value = "<?php echo $git ?>" name="git">
		</p>

	<input type="submit" name="perfil" value="Guardar">
	<input type="reset" value="Reestablecer">
	<p><a class="enlaces" href="publicaciones.php">Regresar a la página principal</a></p>
	</form>
</body>
</html>
