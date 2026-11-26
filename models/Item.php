<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\helpers\Url;

/**
 * Tarjeta de una sección: un plato, un servicio, un tipo de evento, algo para alquilar o una bebida.
 *
 * @property int $id
 * @property string $seccion
 * @property string|null $grupo
 * @property string $titulo
 * @property string|null $resumen
 * @property string|null $descripcion
 * @property string|null $precio
 * @property string|null $unidad
 * @property string|null $imagen
 * @property string|null $miniatura
 * @property bool $destacado
 * @property bool $activo
 * @property int $orden
 */
class Item extends ActiveRecord
{
    use ConFoto;

    public $imagenNueva;

    public static function tableName()
    {
        return '{{%item}}';
    }

    public static function fotos(): array
    {
        return ['imagenNueva' => ['campo' => 'imagen', 'miniatura' => 'miniatura']];
    }

    public function rules()
    {
        return array_merge([
            [['grupo', 'titulo', 'resumen', 'descripcion', 'unidad'], 'trim'],
            [['seccion', 'titulo'], 'required'],
            ['seccion', 'in', 'range' => array_keys(Yii::$app->params['secciones'])],
            ['grupo', 'string', 'max' => 60],
            ['titulo', 'string', 'max' => 120],
            ['resumen', 'string', 'max' => 220],
            ['descripcion', 'string', 'max' => 8000],
            ['unidad', 'string', 'max' => 40],
            ['precio', 'filter', 'filter' => [self::class, 'normalizarPrecio']],
            ['precio', 'number', 'min' => 0, 'max' => 9999999999, 'enableClientValidation' => false,
                'message' => 'Escribí solo el número, por ejemplo 12500 o 12.500,50.'],
            ['orden', 'default', 'value' => 0],
            ['orden', 'integer'],
            [['destacado', 'activo'], 'boolean'],
            [['grupo', 'resumen', 'descripcion', 'unidad', 'precio'], 'default', 'value' => null],
        ], $this->reglasFotos());
    }

    public function attributeLabels()
    {
        return [
            'seccion' => 'Sección',
            'grupo' => 'Grupo (opcional, ej. Entradas)',
            'titulo' => 'Título',
            'resumen' => 'Resumen (se ve en la tarjeta)',
            'descripcion' => 'Descripción completa',
            'precio' => 'Precio (vacío = "Consultar")',
            'unidad' => 'Unidad (ej. por persona)',
            'imagenNueva' => 'Foto',
            'destacado' => 'Destacar en la portada',
            'activo' => 'Visible',
            'orden' => 'Orden (el menor aparece primero)',
        ];
    }

    /** Acepta 12500, 12.500 o 12.500,50 */
    public static function normalizarPrecio($valor): ?string
    {
        $texto = preg_replace('/[$\s]/', '', (string)$valor);
        if ($texto === '') {
            return null;
        }
        if (str_contains($texto, ',')) {
            $texto = str_replace(['.', ','], ['', '.'], $texto);
        } elseif (preg_match('/^\d{1,3}(\.\d{3})+$/', $texto)) {
            $texto = str_replace('.', '', $texto);
        }

        return $texto;
    }

    public function getPrecioTexto(): string
    {
        if ($this->precio === null) {
            return 'Consultar';
        }
        $decimales = fmod((float)$this->precio, 1) ? 2 : 0;

        return '$ ' . number_format((float)$this->precio, $decimales, ',', '.');
    }

    public function getUrl(bool $absoluta = false): string
    {
        return Url::to(['/site/item', 'id' => $this->id, 'slug' => Inflector::slug($this->titulo)], $absoluta);
    }

    /** Link para compartir (con vista previa en WhatsApp) */
    public function getUrlCompartir(): string
    {
        return Url::to(['/site/tarjeta', 'id' => $this->id, 'slug' => Inflector::slug($this->titulo)], true);
    }

    /** Consultas públicas: solo lo visible, en orden */
    public static function visibles(): ActiveQuery
    {
        return static::find()->where(['activo' => 1])->orderBy(['orden' => SORT_ASC, 'id' => SORT_ASC]);
    }
}
