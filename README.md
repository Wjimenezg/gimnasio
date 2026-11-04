# IronPulse Gym — Sistema de gestión de membresías y control de ingreso

Laravel 13 · PHP 8.4+ · MySQL · Bootstrap 5 (responsivo) · Fetch/AJAX · PHPUnit · GitHub Actions

## 1. Análisis
**Problema real:** en un gimnasio pequeño las membresías se llevan en cuadernos/Excel. Recepción no sabe al instante si un socio pagó, se pierden renovaciones y el dueño no ve cuánto se cobró.
**Solución:** cobro y renovación de membresías, control de ingreso por código (valida vigencia en tiempo real) y panel con vencimientos próximos e ingresos del mes.

| Rol | Puede |
|---|---|
| Recepción | Socios (crear/editar/buscar), cobrar membresías, registrar ingresos, ver panel |
| Administrador | Todo lo anterior + planes/precios + eliminar socios |

**Requisitos clave:** RF1 login/logout · RF2 CRUD socios · RF3 planes (admin) · RF4 cobro/renovación (si aún está vigente, la nueva empieza al terminar la actual) · RF5 ingreso por código vía AJAX · RF6 búsqueda, filtro y paginación · RF7 panel. RNF: móvil + PC, validación cliente/servidor, seguridad.

## 2. Modelo de datos (MySQL)
```
users(id, name, email, password, role)
planes(id, nombre, precio, dias)                    1 ──< membresias
socios(id, codigo UNIQUE, nombre, telefono, email, activo)  1 ──< membresias, 1 ──< asistencias
membresias(id, socio_id FK, plan_id FK, inicio, fin, monto, metodo)
asistencias(id, socio_id FK, entrada)
```

## 3. Planificación (4 sprints)
1. Repositorio Git, Laravel, BD, login y roles · 2. Socios + planes (CRUD, validaciones) · 3. Cobros, ingreso AJAX, panel · 4. Pruebas, CI, despliegue y presentación.
Git: rama `main` + ramas `feature/*` con Pull Request; CI corre las pruebas en cada push.

## 4. Cómo ejecutarlo en VS Code
Requisitos: PHP 8.4+, Composer, Node no es necesario, MySQL (XAMPP, Laragon o Docker).
```bash
git clone https://github.com/Wjimenezg/gimnasio.git
cd gimnasio
composer install
cp .env.example .env          # ya viene configurado para MySQL, base "gimnasio" y español
php artisan key:generate
```
Crea la base vacía (`CREATE DATABASE gimnasio CHARACTER SET utf8mb4;` en phpMyAdmin o consola) y:
```bash
php artisan migrate --seed
php artisan serve        # http://127.0.0.1:8000
php artisan test         # pruebas
```
Usuarios de prueba (contraseña `password`): `admin@gym.test` y `recepcion@gym.test`. Los códigos de socio de prueba son G0001–G0025.
Bootstrap se carga por CDN, así que el navegador necesita internet.

## 5. Seguridad aplicada
Contraseñas con bcrypt · CSRF en formularios y en fetch · regeneración de sesión al entrar · Eloquent (sin SQL inyectable) · Blade escapa la salida (XSS) · autorización por rol con middleware · validación en servidor y cliente.

## 6. Despliegue
Railway/Render/hosting con PHP: `composer install --no-dev`, configurar variables `.env` de producción (`APP_ENV=production`, `APP_DEBUG=false`, BD MySQL gestionada), `php artisan migrate --force`.

## 7. Guion de presentación (10 min)
Problema del negocio → roles y requisitos → modelo de datos → demo (login, cobrar, ingreso de socio vigente y vencido, panel) → seguridad y pruebas → CI/Git → despliegue y mejoras futuras (reportes, pagos en línea, app del socio).
