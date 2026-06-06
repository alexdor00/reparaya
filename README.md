
# ReparaYa - Aplicacion de Gestion de Reparaciones

Aplicacion web para la gestion de averias domesticas (fontaneria, electricidad, carpinteria, etc.) desarrollada en PHP puro con arquitectura MVC, sin uso de frameworks. Permite a clientes solicitar tecnicos, a administradores gestionar incidencias y calendarios, y a tecnicos consultar su agenda de trabajo.

## Tecnologias usadas

- PHP 8.1
- MySQL 8.0
- Bootstrap 5.3
- FullCalendar 6.1.8
- Docker y Docker Compose
- PDO con sentencias preparadas
- Git y GitHub

## Requisitos previos

- Docker Desktop instalado y en ejecucion
- Git instalado
- Navegador web moderno

## Instalacion en local paso a paso

**1. Clona el repositorio:**
git clone https://github.com/alexdor00/reparaya.git
cd reparaya

**2. Arranca los contenedores Docker:**
docker-compose up -d --build

Esto levanta tres contenedores:
- PHP 8.1 con Apache en el puerto 8080
- MySQL 8.0 en el puerto 3306
- phpMyAdmin en el puerto 8081

**3. Importa la base de datos:**

Abre el navegador y entra a http://localhost:8081
- Usuario: root
- Password: root

Haz clic en la base de datos reparaya, luego en la pestana SQL y pega el contenido del archivo database.sql. Dale a continuar.

**4. Entra a la aplicacion:**

http://localhost:8080/public/index.php

## Usuarios de prueba

| Rol | Email | Contrasena |
|---|---|---|
| Administrador | admin@reparaya.com | password |
| Tecnico | tecnico@reparaya.com | password |
| Cliente | cliente@reparaya.com | password |

## Funcionalidades

**Panel Administrador:**
- Ver, crear, editar y cancelar incidencias
- Asignar tecnicos a cada incidencia
- Visualizar calendario mensual, semanal y diario con colores por prioridad
- Gestionar tecnicos (alta y baja)
- Gestionar tipos de servicio (fontaneria, electricidad, etc.)

**Panel Cliente:**
- Registro e inicio de sesion
- Crear solicitudes de servicio con restriccion de 48 horas para servicios estandar
- Ver listado de sus avisos pasados y futuros
- Cancelar solicitudes con mas de 48 horas de antelacion
- Modificar datos de perfil

**Panel Tecnico:**
- Consultar servicios asignados para hoy
- Consultar proximos servicios
- Modificar datos de perfil

## Estructura del proyecto
reparaya/
├── app/
│   ├── controllers/
│   │   ├── AuthController.php          # Login, registro y logout
│   │   ├── IncidenciaController.php    # Crear y cancelar incidencias cliente
│   │   ├── AdminController.php         # Gestion completa de incidencias admin
│   │   ├── TecnicoController.php       # Alta y baja de tecnicos
│   │   ├── TipoServicioController.php  # Gestion de tipos de servicio
│   │   └── PerfilController.php        # Modificar datos de perfil
│   └── views/
│       ├── home.php                    # Pagina de presentacion publica
│       ├── login.php                   # Formulario de acceso
│       ├── registro.php                # Formulario de registro
│       ├── perfil.php                  # Modificar perfil
│       ├── admin/
│       │   ├── dashboard.php           # Panel principal admin
│       │   ├── incidencias.php         # Listado de incidencias
│       │   ├── nueva_incidencia.php    # Crear incidencia
│       │   ├── editar_incidencia.php   # Editar incidencia
│       │   ├── calendario.php          # Calendario con FullCalendar
│       │   ├── tecnicos.php            # Listado de tecnicos
│       │   ├── nuevo_tecnico.php       # Crear tecnico
│       │   └── tipos_servicio.php      # Gestion de tipos
│       ├── cliente/
│       │   ├── dashboard.php           # Panel principal cliente
│       │   ├── mis_avisos.php          # Listado de solicitudes
│       │   └── nueva_incidencia.php    # Nueva solicitud
│       └── tecnico/
│           └── dashboard.php           # Agenda del tecnico
├── config/
│   └── database.php                    # Configuracion conexion BD
├── public/
│   └── index.php                       # Punto de entrada de la app
├── assets/
│   ├── css/                            # Estilos propios
│   └── js/                             # Scripts propios
├── database.sql                        # Base de datos exportada
└── docker-compose.yml                  # Configuracion Docker

## URL en produccion

https://fp064.techlab.uoc.edu/~uocx7/public/index.php

## Arquitectura MVC

La aplicacion sigue el patron Modelo-Vista-Controlador:

- **Modelo:** La capa de datos se gestiona directamente mediante PDO en los controladores, conectando con las tablas usuarios, incidencias y tipos_servicio.
- **Vista:** Archivos PHP en app/views que generan el HTML que ve el usuario.
- **Controlador:** Archivos PHP en app/controllers que reciben las peticiones, consultan la base de datos y redirigen a la vista correspondiente.

## Seguridad

- Passwords encriptadas con password_hash y verificadas con password_verify
- Sentencias preparadas con PDO para evitar inyeccion SQL
- Control de sesiones para proteger cada panel segun el rol del usuario
