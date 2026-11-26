<?php

use yii\db\Migration;

/** Contenido editable del sitio: datos generales, banners, textos, tarjetas y galería */
class m261126_000002_contenido extends Migration
{
    private const OPCIONES = 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';

    public function safeUp()
    {
        $this->createTable('{{%ajustes}}', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string(80)->notNull(),
            'eslogan' => $this->string(160),
            'descripcion' => $this->string(300),
            'logo' => $this->string(160),
            'whatsapp' => $this->string(20),
            'telefono' => $this->string(40),
            'email' => $this->string(120),
            'direccion' => $this->string(160),
            'zona' => $this->string(160),
            'horario' => $this->string(160),
            'instagram' => $this->string(60),
            'facebook' => $this->string(200),
            'tema' => $this->string(20)->notNull(),
        ], self::OPCIONES);

        $this->createTable('{{%banner}}', [
            'id' => $this->primaryKey(),
            'titulo' => $this->string(100),
            'subtitulo' => $this->string(200),
            'imagen' => $this->string(160),
            'imagen_movil' => $this->string(160),
            'boton_texto' => $this->string(40),
            'boton_enlace' => $this->string(200),
            'orden' => $this->integer()->notNull()->defaultValue(0),
            'activo' => $this->boolean()->notNull()->defaultValue(true),
        ], self::OPCIONES);

        $this->createTable('{{%seccion}}', [
            'id' => $this->primaryKey(),
            'clave' => $this->string(30)->notNull()->unique(),
            'titulo' => $this->string(100)->notNull(),
            'subtitulo' => $this->string(200),
            'texto' => $this->text(),
            'imagen' => $this->string(160),
            'orden' => $this->integer()->notNull()->defaultValue(0),
            'visible' => $this->boolean()->notNull()->defaultValue(true),
        ], self::OPCIONES);

        $this->createTable('{{%item}}', [
            'id' => $this->primaryKey(),
            'seccion' => $this->string(30)->notNull(),
            'grupo' => $this->string(60),
            'titulo' => $this->string(120)->notNull(),
            'resumen' => $this->string(220),
            'descripcion' => $this->text(),
            'precio' => $this->decimal(12, 2),
            'unidad' => $this->string(40),
            'imagen' => $this->string(160),
            'miniatura' => $this->string(160),
            'destacado' => $this->boolean()->notNull()->defaultValue(false),
            'activo' => $this->boolean()->notNull()->defaultValue(true),
            'orden' => $this->integer()->notNull()->defaultValue(0),
        ], self::OPCIONES);
        $this->createIndex('idx_item_seccion', '{{%item}}', ['seccion', 'activo', 'orden']);

        $this->createTable('{{%foto}}', [
            'id' => $this->primaryKey(),
            'titulo' => $this->string(120),
            'archivo' => $this->string(160)->notNull(),
            'miniatura' => $this->string(160)->notNull(),
            'orden' => $this->integer()->notNull()->defaultValue(0),
        ], self::OPCIONES);
    }

    public function safeDown()
    {
        foreach (['foto', 'item', 'seccion', 'banner', 'ajustes'] as $tabla) {
            $this->dropTable("{{%$tabla}}");
        }
    }
}
