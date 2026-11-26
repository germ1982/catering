<?php

/**
 * @var yii\web\View $this
 * @var app\models\Seccion $bloque
 * @var app\models\Foto[] $fotos
 */

use yii\helpers\Html;

$this->title = $bloque->titulo;
?>
<div class="container contenido">
    <?= $this->render('_titulo', ['bloque' => $bloque, 'etiqueta' => 'h1']) ?>
    <?php if (!Yii::$app->user->isGuest): ?>
        <p class="text-center"><?= Html::a('<i class="bi bi-plus-lg"></i> Subir fotos', ['/panel/foto/index'], ['class' => 'btn btn-sm btn-primario']) ?></p>
    <?php endif; ?>
    <?php if ($fotos): ?>
        <?= $this->render('_galeria', ['fotos' => $fotos]) ?>
    <?php else: ?>
        <p class="text-center opacity-75 py-5">Pronto vas a ver fotos acá.</p>
    <?php endif; ?>
</div>
