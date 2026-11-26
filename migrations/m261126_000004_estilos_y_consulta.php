<?php

use yii\db\Migration;

/**
 * Las opciones del formulario de presupuesto pasan a la base (cada negocio carga las suyas)
 * y los sitios que tenían un estilo anterior pasan al estilo predeterminado nuevo.
 */
class m261126_000004_estilos_y_consulta extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%ajustes}}', 'tipos_evento', $this->text());
        $this->addColumn('{{%ajustes}}', 'extras_evento', $this->text());

        // Una opción por línea
        $this->update('{{%ajustes}}', [
            'tipos_evento' => implode("\n", ['Cumpleaños de 15', 'Casamiento', 'Evento de empresa', 'Cumpleaños o reunión',
                'Solo catering', 'Alquiler', 'Bebidas o barra de tragos', 'Otro']),
            'extras_evento' => implode("\n", ['Comida', 'Barra de tragos', 'Bebidas', 'DJ y sonido', 'Vajilla y sillas', 'Organización']),
        ]);
        $this->update('{{%ajustes}}', ['tema' => 'parrilla'], ['tema' => ['brasas', 'gourmet', 'huerta', 'fiesta', 'fresco']]);
    }

    public function safeDown()
    {
        $this->update('{{%ajustes}}', ['tema' => 'brasas']);
        $this->dropColumn('{{%ajustes}}', 'extras_evento');
        $this->dropColumn('{{%ajustes}}', 'tipos_evento');
    }
}
