<?php

/**
 * @var yii\web\View $this
 * @var app\models\Banner[] $banners
 */

use app\components\Fotos;
use yii\helpers\Html;

$this->title = 'Banners de portada';
?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <h1 class="h3 mb-0"><?= $this->title ?></h1>
    <?= Html::a('<i class="bi bi-plus-lg"></i> Agregar banner', ['crear'], ['class' => 'btn btn-primario']) ?>
</div>
<p class="opacity-75">Son las imágenes grandes que van pasando arriba de la portada.</p>
<div class="table-responsive">
    <table class="table align-middle">
        <thead><tr><th></th><th>Título</th><th>Orden</th><th>Visible</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($banners as $b): ?>
            <tr>
                <td><?= $b->imagen ? Html::img(Fotos::url($b->imagen), ['class' => 'mini mini-ancha', 'alt' => '']) : '<span class="mini mini-ancha sin-foto"><i class="bi bi-camera"></i></span>' ?></td>
                <td><?= Html::a(Html::encode($b->titulo ?: '(sin título)'), ['editar', 'id' => $b->id]) ?>
                    <small class="d-block opacity-75"><?= Html::encode($b->subtitulo) ?></small></td>
                <td><?= $b->orden ?></td>
                <td><?= $b->activo ? 'Sí' : 'No' ?></td>
                <td class="text-end text-nowrap">
                    <?= Html::a('<i class="bi bi-pencil"></i>', ['editar', 'id' => $b->id], ['class' => 'btn btn-sm btn-contorno', 'aria-label' => 'Editar']) ?>
                    <?= Html::a('<i class="bi bi-trash"></i>', ['borrar', 'id' => $b->id], [
                        'class' => 'btn btn-sm btn-outline-danger', 'data-method' => 'post', 'data-confirm' => '¿Borrar este banner?', 'aria-label' => 'Borrar',
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$banners): ?><tr><td colspan="5" class="text-center py-4">Sin banners.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
