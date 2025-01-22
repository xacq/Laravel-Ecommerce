Aspectos a considerar en el proyecto

# INSTALACION DE COMPOSER
1. Ir a la pagina oficial de COMPOSER
    https://getcomposer.org/
2. Descargar el instalador desde la pagina inicial
    https://getcomposer.org/download/
3. El archivo instalador es Composer-Setup.exe
4. En un cmd prompt excribir 
    C:\>composer
    ______
    / ____/___  ____ ___  ____  ____  ________  _____
    / /   / __ \/ __ `__ \/ __ \/ __ \/ ___/ _ \/ ___/
    / /___/ /_/ / / / / / / /_/ / /_/ (__  )  __/ /
    \____/\____/_/ /_/ /_/ .___/\____/____/\___/_/
                        /_/
    Composer version 2.8.3 2024-11-17 13:13:04

    Usage:
    command [options] [arguments] ...

# ACTUALIZACION DE COMPOSER 
1. Escribe la siguiente instruccion en un cmd o command prompt
    composer self-update
2. Luego verifica la version actual de composer en el sistema
    C:\>composer --version
    Composer version 2.8.3 2024-11-17 13:13:04
    PHP version 8.2.12 (C:\xampp\php\php.exe)
    Run the "diagnose" command to get more detailed diagnostics output.

    C:\>composer diagnose
    Checking platform settings: OK
    Checking git settings: OK git version 2.46.1
    Checking http connectivity to packagist: OK
    Checking https connectivity to packagist: OK
    Checking github.com rate limit: OK
    Checking disk free space: OK ...

# ACTUALIZACION DE PAQUETES COMPOSER
1. Accede al php.ini de tu sistema y activa la extension gd y la extension zip
    ;extension=gd
    ;extension=zip
    se debe retirar el punto y coma para activar la extension
2. Verificar que la extension GD y la ZIP este habilitada
C:\>php -m
    [PHP Modules]
    bcmath
    ...
    ftp
    *gd
    gettext
    ...
    xmlwriter
    *zip
    zlib

# CORRER COMPOSER PARA INSTALAR PAQUETES DEL SISTEMA
1. Ejecutar el comando en un command prompt
    PS C:\tesisappsistem> composer install
    Installing dependencies from lock file (including require-dev)
    Verifying lock file contents can be installed on current platform.
    Package operations: 147 installs, 0 updates, 0 removals
    - Downloading php-http/discovery (1.19.4)
    - Downloading pestphp/pest-plugin (v1.1.0)
    - Downloading doctrine/inflector (2.0.10)
    - Downloading doctrine/lexer (3.0.1)
    - Downloading masterminds/html5 (2.9.0)
    - Downloading symfony/polyfill-mbstring (v1.30.0) ...

# EJECUTAR LA APLICACION
1. Asegurarse de tener la base de datos en Mysql a traves del archivo .sql, caso contrario ejecutar las migrations del sistema
2. Luego de gestionar la base de datos, verificar que en el archivo .env este configurado adecuadamente el nombre de la base de datos, tipo de base de datos, etc.
    ...
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=tesisappsistemdb
    DB_USERNAME=root
    DB_PASSWORD=
    ...
3. Ejecutar la opcion de ejecucion de artisan
    php artisan serve


