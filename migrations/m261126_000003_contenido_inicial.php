<?php

use yii\db\Migration;

/** Textos y tarjetas de ejemplo para que el sitio no arranque vacío. Todo se edita desde el panel. */
class m261126_000003_contenido_inicial extends Migration
{
    public function safeUp()
    {
        $this->insert('{{%ajustes}}', [
            'nombre' => 'Mi Chef',
            'eslogan' => 'Catering y eventos',
            'descripcion' => 'Comida casera de autor, catering para eventos, alquiler de vajilla y delivery.',
            'tema' => 'brasas',
        ]);

        $this->batchInsert('{{%banner}}', ['titulo', 'subtitulo', 'boton_texto', 'boton_enlace', 'orden'], [
            ['Sabores que se recuerdan', 'Cocina hecha en el momento para tu mesa y tu fiesta', 'Ver comidas', 'comidas', 1],
            ['Tu evento, completo', 'Catering, barra de tragos, DJ, vajilla y mobiliario en un solo lugar', 'Ver servicios', 'servicios', 2],
        ]);

        $nosotros = "Contá acá tu historia: dónde aprendiste, qué te gusta cocinar y cómo trabajás.\n\n"
            . 'Este texto y la foto se cambian desde el panel, en "Textos y secciones".';
        // Un paso por línea, "Título: explicación"
        $pasos = "Contanos tu idea: Fecha, cantidad de personas y qué te gustaría comer.
"
            . "Armamos la propuesta: Menú, servicios y presupuesto a tu medida.
"
            . "Disfrutá: Cocinamos, servimos y nos ocupamos de los detalles.";
        $this->batchInsert('{{%seccion}}', ['clave', 'titulo', 'subtitulo', 'texto', 'orden'], [
            ['comidas', 'Nuestra cocina', 'Especialidades de la casa, para tu evento o para disfrutar en casa', null, 1],
            ['pasos', 'Así de simple', 'Vos disfrutás, nosotros cocinamos', $pasos, 2],
            ['eventos', 'Eventos', 'Cumpleaños de 15, casamientos, empresas y más', null, 3],
            ['servicios', 'Servicios', 'Todo lo que necesitás para no ocuparte de nada', null, 4],
            ['nosotros', 'El chef', 'Pasión por la cocina', $nosotros, 5],
            ['bebidas', 'Bebidas y barra', 'Venta de bebidas y barra de tragos', null, 6],
            ['alquiler', 'Alquiler', 'Vajilla, sillas, mesas y mantelería', null, 7],
            ['galeria', 'De nuestra cocina', 'Platos y momentos que preparamos', null, 8],
            ['contacto', '¿Armamos tu evento?', 'Escribinos y te pasamos un presupuesto sin compromiso', null, 9],
        ]);

        $columnas = ['seccion', 'grupo', 'titulo', 'resumen', 'unidad', 'destacado', 'orden'];
        $this->batchInsert('{{%item}}', $columnas, [
            ['comidas', 'Entradas', 'Tabla de fiambres y quesos', 'Selección de fiambres, quesos, aceitunas y panes caseros.', 'para 4 personas', 1, 1],
            ['comidas', 'Principales', 'Asado completo', 'Cortes a las brasas con ensaladas y salsas de la casa.', 'por persona', 1, 2],
            ['comidas', 'Principales', 'Pastas caseras', 'Ravioles, sorrentinos y tallarines con salsa a elección.', 'por porción', 1, 3],
            ['comidas', 'Postres', 'Mesa dulce', 'Tortas, shots dulces y frutas de estación.', 'por persona', 0, 4],
            ['servicios', null, 'Catering', 'Menús a medida con mozos y cocina en el lugar.', null, 1, 1],
            ['servicios', null, 'Gestión de eventos', 'Organizamos todo: salón, ambientación, horarios y proveedores.', null, 1, 2],
            ['servicios', null, 'DJ y sonido', 'Música, luces y pantalla para tu fiesta.', null, 1, 3],
            ['servicios', null, 'Delivery', 'Pedí tus platos preferidos y te los llevamos.', null, 0, 4],
            ['eventos', null, 'Cumpleaños de 15', 'La noche soñada: recepción, cena, mesa dulce y barra sin alcohol.', null, 1, 1],
            ['eventos', null, 'Casamientos', 'Recepción, banquete, brindis y fin de fiesta.', null, 1, 2],
            ['eventos', null, 'Eventos de empresa', 'Desayunos, coffee breaks, almuerzos y fiestas de fin de año.', null, 0, 3],
            ['alquiler', null, 'Vajilla completa', 'Platos, cubiertos y copas.', 'por persona', 1, 1],
            ['alquiler', null, 'Sillas y mesas', 'Sillas, mesas redondas y tablones.', 'por unidad', 0, 2],
            ['alquiler', null, 'Mantelería', 'Manteles, caminos y servilletas.', 'por unidad', 0, 3],
            ['bebidas', null, 'Barra de tragos', 'Bartender, tragos clásicos y de autor, con y sin alcohol.', 'por persona', 1, 1],
            ['bebidas', null, 'Venta de bebidas', 'Gaseosas, aguas, cervezas y vinos para tu evento.', null, 0, 2],
        ]);
    }

    public function safeDown()
    {
        foreach (['item', 'seccion', 'banner', 'ajustes'] as $tabla) {
            $this->delete("{{%$tabla}}");
        }
    }
}
