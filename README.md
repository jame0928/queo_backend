<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Acerca del proyecto

Este proyecto tiene como finalidad proporcionar una API Rest funcional, para la administracion de empresas y empleados solicitados en la prueba tecnica de QUEO


## Como realizar la instalación local

Para ejecutar el proyecto en su entorno local lleve a cabo los siguientes pasos:

- Ubiquese en el directorio local donde quiere hacer la instalación
- Desde una terminal ejecute el comando git clone https://github.com/jame0928/queo_backend.git
- una vez descargado el respositorio, ejecute el comando composer install, para descragar todas las dependencias necesarias.
- A continuación, cree el archivo .env y copie el contenido del archivo .env.example en el archivo recien creado.
- Modifique la variable APP_URL asignando el nombre del servidor local que utiliza para la ejecucion de sus proyectos php, por ejemplo APP_URL=http://localhost:8000
- Cambie los datos de conexion de la base de datos, y en DB_DATABASE, asignar el nombre de una base de datos limpia que halla creado previamente para este proyecto.
- Ubique la variable FILESYSTEM_DRIVER y cambie su valor por public
- Ejecute el comando php artisan jwt:secret, para generar su llave privada para el uso de jwt
- Inicie su servidor por ejemplo: php artisan serve --port=8000
- Ejecute el comando php artisan migrate, para generar las tablas requeridas.
- Ejecute el comando php artisan db:seed --class=DatabaseSeeder, que se encargará de poblar la base de datos con la informacion de prueba
- finalmente puede probar la Api, realizando una peticion POST con Postam a la ruta localhost:8000/api/v1/auth/login enviando como parametros email=admin@admin.com y password=contraseña. Si todo el proceso esta ok, deberia poder ver un access_token en la respuesta.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
