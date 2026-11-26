<?php

/**
 * @var yii\web\View $this
 * @var app\models\Ajustes $sitio
 */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<footer class="pie mt-auto">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h2 class="h5"><?= Html::encode($sitio->nombre) ?></h2>
                <p class="mb-0 opacity-75"><?= Html::encode($sitio->descripcion) ?></p>
            </div>
            <div class="col-md-4"><?= $this->render('_contacto', ['sitio' => $sitio]) ?></div>
            <div class="col-md-4 text-md-end">
                <?= $this->render('_compartir', ['url' => Url::to(['/site/tarjeta'], true), 'titulo' => $sitio->nombre]) ?>
            </div>
        </div>
        <div class="pie-final">
            <span>© <?= date('Y') ?> <?= Html::encode($sitio->nombre) ?></span>
            <?php if (Yii::$app->user->isGuest): ?>
                <?= Html::a('<i class="bi bi-lock"></i> Ingresar', ['/site/ingresar'], ['rel' => 'nofollow']) ?>
            <?php endif; ?>
        </div>
    </div>
</footer>
