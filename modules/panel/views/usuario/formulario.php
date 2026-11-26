<?php

/**
 * @var yii\web\View $this
 * @var app\models\Usuario $modelo
 * @var bool $propio
 */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = $modelo->isNewRecord ? 'Nuevo usuario' : 'Editar usuario';
?>
<h1 class="h3 mb-3"><?= $this->title ?></h1>
<?php $form = ActiveForm::begin(['options' => ['autocomplete' => 'off']]); ?>
<?= $form->field($modelo, 'nombre')->textInput(['maxlength' => true]) ?>
<?= $form->field($modelo, 'usuario')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
<?= $form->field($modelo, 'clave')->passwordInput(['autocomplete' => 'new-password'])->hint('Mínimo 8 caracteres.') ?>
<?php if (!$propio): ?><?= $form->field($modelo, 'activo')->checkbox() ?><?php endif; ?>
<?= Html::submitButton('Guardar', ['class' => 'btn btn-primario']) ?>
<?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-link']) ?>
<?php ActiveForm::end(); ?>
