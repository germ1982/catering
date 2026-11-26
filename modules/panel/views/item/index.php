<?php

/**
 * @var yii\web\View $this
 * @var app\models\Item[] $items
 * @var string $seccion
 */

use app\components\Fotos;
use yii\helpers\Html;

$this->title = 'Comidas y servicios';
$secciones = Yii::$app->params['secciones'];
?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <h1 class="h3 mb-0"><?= $this->title ?></h1>
    <?= Html::a('<i class="bi bi-plus-lg"></i> Agregar', ['crear', 'seccion' => $seccion ?: 'comidas'], ['class' => 'btn btn-primario']) ?>
</div>
<nav class="grupos justify-content-start">
    <?= Html::a('Todo', ['index'], ['class' => $seccion === '' ? 'activo' : '']) ?>
    <?php foreach ($secciones as $clave => $s): ?>
        <?= Html::a($s['nombre'], ['index', 'seccion' => $clave], ['class' => $seccion === $clave ? 'activo' : '']) ?>
    <?php endforeach; ?>
</nav>
<div class="table-responsive">
    <table class="table align-middle">
        <thead><tr><th></th><th>Título</th><th>Precio</th><th class="text-center">Portada</th><th class="text-center">Visible</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= $item->miniatura ? Html::img(Fotos::url($item->miniatura), ['class' => 'mini', 'alt' => '']) : '<span class="mini sin-foto"><i class="bi bi-camera"></i></span>' ?></td>
                <td><?= Html::a(Html::encode($item->titulo), ['editar', 'id' => $item->id]) ?>
                    <small class="d-block opacity-75"><?= Html::encode(($secciones[$item->seccion]['nombre'] ?? $item->seccion) . ($item->grupo ? ' · ' . $item->grupo : '')) ?></small></td>
                <td class="text-nowrap"><?= Html::encode($item->precioTexto) ?></td>
                <?php foreach (['destacado' => ['bi-star-fill', 'bi-star'], 'activo' => ['bi-eye-fill', 'bi-eye-slash']] as $campo => [$si, $no]): ?>
                    <td class="text-center">
                        <?= Html::a('<i class="bi ' . ($item->$campo ? $si : $no) . '"></i>', ['alternar', 'id' => $item->id, 'campo' => $campo], [
                            'class' => 'btn btn-sm btn-link', 'data-method' => 'post', 'title' => 'Cambiar', 'aria-label' => "Cambiar $campo",
                        ]) ?>
                    </td>
                <?php endforeach; ?>
                <td class="text-end text-nowrap">
                    <?= Html::a('<i class="bi bi-pencil"></i>', ['editar', 'id' => $item->id], ['class' => 'btn btn-sm btn-contorno', 'aria-label' => 'Editar']) ?>
                    <?= Html::a('<i class="bi bi-trash"></i>', ['borrar', 'id' => $item->id], [
                        'class' => 'btn btn-sm btn-outline-danger', 'data-method' => 'post', 'aria-label' => 'Borrar',
                        'data-confirm' => '¿Borrar «' . $item->titulo . '»?',
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$items): ?><tr><td colspan="6" class="text-center py-4">Todavía no hay nada cargado.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
