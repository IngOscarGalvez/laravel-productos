# Laravel Productos - CRUD con Filament

Este es un proyecto Laravel 12 que implementa un sistema de gestión de productos y categorías utilizando **Filament Admin Panel**, **Livewire** y **Eloquent ORM**.

---

## 🧰 Tecnologías

- Laravel 12
- Filament Admin Panel (FilamentPHP)
- Livewire
- TailwindCSS
- SQLite (modo testing)
- MySQL (modo producción/desarrollo)
- PHPUnit

---

## 🚀 Instalación

1. Clona el repositorio:

```bash
git clone https://github.com/tuusuario/laravel-productos.git
cd laravel-productos
```

2. Instala las dependencias:

```bash
composer install
npm install && npm run build
```

3. Configura el archivo `.env`:

```bash
cp .env.example .env
php artisan key:generate
```

4. Configura tu base de datos en `.env` y luego ejecuta las migraciones:

```bash
php artisan migrate --seed
```

5. Crea el symlink para el almacenamiento de archivos:

```bash
php artisan storage:link
```

6. Inicia el servidor:

```bash
php artisan serve
```

---

## 🔐 Acceso al panel Filament

Ingresa al panel de administración:

```
http://localhost:8000/admin
```

> El login de Filament depende de tu implementación. Si deseas implementar autenticación de admin, puedes usar `Filament::auth()` o cualquier middleware.

---

## ✅ Funcionalidades

- CRUD completo de Categorías (nombre)
- CRUD completo de Productos:
  - Nombre
  - Precio (con máscara de dinero)
  - Descripción
  - Categoría relacionada
  - Imagen del producto (con vista previa)
  - Stock (número)
  - Estado de agotado dinámico (`Sí / No`)
- Filtros por categoría en el listado de productos

---

## 🧪 Tests

El proyecto incluye pruebas automatizadas con PHPUnit para validar el CRUD de categorías y productos.

Ejecuta los tests:

```bash
php artisan test
```

---

## 🖼️ Imágenes

Las imágenes se almacenan en `storage/app/public/products` y se sirven mediante el symlink de `storage`.

---

## 🧑 Autor

Desarrollado por [Tu Nombre] – [@tuusuario](https://github.com/tuusuario)

---

## 📄 Licencia

Este proyecto está bajo la licencia MIT.
