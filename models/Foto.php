<?php

namespace app\models;

use app\components\Fotos;
use yii\db\ActiveRecord;

/**
 * Foto de la galería.
 *
 * @property int $id
 * @property string|null $titulo
 * @property string $archivo
 * @property string $miniatura
 * @property int $orden
 */
class Foto extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%foto}}';
    }

    public function rules()
    {
        return [
            ['titulo', 'trim'],
            ['titulo', 'string', 'max' => 120],
            ['titulo', 'default', 'value' => null],
            ['orden', 'default', 'value' => 0],
            ['orden', 'integer'],
        ];
    }

    /** @return Foto[] */
    public static function ordenadas(?int $limite = null): array
    {
        return static::find()->orderBy(['orden' => SORT_ASC, 'id' => SORT_DESC])->limit($limite)->all();
    }

    public function afterDelete()
    {
        parent::afterDelete();
        Fotos::borrar($this->archivo);
        Fotos::borrar($this->miniatura);
    }
}
