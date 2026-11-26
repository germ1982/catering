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
    // Los colores y detalles de cada uno están en web/css/estilos.css.
    // fuentes: parámetros de Google Fonts. oscuro: Bootstrap en modo dark.
    'temaPredeterminado' => 'parrilla',
    'temas' => [
        'parrilla' => ['nombre' => 'Parrilla', 'desc' => 'Carbón y fuego, letras fuertes. Para asados y brasas.',
            'fuentes' => 'family=Oswald:wght@500;700&family=Inter:wght@400;500;600', 'oscuro' => true],
        'gala' => ['nombre' => 'Gala', 'desc' => 'Marfil, negro y dorado. Para casamientos y recepciones.',
            'fuentes' => 'family=Cormorant+Garamond:wght@600;700&family=Jost:wght@400;500;600', 'oscuro' => false],
        'gala-noche' => ['nombre' => 'Gala Noche', 'desc' => 'Negro y dorado, serif fina. Para fiestas y cenas de noche.',
            'fuentes' => 'family=Cormorant+Garamond:wght@600;700&family=Jost:wght@400;500;600', 'oscuro' => true],
        'campo' => ['nombre' => 'Campo', 'desc' => 'Papel, terracota y oliva. Cocina casera y regional.',
            'fuentes' => 'family=Bitter:wght@600;700&family=Nunito+Sans:wght@400;600;700', 'oscuro' => false],
        'mercado' => ['nombre' => 'Mercado', 'desc' => 'Verde y tomate, formas redondas. Fresco y alegre.',
            'fuentes' => 'family=Fredoka:wght@500;600;700&family=Nunito:wght@400;600;700', 'oscuro' => false],
        'ejecutivo' => ['nombre' => 'Ejecutivo', 'desc' => 'Azul y turquesa, sobrio. Para empresas y eventos corporativos.',
            'fuentes' => 'family=Sora:wght@600;700&family=Source+Sans+3:wght@400;600;700', 'oscuro' => false],
    ],
];
