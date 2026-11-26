<?php

/**
 * Campo de imagen de un formulario del panel: vista de la actual, "quitar", subida y cámara.
 *
 * @var yii\web\View $this
 * @var yii\bootstrap5\ActiveForm $form
 * @var yii\db\ActiveRecord $modelo
 * @var string $atributo   campo de subida (ej. imagenNueva)
 * @var string $ayuda
 */

use app\components\Fotos;
use yii\helpers\Html;

$f = $modelo::fotos()[$atributo];
$actual = $modelo->{$f['campo']};
$id = Html::getInputId($modelo, $atributo);
?>
<div class="campo-imagen">
    <?php if ($actual): ?>
        <div class="imagen-actual">
            <img src="<?= Html::encode(Fotos::url($actual)) ?>" alt="">
            <label class="form-check"><input type="checkbox" class="form-check-input" name="quitar[<?= $f['campo'] ?>]" value="1"> Quitar esta imagen</label>
        </div>
    <?php endif; ?>
    <?= $form->field($modelo, $atributo)->fileInput([
        'accept' => 'image/jpeg,image/png,image/webp',
        'data-comprimir' => $f['lado'] ?? Yii::$app->params['fotoLadoMaximo'],
        'data-vista-previa' => "#$id-previa",
    ])->hint($ayuda ?? 'JPG, PNG o WEBP.') ?>
    <?= $this->render('//layouts/_camara', ['destino' => "#$id"]) ?>
    <div class="previa" id="<?= $id ?>-previa"></div>
</div>
