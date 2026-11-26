<?php

/**
 * @var yii\web\View $this
 * @var string $name
 * @var string $message
 */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="container contenido text-center py-5">
    <h1><?= Html::encode($name) ?></h1>
    <p><?= nl2br(Html::encode($message)) ?></p>
    <?= Html::a('Volver al inicio', ['/site/index'], ['class' => 'btn btn-primario']) ?>
</div>
