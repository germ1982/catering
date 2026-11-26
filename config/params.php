<?php

return [
    // Fotos (GD): peso máximo, lado mayor en píxeles y calidad del JPG
    'fotoMaximoMb' => 12,
    'fotoLadoMaximo' => 1600,
    'fotoLadoBanner' => 1920,
    'fotoLadoMiniatura' => 600,
    'fotoCalidadJpg' => 85,

    // Secciones de la oferta: cada una tiene su página (/comidas, /servicios, ...) y su forma de mostrarse:
    // carta (como el menú de un restaurante), filas (foto y texto alternados) o mosaico (fotos grandes).
    // pedido: permite armar un pedido y mandarlo por WhatsApp.
    // Los títulos y textos se editan en el panel ("Textos y secciones").
    'secciones' => [
        'comidas' => ['nombre' => 'Comidas', 'icono' => 'bi-egg-fried', 'formato' => 'carta', 'pedido' => true, 'boton' => 'Pedir por WhatsApp'],
        'servicios' => ['nombre' => 'Servicios', 'icono' => 'bi-stars', 'formato' => 'filas', 'pedido' => false, 'boton' => 'Consultar por WhatsApp'],
        'eventos' => ['nombre' => 'Eventos', 'icono' => 'bi-balloon-heart', 'formato' => 'mosaico', 'pedido' => false, 'boton' => 'Consultar fecha'],
        'alquiler' => ['nombre' => 'Alquiler', 'icono' => 'bi-box-seam', 'formato' => 'carta', 'pedido' => false, 'boton' => 'Consultar disponibilidad'],
        'bebidas' => ['nombre' => 'Bebidas', 'icono' => 'bi-cup-straw', 'formato' => 'carta', 'pedido' => true, 'boton' => 'Pedir por WhatsApp'],
    ],

    // Estilos del sitio: se elige uno en el panel y lo ven todos los visitantes.
    // fuente: familia de Google Fonts para los títulos. oscuro: Bootstrap en modo dark.
    'temaPredeterminado' => 'brasas',
    'temas' => [
        'brasas' => ['nombre' => 'Brasas (oscuro y cálido)', 'fuente' => 'Playfair Display', 'oscuro' => true],
        'gourmet' => ['nombre' => 'Gourmet (crema y bordó)', 'fuente' => 'Playfair Display', 'oscuro' => false],
        'huerta' => ['nombre' => 'Huerta (verde oliva)', 'fuente' => 'Lora', 'oscuro' => false],
        'fiesta' => ['nombre' => 'Fiesta (violeta y dorado)', 'fuente' => 'Poppins', 'oscuro' => true],
        'fresco' => ['nombre' => 'Fresco (blanco y naranja)', 'fuente' => 'Poppins', 'oscuro' => false],
    ],
];
