
# Aplicación Web Finanzas para el Hogar

**La Aplicación Web de Finanzas para el Hogar** proporciona una solución para la gestión de finanzas personales. Al migrar desde un sistema en Excel, la aplicación brinda una experiencia más intuitiva y fácil de usar para los usuarios. Con esta herramienta, los usuarios podrán registrar y monitorear sus ingresos y gastos de manera más efectiva, mejorando su control y toma de decisiones en relación a sus finanzas personales.

## Objetivo

Mi objetivo es brindar una experiencia intuitiva y sencilla para la administración financiera personal.

</br>

| ![GestionHogar_1](https://pablogarciajc.com/wp-content/uploads/2024/03/pablogarciajc-aplicacion-web-finanzas-para-el-hogar-img1.webp) | ![GestionHogar_2](https://pablogarciajc.com/wp-content/uploads/2024/03/pablogarciajc-aplicacion-web-finanzas-para-el-hogar-img2.webp) |
|-----------|-----------|


## Funcionaliades

La aplicación cuenta con **tres módulos:**

**El registro de ingresos periódicos:**

* Permite registrar, actualizar y eliminar los ingresos de manera eficiente.
* Tiene una herramienta de búsqueda para filtrar registros y un paginador para organizarlos.

**La administración de ingresos y deudas:**

* Ofrece una interfaz accesible para la gestión de gastos y deudas.
* Permite registrar, actualizar y eliminar gastos de manera eficiente.
* Tiene una herramienta de búsqueda para filtrar los registros.

**Población de tablas:**

* Permite llenar la tabla con datos preestablecidos para facilitar la gestión de información y evitar tener que ingresar los datos manualmente cada mes.

## Tecnologías

La aplicación web se desarrolla con **PHP 7.3.5 como lenguaje de programación.**

**Front-end:**

* Bootstrap v4.0.0: [plantilla](https://w3layouts.com/template/modern-admin-panel-flat-bootstrap-responsive-web-template/) que mejora la apariencia y la experiencia del usuario.
* JavaScript: lenguaje de programación que permite agregar funcionalidades dinámicas a la aplicación web.
* JQuery: biblioteca de JavaScript que facilita la manipulación del DOM y la realización de solicitudes HTTP.

**Back-end:**

* SQL (Structured Query Language) es un lenguaje de programación utilizado para interactuar con bases de datos relacionales. Con SQL, puedes crear, consultar, actualizar y eliminar datos en una base de datos.

* PhpMyAdmin, permite a los usuarios realizar varias tareas de gestión de bases de datos, como la creación, modificación y eliminación de bases de datos, tablas, columnas, índices y usuarios; la ejecución de sentencias SQL y la gestión de usuarios y permisos de la base de datos.

**El patrón de arquitectura:**

* Model-View-Controller (MVC) es un patrón de diseño que se utiliza para separar la lógica de negocios de una aplicación, la representación visual de los datos y la gestión de la entrada del usuario.

## Instalación

**Requisitos:**

* Descargar un servidor local, recomiendo [Wampserver64](https://www.wampserver.com/en/download-wampserver-64bits/)

**Instrucciones:**

1. Descargar el proyecto de GitHub:

    * Vaya al repositorio del proyecto en GitHub.
    * Haga clic en el botón "Clone or download".
    * Seleccione "Download ZIP" para descargar un archivo ZIP con el proyecto.

2. Mover el proyecto a la carpeta de servidor WAMP:

    * Abra la carpeta "www" dentro de la carpeta de instalación de WAMP en su equipo.
    * Cree una carpeta en el escritorio llamada «portafolios».
    * Descomprima el archivo ZIP descargado en la carpeta "www/portafolios", que previamente descargó de Github.
    * Verifique que el nombre de la carpeta del proyecto sea «pablogarciajc_gestionhogar».

3. Iniciar WAMP:

    * Haga clic en el icono de WAMP en la bandeja del sistema (es posible que deba hacer clic con el botón derecho del mouse para ver todas las opciones disponibles).
    * Seleccione "Start All Services" para iniciar el servidor WAMP.

4. Acceder a phpMyAdmin:

    * Abra un navegador web y escriba "localhost/phpmyadmin" en la barra de direcciones.
    * Ingrese su nombre de usuario y contraseña de phpMyAdmin.

5. Importar la base de datos en phpMyAdmin:

    * En la pestaña "Importar", haga clic en el botón "Examinar" y seleccione el archivo de la base de datos que desea importar en su equipo, el cual esta en  el archivo del proyecto llamado «database» que ha descargado de Github y tiene como nombre pablogarciajc_gestionhogar.sql
    * Asegúrese de que el formato de la base de datos sea compatible con phpMyAdmin y seleccione la correcta opción de formato (SQL).
    * Haga clic en el botón "Ir" para iniciar la importación.
    * Después de importar la base de datos, en un navegador, vaya a [http://localhost/portafolios/pablogarciajc_gestionhogar/] para acceder a su proyecto.

## Contáctame para más información o preguntas

| Redes Sociales  | Desarrollador de Aplicaciones Web |
| ------------- | ------------- |
| ![Web Icono](https://pablogarciajc.com/wp-content/uploads/2024/04/web.png) | **[www.pablogarciajc.com](https://pablogarciajc.com/)** |
| ![Facebook](https://pablogarciajc.com/wp-content/uploads/2024/04/facebook.png) | **[@pablogarciajc](https://www.facebook.com/PabloGarciaJC)** |
| ![LinkedIn](https://pablogarciajc.com/wp-content/uploads/2024/04/linkedin.png) | **[@pablogarciajc](https://www.linkedin.com/in/pablogarciajc/)** |

"El buen trabajo es la solución de hoy.
Para construir el futuro del mañana"




