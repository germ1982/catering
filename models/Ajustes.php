<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Datos generales del sitio (una sola fila).
 *
 * @property string $nombre
 * @property string|null $eslogan
 * @property string|null $descripcion
 * @property string|null $logo
 * @property string|null $whatsapp
 * @property string|null $telefono
 * @property string|null $email
 * @property string|null $direccion
 * @property string|null $zona
 * @property string|null $horario
 * @property string|null $instagram
 * @property string|null $facebook
 * @property string $tema
 */
class Ajustes extends ActiveRecord
{
    use ConFoto;

    public $logoNuevo;

    private static ?Ajustes $_actual = null;

    public static function tableName()
    {
        return '{{%ajustes}}';
    }

    public static function fotos(): array
    {
        return ['logoNuevo' => ['campo' => 'logo', 'lado' => 600]];
    }

    /** Los datos del sitio (se leen una sola vez por pedido) */
    public static function actual(): self
    {
        return self::$_actual ??= static::find()->orderBy('id')->one()
            ?? new static(['nombre' => 'Mi Chef', 'tema' => Yii::$app->params['temaPredeterminado']]);
    }

    public function rules()
    {
        $textos = ['nombre', 'eslogan', 'descripcion', 'whatsapp', 'telefono', 'email', 'direccion', 'zona', 'horario', 'instagram', 'facebook'];

        return array_merge([
            [$textos, 'trim'],
            ['nombre', 'required'],
            ['nombre', 'string', 'max' => 80],
            ['eslogan', 'string', 'max' => 160],
            ['descripcion', 'string', 'max' => 300],
            ['whatsapp', 'filter', 'filter' => fn($v) => preg_replace('/\D+/', '', (string)$v)],
            ['whatsapp', 'string', 'min' => 8, 'max' => 20, 'tooShort' => 'Escribí el número completo con código de país, por ejemplo 5492991234567.'],
            ['telefono', 'string', 'max' => 40],
            ['email', 'email'],
            ['email', 'string', 'max' => 120],
            [['direccion', 'zona', 'horario'], 'string', 'max' => 160],
            ['instagram', 'filter', 'filter' => fn($v) => ltrim((string)$v, '@')],
            ['instagram', 'match', 'pattern' => '/^[\w.]{1,60}$/', 'message' => 'Escribí solo el usuario de Instagram (ej. michef).'],
            ['facebook', 'url', 'defaultScheme' => 'https'],
            ['facebook', 'string', 'max' => 200],
            ['tema', 'in', 'range' => array_keys(Yii::$app->params['temas'])],
            [array_diff($textos, ['nombre']), 'default', 'value' => null],
        ], $this->reglasFotos());
    }

    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre del sitio',
            'eslogan' => 'Frase corta (debajo del nombre)',
            'descripcion' => 'Descripción (se ve al compartir el link)',
            'logoNuevo' => 'Logo (opcional)',
            'whatsapp' => 'WhatsApp (con código de país, ej. 5492991234567)',
            'telefono' => 'Teléfono',
            'email' => 'Correo electrónico',
            'direccion' => 'Dirección',
            'zona' => 'Zona de cobertura / delivery',
            'horario' => 'Horario de atención',
            'instagram' => 'Instagram (usuario)',
            'facebook' => 'Facebook (link de la página)',
            'tema' => 'Estilo del sitio',
        ];
    }

    public function whatsappUrl(string $texto = ''): ?string
    {
        if (!$this->whatsapp) {
            return null;
        }

        return 'https://wa.me/' . $this->whatsapp . ($texto !== '' ? '?text=' . rawurlencode($texto) : '');
    }
}
