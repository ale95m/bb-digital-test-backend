## BB-Digital-Test-Backend

El proyecto consiste en una aplicación desarrollada en Laravel 10 para un ejemplo ficticio basado en un api para un
e-commerce.

A continuación le guiamos para la puesta en marcha del mismo en un entorno local.

### Requisitos previos

- [PHP 8.1](https://www.php.net/downloads.php)
- [Composer](http://getcomposer.org)

### Instalación y configuración

Al tener clonado el proyecto abra una terminal en la carpeta del repositorio y escriba el comando:

    composer install

Al terminar de instalar los paquetes necesarios copie el archivo “.env.example” y péguelo con el nombre “.env”. Genere
la llave de su aplicación Laravel ejecutando el comando:

    php artisan key:generate

Ahora es tiempo de configurar su acceso a datos. Abra el archivo “.env” y en el debe configurar los parámetros
necesarios para la conexión a su base de datos, esta puede estar alojada en un servidor MySQL, PostgreSQL, SQLServer o
incluso en un archivo SQLite. Hecho esto es hora de correr las migraciones para que se creen las tablas de su base de
datos y ejecutar los seeders para poblarla con algunos datos que le servirón para realizar pruebas. Para esto ejecute el
comando:

    php artisan migrate --seed

Ya está listo para poner en marcha su aplicación Laravel. Puede hacerlo usando un servidor web o simplemente ejecutando
el comando:

    php artisan serve

Este inicia un servidor web en la dirección http://127.0.0.1:8000

Ya está lista para usarlo.

Si lo desea puede comprobar el correcto su correcto funcionamiento ejecutandolos test con el comando:

    php artisan test

### Endpoints

Si usa [Postman](https://www.postman.com/downloads/) puede importar el archivo *BB Test.postman_collection.json* que se encuentra en la raiz del repositorio y contiene una colección con las rutas para que pueda probarlas con comodidad.

| Método|Ruta|Descripcion   |  
|---|---|---|
|POST|   api/login |  Permite iniciar sesión y obtener un token valido por 30 minutos
|GET|    api/logout | Permite cerrar las sesiones del usuario
|GET|    api/products  |  Obtiene los productos paginados y permite realizar filtros por los campos del producto
|POST|   api/products  |  Crea un producto en la base de datos
|GET| api/products/get/count | Obtiene el total de productos que coincidan con los parámetros de filtro especificados
|GET| api/products/get/out_of_stock  | Obtiene todos los productos que no tienen existencias
|POST|    api/products/sell/{product}| Vende un producto
|GET| api/products/{product} | Obtiene los detalles de un producto por su SKU
|PUT| api/products/{product} | Actualiza la información de un producto
|DELETE|  api/products/{product} | Elimina un producto
|GET| api/sales  | Obtiene la lista de artículos vendidos
|GET| api/sales/total | Obtiene el total ingresado por ventas
|GET| api/user |   Obtiene el usuario autenticado


