<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Títulos y textos de cada bloque del sitio. Las claves son fijas (las crea la migración).
 *
 * @property int $id
 * @property string $clave
 * @property string $titulo
 * @property string|null $subtitulo
 * @property string|null $texto
 * @property string|null $imagen
 * @property int $orden
 * @property bool $visible
 */
class Seccion extends ActiveRecord
{
    use ConFoto;

    public $imagenNueva;

    private static ?array $_todas = null;

    public static function tableName()
    {
        return '{{%seccion}}';
    }

    public static function fotos(): array
    {
        return ['imagenNueva' => ['campo' => 'imagen']];
    }

    /** @return Seccion[] indexadas por clave, en orden */
    public static function todas(): array
    {
        return self::$_todas ??= static::find()->orderBy(['orden' => SORT_ASC, 'id' => SORT_ASC])->indexBy('clave')->all();
    }

    public static function porClave(string $clave): self
    {
        return self::todas()[$clave] ?? new static(['clave' => $clave, 'titulo' => ucfirst($clave), 'visible' => true]);
    }

    public function rules()
    {
        return array_merge([
            [['titulo', 'subtitulo', 'texto'], 'trim'],
            ['titulo', 'required'],
            ['titulo', 'string', 'max' => 100],
            ['subtitulo', 'string', 'max' => 200],
            ['texto', 'string', 'max' => 8000],
            ['orden', 'integer'],
            ['visible', 'boolean'],
            [['subtitulo', 'texto'], 'default', 'value' => null],
        ], $this->reglasFotos());
    }

    public function attributeLabels()
    {
        return [
            'titulo' => 'Título',
            'subtitulo' => 'Subtítulo',
            'texto' => 'Texto',
            'imagenNueva' => 'Imagen',
            'orden' => 'Orden en la portada',
            'visible' => 'Visible en el sitio',
        ];
    }
}
