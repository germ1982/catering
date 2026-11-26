<?php

/**
 * @var yii\web\View $this
 * @var app\models\Seccion $bloque
 * @var string $etiqueta
 */

use app\components\Fotos;
use yii\helpers\Html;

?>
<div class="row align-items-center g-4 justify-content-center">
    <?php if ($bloque->imagen): ?>
        <div class="col-md-5"><img class="img-fluid imagen-chef" src="<?= Html::encode(Fotos::url($bloque->imagen)) ?>" alt=""></div>
    <?php endif; ?>
    <div class="<?= $bloque->imagen ? 'col-md-7' : 'col-lg-8' ?>">
        <?= $this->render('_titulo', ['bloque' => $bloque, 'etiqueta' => $etiqueta]) ?>
        <?php if ($bloque->texto): ?><div class="texto-bloque text-center"><?= nl2br(Html::encode($bloque->texto)) ?></div><?php endif; ?>
    </div>
</div>
