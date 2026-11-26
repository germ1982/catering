<?php

/**
 * @var yii\web\View $this
 * @var app\models\Item $modelo
 * @var string[] $grupos
 */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = $modelo->isNewRecord ? 'Agregar' : 'Editar: ' . $modelo->titulo;
?>
<h1 class="h3 mb-3"><?= Html::encode($this->title) ?></h1>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="row">
    <div class="col-md-6"><?= $form->field($modelo, 'seccion')->dropDownList(array_map(fn($s) => $s['nombre'], Yii::$app->params['secciones'])) ?></div>
    <div class="col-md-6"><?= $form->field($modelo, 'grupo')->textInput(['list' => 'grupos', 'maxlength' => true]) ?></div>
</div>
<datalist id="grupos"><?php foreach ($grupos as $g): ?><option value="<?= Html::encode($g) ?>"><?php endforeach; ?></datalist>
<?= $form->field($modelo, 'titulo')->textInput(['maxlength' => true]) ?>
<?= $form->field($modelo, 'resumen')->textInput(['maxlength' => true]) ?>
<?= $form->field($modelo, 'descripcion')->textarea(['rows' => 6]) ?>
<div class="row">
    <div class="col-md-6"><?= $form->field($modelo, 'precio')->textInput(['inputmode' => 'decimal']) ?></div>
    <div class="col-md-6"><?= $form->field($modelo, 'unidad')->textInput(['maxlength' => true]) ?></div>
</div>
<?= $this->render('//layouts/_imagen', ['form' => $form, 'modelo' => $modelo, 'atributo' => 'imagenNueva', 'ayuda' => 'La foto del plato o servicio. Conviene apaisada y con buena luz.']) ?>
<div class="row align-items-end">
    <div class="col-md-4"><?= $form->field($modelo, 'orden')->input('number') ?></div>
    <div class="col-md-4"><?= $form->field($modelo, 'destacado')->checkbox() ?></div>
    <div class="col-md-4"><?= $form->field($modelo, 'activo')->checkbox() ?></div>
</div>
<?= Html::submitButton('Guardar', ['class' => 'btn btn-primario']) ?>
<?= Html::a('Cancelar', ['index', 'seccion' => $modelo->seccion], ['class' => 'btn btn-link']) ?>
<?php ActiveForm::end(); ?>
