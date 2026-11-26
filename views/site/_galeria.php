<?php

/**
 * @var yii\web\View $this
 * @var app\models\Foto[] $fotos
 */

use app\components\Fotos;
use yii\helpers\Html;

?>
<div class="galeria">
    <?php foreach ($fotos as $f): ?>
        <button type="button" data-ampliar="<?= Html::encode(Fotos::url($f->archivo)) ?>" data-titulo="<?= Html::encode($f->titulo) ?>">
            <img src="<?= Html::encode(Fotos::url($f->miniatura)) ?>" alt="<?= Html::encode($f->titulo ?: 'Foto') ?>" loading="lazy">
            <?php if ($f->titulo): ?><span><?= Html::encode($f->titulo) ?></span><?php endif; ?>
        </button>
    <?php endforeach; ?>
</div>
