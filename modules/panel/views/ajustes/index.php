<?php

/**
 * @var yii\web\View $this
 * @var app\models\Ajustes $modelo
 */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Datos y estilo del sitio';
?>
<h1 class="h3 mb-3"><?= $this->title ?></h1>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $form->field($modelo, 'nombre')->textInput(['maxlength' => true]) ?>
<?= $form->field($modelo, 'eslogan')->textInput(['maxlength' => true]) ?>
<?= $form->field($modelo, 'descripcion')->textarea(['rows' => 2, 'maxlength' => true]) ?>
<?= $this->render('//layouts/_imagen', ['form' => $form, 'modelo' => $modelo, 'atributo' => 'logoNuevo', 'ayuda' => 'Cuadrado queda mejor. Se muestra junto al nombre.']) ?>
<?= $form->field($modelo, 'tema')->dropDownList(array_map(fn($t) => $t['nombre'], Yii::$app->params['temas'])) ?>
<h2 class="h5 mt-4">Contacto</h2>
<div class="row">
    <?php foreach (['whatsapp', 'telefono', 'email', 'direccion', 'zona', 'horario', 'instagram', 'facebook'] as $campo): ?>
        <div class="col-md-6"><?= $form->field($modelo, $campo)->textInput() ?></div>
    <?php endforeach; ?>
</div>
<p class="small opacity-75">Sin WhatsApp cargado no aparecen los botones de pedido ni de consulta.</p>
<?= Html::submitButton('Guardar', ['class' => 'btn btn-primario']) ?>
<?php ActiveForm::end(); ?>
