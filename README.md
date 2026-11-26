# Catering y eventos

Sitio para un chef: comidas, catering, eventos, alquiler de vajilla y mobiliario, bebidas y delivery.
Yii2 basic, MySQL/MariaDB y Bootstrap 5.

## Qué tiene

- **Portada** con carrusel de banners, especialidades, "Así de simple" (pasos), eventos, servicios, el chef, bebidas, alquiler, galería y contacto.
- **Carta** por grupos (Entradas, Principales, Postres…) con **"Tu pedido"**: el visitante agrega platos y bebidas y lo manda por WhatsApp. El pedido queda en su navegador; no se guarda en el servidor.
- **Pedido de presupuesto** para eventos (tipo, fecha, personas, qué incluir), que también sale por WhatsApp.
- Compartir por WhatsApp y Facebook con vista previa.
- 5 estilos (Parrilla, Gala, Campo, Mercado y Ejecutivo). Solo quien inicia sesión puede cambiarlo, con el botón **Estilo**.
- Reutilizable para otro negocio: nombre, textos, contacto, opciones del presupuesto, fotos y estilo están en la base, no en el código.

Los botones de pedido y consulta por WhatsApp aparecen cuando se carga el número en el panel.

## Panel (`/ingresar`)

No hay roles: quien inicia sesión puede editar todo.

| Sección del panel | Qué se edita |
|---|---|
| Comidas y servicios | Tarjetas de comidas, servicios, eventos, alquiler y bebidas: foto, textos, precio, grupo, destacado, visible |
| Banners de portada | Imágenes grandes (con versión para celular), textos y botón |
| Textos y secciones | Título, subtítulo, texto, imagen, orden y visibilidad de cada bloque |
| Galería | Fotos (varias a la vez o desde la cámara) |
| Datos del sitio | Nombre, logo, contacto, redes y opciones del presupuesto |
| Estilo del sitio | Selector con miniaturas de los 5 estilos |
| Usuarios | Quiénes pueden entrar |

## Instalación en XAMPP

Requisitos: PHP 8.1 o más nuevo con `gd`, `exif` y `fileinfo` (en `php.ini`: `extension=gd`; para `--zip` también `extension=zip`), MySQL/MariaDB y Apache con `mod_rewrite`.

1. `composer install`
2. `CREATE DATABASE catering CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;`
3. Copiar `.env.example` como `.env` y completarlo.
4. `php yii migrate`
5. `php yii usuario/crear`
6. Abrir `http://localhost/catering/`

## Cambios en la base

Siempre con una migración: `php yii migrate/create nombre`, escribir `safeUp()` / `safeDown()` y `php yii migrate`.

## Publicar en InfinityFree

Copiar `deploy/sitios.example.ini` como `deploy/sitios.ini` (queda solo en tu PC) y seguir `deploy/LEEME.txt`.
