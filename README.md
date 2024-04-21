## Proyecto Laravel para Linktic

Este es un proyecto Laravel simple que cumple con los requisitos especificados en la tarea de desarrollo del 17 de abril de 2024. Proporciona funcionalidad básica de autenticación, CRUD para empresas y empleados, generación de documentación Swagger y más.

## Configuración y Ejecución

Para configurar y ejecutar este proyecto en tu entorno local, sigue estos pasos:

### Prerrequisitos

- **[PHP >= 7.4]()**
- **[Composer]()**
- **[Node.js y NPM]()**
- **[Git]()**

## Pasos de instalación

Asegúrate de tener instalados los siguientes requisitos previos:

1. Clona este repositorio en tu máquina local:
````bash
    git clone https://github.com/andyBlack13/linktic-laravel.git
````

2. Navega hasta el directorio del proyecto:

````bash
    cd linktic-laravel
````

3. Instala las dependencias de PHP utilizando Composer:

````bash
    composer install
````

4. Instala las dependencias de JavaScript utilizando NPM:

````bash
    npm install
````

5. Copia el archivo de configuración `.env.example` y créalo como `.env`:

````bash
    cp .env.example .env
````

6. Configura tu archivo .env con la información correspondiente y comenta la linea sqlite, por ejemplo:

````bash
    APP_NAME=Linktic-Laravel
    APP_URL="http://localhost:8000"

    # DB_CONNECTION=sqlite
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=linktic-laravel
    DB_USERNAME=root
    DB_PASSWORD=
````

6. Genera una clave de aplicación única:

````bash
    php artisan key:generate
````

7. Configura tu base de datos en el archivo `.env` y luego ejecuta las migraciones de la base de datos para crear las tablas necesarias:

````bash
    php artisan migrate
````

8. Ejecuta las semillas de la base de datos para poblar la base de datos con datos de ejemplo:

````bash
    php artisan db:seed
````
````bash
    php artisan db:seed --class=RolesSeeder
````
````bash
    php artisan db:seed --class=CompaniesSeeder
````
````bash
    php artisan db:seed --class=EmployeesSeeder
````
````bash
    php artisan db:seed --class=RolesCompanySeeder
````

## Ejecución

Una vez que hayas completado la configuración, puedes iniciar el servidor de desarrollo de Laravel ejecutando el siguiente comando:

1. Corre el proyecto
````bash
    php artisan serve
````

2. Abre otra pestaña de terminal, navega hasta la carpeta del proyecto y ejecuta
````bash
    npm run dev
````

3. Visita http://localhost:8000 en tu navegador para ver la aplicación en funcionamiento.

##  Documentación de API - Swagger
La documentación de la API está disponible en /api/documentation una vez que el servidor está en funcionamiento. Puedes acceder a ella a través de tu navegador web.

