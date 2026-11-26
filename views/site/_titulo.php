<?php

/**
 * Encabezado de un bloque o de una página.
 *
 * @var yii\web\View $this
 * @var app\models\Seccion $bloque
 * @var string $etiqueta h1 o h2
 */

use yii\helpers\Html;

?>
<div class="titulo-bloque">
    <?= Html::tag($etiqueta, Html::encode($bloque->titulo)) ?>
    <?php if ($bloque->subtitulo): ?><p><?= Html::encode($bloque->subtitulo) ?></p><?php endif; ?>
    <?php if (!Yii::$app->user->isGuest && $bloque->id): ?>
        <?= Html::a('<i class="bi bi-pencil"></i> Editar texto', ['/panel/seccion/editar', 'id' => $bloque->id], ['class' => 'editar']) ?>
    <?php endif; ?>
</div>
