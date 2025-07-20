# Sistema de Finanzas de Hogar

El **Sistema de Finanzas de Hogar** es una aplicación desarrollada con el paquete **EasyAdmin** para **Symfony**, diseñada para ayudarte a administrar tus finanzas personales y familiares de forma sencilla y segura.

Este sistema facilita el control y seguimiento de ingresos, gastos, ahorros y metas financieras, ofreciendo una interfaz amigable y funcionalidades robustas para la gestión financiera diaria.

El proyecto está pensado como una solución práctica para aprender y aplicar conceptos de administración de datos, seguridad y experiencia de usuario en aplicaciones web.

## Demo del Proyecto

[http://finanzashogar.pablogarciajc.com/](http://finanzashogar.pablogarciajc.com/)

| ![Imagen 1](https://pablogarciajc.com/wp-content/uploads/2025/07/sistema_finanzas_hogar1.webp) | ![Imagen 2](https://pablogarciajc.com/wp-content/uploads/2025/07/sistema_finanzas_hogar5.webp) |
|-----------|-----------|

## ¿Qué funcionalidades ofrece el Sistema de Finanzas de Hogar?

- **Autenticación**  
  Inicio de sesión y registro de usuarios con sistema seguro. Cada usuario tiene acceso individual a sus datos financieros.

- **Ingresos**  
  Registra y visualiza tus entradas de dinero. Útil para llevar un control claro de tus fuentes de ingresos.

- **Ahorros**  
  Administra tus ahorros. Establece montos reservados mensualmente y lleva un seguimiento de tu crecimiento financiero.

- **Metas Financieras**  
  Define objetivos como comprar un coche o pagar una deuda. Controla el progreso hacia tus metas económicas.

- **Informe Mensual**  
  Consulta un Informe detallado de tus ingresos, gastos y ahorros mes a mes para evaluar tu salud financiera.

- **Servicios**  
  Registra y gestiona servicios contratados como agua, luz o internet para llevar control de tus gastos fijos.

- **Períodos**  
  Organiza la información financiera por períodos (ej. mensual, trimestral) para un análisis estructurado.

- **Créditos**  
  Administra deudas o créditos activos, visualiza pagos realizados y saldo pendiente.

- **Miembros del Hogar**  
  Asocia miembros del hogar a los ingresos o gastos, ideal para controlar finanzas familiares.

- **Documentación**  
  Acceso completo a la documentación técnica y manuales de usuario para facilitar el uso y desarrollo del sistema. Incluye guías de instalación, uso, API y solución de problemas.

---

## Tecnologías Utilizadas  

| **Tecnología**           | **Descripción**                                                                                                              |
|--------------------------|------------------------------------------------------------------------------------------------------------------------------|
| **Symfony**              | Framework PHP utilizado para el desarrollo del back-end.                                                                    |
| **EasyAdmin**            | Panel de administración para Symfony, agilizando la gestión de datos.                                                       |
| **Doctrine ORM**         | Mapeo objeto-relacional para manejar la base de datos.                                                                       |
| **PHP 8+**               | Lenguaje principal del backend.                                                                                              |
| **Bootstrap 5**          | Framework CSS para diseño responsive y componentes UI.                                                                       |
| **FontAwesome**          | Iconos vectoriales usados en la interfaz.                                                                                    |
| **Twig**                 | Motor de plantillas para renderizado de vistas en Symfony.                                                                   |
| **JavaScript**           | Para interactividad y mejoras UI.                                                                                            |
| **MySQL / MariaDB**      | Sistema gestor de base de datos relacional.                                                                                  |
| **Doctrine Migrations**  | Control de versiones para esquema de base de datos.                                                                           |
| **Composer**             | Gestión de dependencias en PHP.                                                                                              |
| **Webpack Encore**       | Build tool para assets frontend (JS, CSS).                                                                                   |
| **Git**                  | Control de versiones.                                                                                                        |
| **Symfony Flex**          | Automatización de instalación de paquetes Symfony.                                                                           |
| **PHPUnit**              | Testing unitario para asegurar calidad del código.                                                                           |
| **Docker**               | Plataforma para contenedores que asegura entornos consistentes en el desarrollo.                                             |
| **Docker Compose**       | Herramienta para ejecutar aplicaciones multi-contenedor.                                                                    |
| **Make**                 | Automatiza tareas repetitivas como levantamiento de Docker o ejecución de pruebas.                                           |
| **Linux Mint**           | Sistema operativo basado en Linux, usado para el entorno de desarrollo.                                                      |
| **WSL (Ubuntu)**         | Subsistema Linux para Windows, proporcionando un entorno de desarrollo basado en Linux.                                      |

---

## Instalación  

### Requisitos Previos  

- **Docker** y **Docker Compose** instalados.  
- **Make**: Herramienta para simplificar y automatizar tareas.  

### Pasos de Instalación  

1. Clona el repositorio desde GitHub.  
2. Usa los comandos del archivo **Makefile** para interactuar con la aplicación:  
   - `make init-app`: Configura y levanta los contenedores.  
   - `make up`: Inicia la aplicación.  
   - `make down`: Detiene los contenedores.  
   - `make shell`: Accede al entorno de ejecución del contenedor.  

3. Accede a los siguientes URL:
   - **Aplicación Web**: [http://localhost:8081/](http://localhost:8081/)
   - **PhpMyAdmin**: [http://localhost:8082/](http://localhost:8082/)

---

## Contáctame / Sígueme en mis redes sociales

| Red Social   | Descripción                                              | Enlace                   |
|--------------|----------------------------------------------------------|--------------------------|
| **Facebook** | Conéctate y mantente al tanto de mis actualizaciones.    | [Presiona aquí](https://facebook.com/tu-usuario) |
| **YouTube**  | Fundamentos de la programación, tutoriales y noticias.   | [Presiona aquí](https://youtube.com/tu-canal)     |
| **Página Web** | Más información sobre mis proyectos y servicios.        | [Presiona aquí](https://tusitio.com)              |
| **LinkedIn** | Sigue mi carrera profesional y establece conexiones.     | [Presiona aquí](https://linkedin.com/in/tu-usuario) |
| **Instagram**| Fotos, proyectos y contenido relacionado.                 | [Presiona aquí](https://instagram.com/tu-usuario) |
| **Twitter**  | Proyectos, pensamientos y actualizaciones.                | [Presiona aquí](https://twitter.com/tu-usuario)   |

---
> _"El buen manejo de tus finanzas hoy construye la seguridad del mañana."_