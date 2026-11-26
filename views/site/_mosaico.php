<?php

/**
 * Fotos grandes con el título encima.
 *
 * @var yii\web\View $this
 * @var app\models\Item[] $items
 */

use app\components\Fotos;
use yii\helpers\Html;

?>
<div class="mosaico">
    <?php foreach ($items as $item): ?>
        <?php $seccion = Yii::$app->params['secciones'][$item->seccion]; ?>
        <a class="mosaico-pieza<?= $item->activo ? '' : ' oculta' ?>" href="<?= Html::encode($item->getUrl()) ?>">
            <?php if ($item->imagen): ?>
                <img src="<?= Html::encode(Fotos::url($item->imagen)) ?>" alt="" loading="lazy">
            <?php else: ?>
                <span class="sin-foto"><i class="bi <?= $seccion['icono'] ?>"></i></span>
            <?php endif; ?>
            <span class="mosaico-texto">
                <strong><?= Html::encode($item->titulo) ?></strong>
                <?php if ($item->resumen): ?><span><?= Html::encode($item->resumen) ?></span><?php endif; ?>
            </span>
        </a>
    <?php endforeach; ?>
</div>
