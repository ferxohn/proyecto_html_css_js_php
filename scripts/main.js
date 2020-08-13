/**
 * Esta función permite validar la estructura de un correo electrónico.
 * 
 * Parámetros.
 * 
 * @param {string} correo Es el correo electrónico del usuario.
 * @param {int} tipo 0 para inicio de sesión, 1 para registro de usuario.
 * 
 * @returns {bool} Regresa true cuando el correo es válido, y false cuando
 * el correo es inválido. Es necesario tener un input de tipo submit con el id="login
 * y propiedad disabled para poder deshabilitarlo si el correo es inválido.
 */
function validar_correo(correo, tipo)
{
    // La entrada se convierte a cadena.
    correo = String(correo.value);

    // Se inicializa una variable con la estructura de la expresión regular de un correo electrónico.
    var expresion_correo = "((([a-z]|[A-Z])|[0-9])+|(-|_)*)+@(([a-z]|(A-Z))|[0-9])+\\.+((([a-z]|(A-Z))|[0-9])+|\\.+)+";

    // Se inicializa un objeto de tipo expresión regular a partir de la variable anterior.
    var probar_correo = new RegExp(expresion_correo);

    // Se evalúa la expresión regular con el correo electrónico ingresado.
    var resultado_correo = probar_correo.test(correo);

    // Finalmente se comprueba si la estructura del correo electrónico es correcta.
    if (resultado_correo) {
        // Cuando se registra un nuevo usuario e ingresa un correo válido, el mensaje de correo inválido se elimina.
        if(tipo == 1) {
            document.getElementById("error_correo").innerHTML = "";
        }
        // Cuando se inicia sesión o se registra un nuevo usuario, se retorna verdadero cuando el correo es correcto. 
        return true;
    } else {
        // Cuando se registra un nuevo usuario se muestra en pantalla un mensaje de correo inválido.
        if(tipo == 1) {
            document.getElementById("error_correo").innerHTML = "Correo inválido";
        }

        // Cuando se inicia sesión o se registra un nuevo usuario, se retorna falso cuando el correo es incorrecto.
        // También se deshabilita el botón de login para evitar enviar la información al servidor.
        document.getElementById("login").disabled = true;
        return false;
    }
}

/**
 * Esta función permite validar la estructura de una contraseña.
 * 
 * Parámetros.
 * 
 * @param {string} password Es el password del usuario.
 * @param {int} tipo 0 para inicio de sesión, 1 para registro de usuario.
 * 
 * @returns {bool} Regresa true cuando el password es válido, y false cuando
 * el password es inválido. Es necesario tener un input de tipo submit con el id="login" 
 * y propiedad disabled para poder deshabilitarlo si el password es inválido.
 */
function validar_password(password, tipo)
{
    // La entrada se convierte a cadena.
    password = String(password.value);

    // Se comprueba que la contraseña no tenga espacios en blanco.
    var sin_espacios = !(/\s/.test(password));

    // Cuando se registra un nuevo usuario, se muestra en el HTML el estado de la contraseña.
    if (tipo == 1) {
        if(sin_espacios == false) {
            document.getElementById("error_espacios").innerHTML = "Sin espacios en blanco";
        } else {
            document.getElementById("error_espacios").innerHTML = "";
        }
    }
    
    // Para comprobar que la contraseña contenga mínimo un caracter especial, es necesario eliminar primero los
    // espacios en blanco de la misma (en caso de tener), y después evaluar que contenga algún otro caracter especial.
    if(sin_espacios == false) {
        // Primero se filtra la contraseña eliminando los espacios en blanco.
        password = password.match(/\S/g);
        
        // Si la contraseña queda vacía al filtrarla, no se le aplica join para evitar errores.
        if (password != null) {
            // Se unen los caracteres restantes en una cadena sin comas.
            password = password.join("");
        }
    }

    // Se evalúa la existencia de algún otro caracter especial en la contraseña.
    var caracter_especial = /\W{1,}/.test(password);

    // Cuando se registra un nuevo usuario, se muestra en el HTML el estado de la contraseña.
    if (tipo == 1) {
        if(caracter_especial == false) {
            document.getElementById("error_caracter").innerHTML = "Mínimo 1 caracter especial";
        } else {
            document.getElementById("error_caracter").innerHTML = "";
        }
    }
    
    // Se evalúa la existencia de mínimo un número en la contraseña.
    var numero = /[0-9]{1,}/.test(password);

    // Cuando se registra un nuevo usuario, se muestra en el HTML el estado de la contraseña.
    if (tipo == 1) {
        if(numero == false) {
            document.getElementById("error_numero").innerHTML = "Mínimo 1 número";
        } else {
            document.getElementById("error_numero").innerHTML = "";
        }
    }
    
    // Se evalúa la existencia de mínimo una mayúscula en la contraseña.
    var mayuscula = /[A-Z]{1,}/.test(password);

    // Cuando se registra un nuevo usuario, se muestra en el HTML el estado de la contraseña.
    if (tipo == 1) {
        if(mayuscula == false) {
            document.getElementById("error_mayuscula").innerHTML = "Mínimo 1 mayúscula";
        } else {
            document.getElementById("error_mayuscula").innerHTML = "";
        }
    }

    // Se muestra en el HTML si la contraseña cumple con que tenga mínimo 8 caracteres.
    // (Solo aplica cuando se registra un nuevo usuario).
    if(tipo == 1) {
        // Se incluye también el caso donde la contraseña está vacía.
        if (password == null || password.length < 8) {
            document.getElementById("error_menor_ocho").innerHTML = "Mínimo 8 caracteres";
        } else {
            document.getElementById("error_menor_ocho").innerHTML = "";
        }
    }
    
    // Se crea una variable booleana que contendrá la unión de las 4 evaluaciones anteriores.
    var resultado_password = sin_espacios && caracter_especial && numero && mayuscula;
    
    // Si todas las evaluaciones son positivas, y el password es mayor o igual a 8 caracteres, entonces el
    // password está correcto.
    if(resultado_password && password.length >= 8) {
        // Cuando se inicia sesión o se registra un nuevo usuario, se retorna verdadero cuando el password
        // es correcto.
        return true;
    }

    // Cuando se inicia sesión o se registra un nuevo usuario, se retorna falso cuando el password es incorrecto.
    // También se deshabilita el botón de login para evitar enviar la información al servidor.
    document.getElementById("login").disabled = true;
    return false;
}

