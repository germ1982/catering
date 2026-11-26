<?php

/**
 * @var yii\web\View $this
 * @var app\models\LoginForm $modelo
 */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Ingresar';
?>
<div class="container contenido">
    <div class="caja mx-auto" style="max-width: 26rem">
        <h1 class="h3 mb-3">Ingresar</h1>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($modelo, 'usuario')->textInput(['autofocus' => true, 'autocomplete' => 'username']) ?>
        <?= $form->field($modelo, 'clave')->passwordInput(['autocomplete' => 'current-password']) ?>
        <?= $form->field($modelo, 'recordarme')->checkbox() ?>
        <?= Html::submitButton('Entrar', ['class' => 'btn btn-primario w-100']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
