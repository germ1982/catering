<?php

namespace app\models;

use app\components\Fotos;
use Yii;
use yii\web\UploadedFile;

/**
 * Subida de imágenes de un modelo. El modelo declara en fotos() qué campos tiene:
 * [campoDelFormulario => ['campo' => columna, 'miniatura' => columna opcional, 'lado' => px]]
 * En el formulario se puede tildar "quitar[columna]" para borrar la imagen.
 */
trait ConFoto
{
    abstract public static function fotos(): array;

    /** Reglas de validación de los campos de subida */
    protected function reglasFotos(): array
    {
        return [[array_keys(static::fotos()), 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, png, webp',
            'checkExtensionByMimeType' => true, 'maxSize' => Yii::$app->params['fotoMaximoMb'] * 1024 * 1024]];
    }

    /** Toma los archivos del formulario (antes de validar) */
    public function tomarFotos(): void
    {
        foreach (array_keys(static::fotos()) as $atributo) {
            $this->$atributo = UploadedFile::getInstance($this, $atributo);
        }
    }

    /** Guarda las imágenes subidas y borra las marcadas. Devuelve los errores. */
    public function guardarFotos(array $quitar = []): array
    {
        $errores = [];
        $carpeta = trim(static::tableName(), '{}%');
        foreach (static::fotos() as $atributo => $f) {
            $columnas = array_filter([$f['campo'], $f['miniatura'] ?? null]);
            $nuevos = null;
            if ($this->$atributo) {
                $r = Fotos::guardar($this->$atributo, $carpeta, $f['lado'] ?? null);
                if (is_string($r)) {
                    $errores[] = $r;
                    continue;
                }
                $nuevos = [$f['campo'] => $r[0]];
                if (!empty($f['miniatura'])) {
                    $nuevos[$f['miniatura']] = $r[1];
                } else {
                    Fotos::borrar($r[1]);
                }
            } elseif (!empty($quitar[$f['campo']])) {
                $nuevos = array_fill_keys($columnas, null);
            }
            if ($nuevos !== null) {
                foreach ($columnas as $c) {
                    Fotos::borrar($this->$c);
                }
                $this->updateAttributes($nuevos);
            }
        }

        return $errores;
    }

    public function afterDelete()
    {
        parent::afterDelete();
        foreach (static::fotos() as $f) {
            foreach (array_filter([$f['campo'], $f['miniatura'] ?? null]) as $c) {
                Fotos::borrar($this->$c);
            }
        }
    }
}
