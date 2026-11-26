<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Imagen grande de la portada (carrusel).
 *
 * @property int $id
 * @property string|null $titulo
 * @property string|null $subtitulo
 * @property string|null $imagen
 * @property string|null $imagen_movil
 * @property string|null $boton_texto
 * @property string|null $boton_enlace
 * @property int $orden
 * @property bool $activo
 */
class Banner extends ActiveRecord
{
    use ConFoto;

    public $imagenNueva;
    public $imagenMovilNueva;

    public static function tableName()
    {
        return '{{%banner}}';
    }

    public static function fotos(): array
    {
        return [
            'imagenNueva' => ['campo' => 'imagen', 'lado' => 1920],
            'imagenMovilNueva' => ['campo' => 'imagen_movil', 'lado' => 1600],
        ];
    }

    public function rules()
    {
        return array_merge([
            [['titulo', 'subtitulo', 'boton_texto', 'boton_enlace'], 'trim'],
            ['titulo', 'string', 'max' => 100],
            [['subtitulo', 'boton_enlace'], 'string', 'max' => 200],
            ['boton_texto', 'string', 'max' => 40],
            // Una página del sitio (comidas) o un link completo
            ['boton_enlace', 'match', 'pattern' => '#^(https?://\S+|[\w\-/]+)$#',
                'message' => 'Escribí una página del sitio (ej. comidas) o un link que empiece con https://'],
            ['orden', 'default', 'value' => 0],
            ['orden', 'integer'],
            ['activo', 'boolean'],
            [['titulo', 'subtitulo', 'boton_texto', 'boton_enlace'], 'default', 'value' => null],
        ], $this->reglasFotos());
    }

    public function attributeLabels()
    {
        return [
            'titulo' => 'Título',
            'subtitulo' => 'Subtítulo',
            'imagenNueva' => 'Imagen (apaisada)',
            'imagenMovilNueva' => 'Imagen para celular (opcional, vertical)',
            'boton_texto' => 'Texto del botón',
            'boton_enlace' => 'A dónde lleva el botón',
            'orden' => 'Orden',
            'activo' => 'Visible',
        ];
    }

    public function enlace(): ?string
    {
        if (!$this->boton_enlace) {
            return null;
        }

        return preg_match('#^https?://#', $this->boton_enlace)
            ? $this->boton_enlace
            : rtrim(Url::home(), '/') . '/' . ltrim($this->boton_enlace, '/');
    }
}