/**
 * Esta función permite validar un inicio de sesión a partir del correo electrónico
 * y la contraseña ingresada.
 * 
 * Parámetros.
 * 
 * @param {string} correo Es el correo electrónico del usuario.
 * @param {int} password Es el password del usuario.
 * 
 * @returns {void} Solamente imprime en el HTML cuando alguno de los
 * dos parámetros es incorrecto. Debe existir un elemento con id="error".
 * De igual forma, habilita o deshabilita un elemento input de tipo submit con id="login"
 * con propiedad disabled, dependiendo de si las entradas son válidas o no.
 */
function validar_login(correo, password1)
{
    /* Si alguna de las entradas es errónea, se despliega en pantalla un mensaje de error.
       También se dehabilita el botón de envío del formulario. */
    if(!validar_correo(correo, 0) || !validar_password(password1, 0)) {
        document.getElementById("error").innerHTML = "El correo y/o la contraseña es incorrecta";
        //y se pone el disabled como valido para que el boton no funcione
        document.getElementById("login").disabled = true;
    }
    else{
        //de lo contrario si son validos y el boton debe funcionar
        document.getElementById("login").disabled = false;
        document.getElementById("error").innerHTML = "";
    }

    return;
}

/**
 * Esta función permite realizar la comprobación final de los datos del nuevo usuario antes de
 * enviarlos al servidor.
 * 
 * Parámetros.
 * 
 * @param {string} correo Es el correo electrónico que ingresa el usuario.
 * @param {int} password1 Es el password que ingresa el usuario.
 * @param {int} password2 Es la repetición del password que ingresa el usuario.
 * 
 * @returns {void} Imprime en el HTML cuando el segundo password no coincide
 * con el primero. Para ello debe existir un elemento con el id="passwords_coinciden".
 * De igual forma, habilita o deshabilita un elemento input de tipo submit con id="login"
 * con propiedad disabled, dependiendo de si las entradas son válidas o no.
 */
function crear_usuario(correo, password1, password2)
{
    // Se comprueba que las contraseñas ingresadas sean iguales.
    if(password1.value == password2.value) {
        // Si se cumple, se elimina el texto de error del HTML.
        document.getElementById("passwords_coinciden").innerHTML = "";

        // Finalmente se comprueba que tanto el correo como la contraseña ingresada tengan un formato válido.
        if (validar_correo(correo, 0) && validar_password(password1, 0)) {
            document.getElementById("login").disabled = false;
        }
    } else {
        // Si no se cumple, entonces se indica el error en el HTML, y se dehabilita el botón de envío del formulario.
        document.getElementById("passwords_coinciden").innerHTML = "Las contraseñas no coinciden";
        document.getElementById("login").disabled = true;
    }

    return;
}