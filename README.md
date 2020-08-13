# Proyecto del Tercer Parcial: Creación de una página web usando HTML, CSS, JavaScript y PHP

## Programación Web - Universidad del Caribe (Primavera 2018)

* Alumnos:

  * Fernando Gómez Perera - 160300129
  * Victoria Andrea Garza Romero - 160300110
  * Angélica Guadalupe Arellanes Merino - 160300749

### Contenido

Página web de ejemplo para ilustrar los conceptos vistos durante el tercer parcial de la clase.

Todas las páginas están completamente documentadas con el objetivo de explicar lo que sucede en cada una de ellas.

### **IMPORTANTE**

Antes de ejecutar el proyecto, leer las instrucciones dentro del directorio `sql` para poder replicar de forma correcta la base de datos.

### Descripción

Esta pequeña página web permite el registro de usuarios, los cuales pueden almacenar publicaciones y posteriormente visualizarlas.

Las páginas que componen el repositorio son las siguientes:

1. `index.html`: En esta página el usuario inicia sesión para ver sus publicaciones y su perfil.
2. `/pages/registro.html`: En esta página el usuario puede registrarse. Se permite la creación de una nueva cuenta si el correo usado no se encuentra ya registrado.
3. `/pages/publicaciones.php`: Corresponde a la página principal del usuario al iniciar sesión, que es donde puede visualizar sus publicaciones almacenadas.
4. `/pages/perfil.php`: En esta página el usuario puede modificar la información de su perfil. Las 15 propiedades que puede almacenar como parte de su perfil son las siguientes:

|   Información general |   Información del usuario                 |   Redes sociales      |
|   ------------------  |   --------------------------------------- |   ------------------  |
|   Correo electrónico  |   Edad                                    |   Cuenta de Facebook  |
|   Password            |   Fecha de nacimiento                     |   Cuenta de Twitter   |
|   Usuario             |   Fecha de registro (tomada del servidor) |   Cuenta de Github    |
|   Nombres             |   Ciudad                                  |                       |
|   Apellidos           |   País                                    |                       |
|                       |   Idioma                                  |                       |

### Requerimientos solicitados como parte del proyectos

* Cuando el usuario inicia sesión, la sesión debe mantenerse por todas la ventanas.
* Si el usuario no inicia sesión, la única ventana que podrá ver es la de inicio de sesión.
* Todas las ventanas deben contener un botón para cerrar sesión.

### Algunos recursos externos de ayuda

* [HTML Event Attributes - w3schools.com](https://www.w3schools.com/tags/ref_eventattributes.asp "HTML Event Attributes")
* [require - php.net](http://php.net/manual/es/function.require.php "require")
* [PHP 5 Global Variables - Superglobals - w3schools.com](https://www.w3schools.com/php/php_superglobals.asp "PHP 5 Global Variables - Superglobals - w3schools.com")
* [Objetos de datos de PHP - php.net](http://php.net/manual/es/book.pdo.php "Objetos de datos de PHP")
  * [PDO::__construct - php.net](http://php.net/manual/es/pdo.construct.php "PDO::__construct")
  * [PDO::query - php.net](http://php.net/manual/es/pdo.query.php "PDO::query")
  * [Connections and Connection management - php.net](http://php.net/manual/en/pdo.connections.php "Connections and Connection management")
* [JavaScript Crash Course - Packt](https://www.packtpub.com/web-development/javascript-crash-course-video "JavaScript Crash Course")
* [JavaScript Debugging - w3schools.com](https://www.w3schools.com/js/js_debugging.asp "JavaScript Debugging")
