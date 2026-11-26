<?php

/**
 * @var yii\web\View $this
 * @var app\models\Banner $modelo
 */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = $modelo->isNewRecord ? 'Nuevo banner' : 'Editar banner';
?>
<h1 class="h3 mb-3"><?= $this->title ?></h1>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $form->field($modelo, 'titulo')->textInput(['maxlength' => true]) ?>
<?= $form->field($modelo, 'subtitulo')->textInput(['maxlength' => true]) ?>
<?= $this->render('//layouts/_imagen', ['form' => $form, 'modelo' => $modelo, 'atributo' => 'imagenNueva', 'ayuda' => 'Apaisada, idealmente 1920 × 900 o parecida.']) ?>
<?= $this->render('//layouts/_imagen', ['form' => $form, 'modelo' => $modelo, 'atributo' => 'imagenMovilNueva', 'ayuda' => 'Si no cargás una, en el celular se recorta la apaisada.']) ?>
<div class="row">
    <div class="col-md-5"><?= $form->field($modelo, 'boton_texto')->textInput(['maxlength' => true]) ?></div>
    <div class="col-md-7"><?= $form->field($modelo, 'boton_enlace')->textInput(['maxlength' => true])->hint('Por ejemplo: comidas, eventos, contacto o un link completo.') ?></div>
</div>
<div class="row align-items-end">
    <div class="col-md-4"><?= $form->field($modelo, 'orden')->input('number') ?></div>
    <div class="col-md-4"><?= $form->field($modelo, 'activo')->checkbox() ?></div>
</div>
<?= Html::submitButton('Guardar', ['class' => 'btn btn-primario']) ?>
<?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-link']) ?>
<?php ActiveForm::end(); ?>
