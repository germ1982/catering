<?php

/**
 * @var yii\web\View $this
 * @var app\models\Seccion $modelo
 */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Editar: ' . $modelo->titulo;
?>
<h1 class="h3 mb-3"><?= Html::encode($this->title) ?></h1>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $form->field($modelo, 'titulo')->textInput(['maxlength' => true]) ?>
<?= $form->field($modelo, 'subtitulo')->textInput(['maxlength' => true]) ?>
<?php $campo = $form->field($modelo, 'texto')->textarea(['rows' => 7]); ?>
<?= $modelo->clave === 'pasos' ? $campo->hint('Un paso por línea, así: Título del paso: explicación.') : $campo ?>
<?php if (!in_array($modelo->clave, ['pasos', 'galeria', 'contacto'], true)): ?>
    <?= $this->render('//layouts/_imagen', ['form' => $form, 'modelo' => $modelo, 'atributo' => 'imagenNueva',
        'ayuda' => $modelo->clave === 'nosotros' ? 'La foto del chef.' : 'Fondo del encabezado de la página de esta sección.']) ?>
<?php endif; ?>
<div class="row align-items-end">
    <div class="col-md-4"><?= $form->field($modelo, 'orden')->input('number') ?></div>
    <div class="col-md-4"><?= $form->field($modelo, 'visible')->checkbox() ?></div>
</div>
<?= Html::submitButton('Guardar', ['class' => 'btn btn-primario']) ?>
<?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-link']) ?>
<?php ActiveForm::end(); ?>
