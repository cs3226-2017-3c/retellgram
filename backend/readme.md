# Developer's Guide

## Local Setup

### Download Composer and MySQL

* [MySql](https://dev.mysql.com/downloads/mysql/) 
* [Composer](https://www.dev-metal.com/install-update-composer-windows-7-ubuntu-debian-centos/)

### Install dependency via Composer

```
$ composer install
```

### Create local .env file and generate project key

```
$ cp .env.example .env
```

```
$ php artisan key:generate
```

### Setup local env variable

```
$ nano .env
```

and modify

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=[DBNAME]
DB_USERNAME=[USERNAME]
DB_PASSWORD=[PASSWORD]
```

### Extract test images and create symlink to storage
```
$ mkdir -p storage/app/public/images
$ tar -xf test_images.tar.gz -C storage/app/public/images --strip-components 1
$ php artisan storage:link
```

### Migrate and seed database
```
$ php artisan migrate
$ php artisan db:seed --class=CaptionSeeder --env=local
```

### Start website locally
```
$ php artisan serve
```

## Api Document
https://docs.google.com/document/d/1ZWV4OZQNnGvINiJUEVIlFCq5W9ACjPVA2nrzx8Cv4As/edit
