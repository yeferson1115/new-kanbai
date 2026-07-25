# b2b Alma de las cosas

---

## Requerimientos

- [Composer](https://getcomposer.org/)
- [Node.js y NPM](https://nodejs.org/es/) (Opcional para trabajar y compilar  los assets con Laravel Mix)

---

> Aviso **crear un virtual host** para este proyecto, **es necesario que el directorio public (como se aconseja) del framework funcione como la raíz**, o no funcionara la correcta lectura de las fuentes por parte de font awesome y otras librerias empleadas en este desarrollo.

## Instalación

```
git clone git clone https://github.com/almadelascosas/Kanbai.git
cd Kanbai
composer install
```

Modificar el archivo **.env** con los datos correspondientes al proyecto, credenciales a la base de datos y envió de correo electrónico (recuperación de contraseña).

Migrar a la base de datos los roles y permisos iniciales, así como el **usuario administrador por defecto**.

```
En el directorio BD se encontrara el Script de Base de datos
```
Los datos del **usuario por defecto** podrán ser vistos (y modificados antes de migrar), en los archivos **seeds** del proyecto en **database/seeds**.

---

## Paquetes y dependencias

A continuación el listado de tecnologías y plugins utilizados en este desarrollo.

### Back-end
- [Laravel 8](https://laravel.com/)
- [spatie/laravel-permission 2.7](https://github.com/spatie/laravel-permission)
- [nicolaslopezj/searchable 1.*](https://github.com/nicolaslopezj/searchable)
- [vinkla/hashids 3.3](https://github.com/vinkla/laravel-hashids)
- Entre otros más.

### Front-end

- [Bootstrap 5.0](https://getbootstrap.com/docs/5.0/getting-started/introduction/)
- [Jquery 3.2](https://jquery.com/)
- [Font Awesome 4.7.0](http://fontawesome.io/)
- [jQuery-Autocomplete 1.4.4](https://github.com/devbridge/jQuery-Autocomplete)
- [toastr 2.1.2](http://codeseven.github.io/toastr/)
- [iCheck 1.0.2](http://icheck.fronteed.com/)
- [Pace 1.0.3](http://github.hubspot.com/pace/docs/welcome/)

---


---

