<?php

/**
 * Como la carta de un restaurante: foto chica, nombre, puntos y precio.
 *
 * @var yii\web\View $this
 * @var app\models\Item[] $items
 */

use app\components\Fotos;
use app\models\Ajustes;
use yii\helpers\Html;

$conPedido = (bool)Ajustes::actual()->whatsapp;
?>
<ul class="carta">
    <?php foreach ($items as $item): ?>
        <?php $seccion = Yii::$app->params['secciones'][$item->seccion]; ?>
        <li class="plato<?= $item->activo ? '' : ' oculta' ?>">
            <a class="plato-foto" href="<?= Html::encode($item->getUrl()) ?>" tabindex="-1" aria-hidden="true">
                <?php if ($item->miniatura): ?>
                    <img src="<?= Html::encode(Fotos::url($item->miniatura)) ?>" alt="" loading="lazy">
                <?php else: ?>
                    <span class="sin-foto"><i class="bi <?= $seccion['icono'] ?>"></i></span>
                <?php endif; ?>
            </a>
            <div class="plato-datos">
                <div class="plato-linea">
                    <h3><?= Html::a(Html::encode($item->titulo), $item->getUrl()) ?></h3>
                    <span class="puntos" aria-hidden="true"></span>
                    <span class="precio"><?= Html::encode($item->precioTexto) ?></span>
                </div>
                <?php if ($item->resumen): ?><p><?= Html::encode($item->resumen) ?></p><?php endif; ?>
                <div class="plato-pie">
                    <?php if ($item->unidad): ?><small><?= Html::encode($item->unidad) ?></small><?php endif; ?>
                    <?php if ($seccion['pedido'] && $conPedido): ?>
                        <button type="button" class="agregar" data-agregar="<?= $item->id ?>" data-nombre="<?= Html::encode($item->titulo) ?>"
                                data-precio="<?= (float)$item->precio ?>"><i class="bi bi-plus-circle"></i> Agregar al pedido</button>
                    <?php endif; ?>
                    <?php if (!Yii::$app->user->isGuest): ?>
                        <?= Html::a('<i class="bi bi-pencil"></i> Editar' . ($item->activo ? '' : ' (oculta)'), ['/panel/item/editar', 'id' => $item->id], ['class' => 'editar']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
