<?php

/**
 * Foto grande y texto, alternando de lado.
 *
 * @var yii\web\View $this
 * @var app\models\Item[] $items
 */

use app\components\Fotos;
use yii\helpers\Html;

?>
<div class="filas">
    <?php foreach ($items as $item): ?>
        <?php $seccion = Yii::$app->params['secciones'][$item->seccion]; ?>
        <article class="fila<?= $item->activo ? '' : ' oculta' ?>">
            <a class="fila-foto" href="<?= Html::encode($item->getUrl()) ?>" tabindex="-1" aria-hidden="true">
                <?php if ($item->imagen): ?>
                    <img src="<?= Html::encode(Fotos::url($item->imagen)) ?>" alt="" loading="lazy">
                <?php else: ?>
                    <span class="sin-foto"><i class="bi <?= $seccion['icono'] ?>"></i></span>
                <?php endif; ?>
            </a>
            <div class="fila-texto">
                <h3><?= Html::encode($item->titulo) ?></h3>
                <?php if ($item->resumen): ?><p><?= Html::encode($item->resumen) ?></p><?php endif; ?>
                <?php if ($item->precio !== null): ?>
                    <p class="precio"><?= Html::encode($item->precioTexto) ?> <small><?= Html::encode($item->unidad) ?></small></p>
                <?php endif; ?>
                <?= Html::a('Conocé más <i class="bi bi-arrow-right"></i>', $item->getUrl(), ['class' => 'btn btn-contorno']) ?>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?= Html::a('<i class="bi bi-pencil"></i> Editar' . ($item->activo ? '' : ' (oculta)'), ['/panel/item/editar', 'id' => $item->id], ['class' => 'editar ms-2']) ?>
                <?php endif; ?>
            </div>
        </article>
    <?php endforeach; ?>
</div>
