<?php

/**
 * @var yii\web\View $this
 * @var app\models\Ajustes $sitio
 */

use app\components\Fotos;
use app\models\Seccion;
use yii\helpers\Html;
use yii\helpers\Url;

$ruta = Yii::$app->controller->route;
$actual = Yii::$app->request->get('seccion');
$otras = ['galeria' => 'Galería', 'nosotros' => 'Nosotros', 'contacto' => 'Contacto'];
$menu = [];
foreach (Seccion::todas() as $clave => $s) {
    if (!$s->visible || $clave === 'pasos') {
        continue;
    }
    $tarjetas = Yii::$app->params['secciones'][$clave] ?? null;
    $menu[] = [
        $tarjetas['nombre'] ?? ($otras[$clave] ?? $s->titulo),
        $tarjetas ? ['/site/seccion', 'seccion' => $clave] : ["/site/$clave"],
        $tarjetas ? ($ruta === 'site/seccion' && $actual === $clave) : $ruta === "site/$clave",
    ];
}
?>
<header class="barra-superior sticky-top">
    <nav class="navbar navbar-expand-xl">
        <div class="container">
            <a class="navbar-brand marca" href="<?= Url::home() ?>">
                <?php if ($sitio->logo): ?>
                    <img src="<?= Html::encode(Fotos::url($sitio->logo)) ?>" alt="">
                <?php else: ?>
                    <i class="bi bi-fire"></i>
                <?php endif; ?>
                <span><?= Html::encode($sitio->nombre) ?><?php if ($sitio->eslogan): ?><small><?= Html::encode($sitio->eslogan) ?></small><?php endif; ?></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Menú">
                <i class="bi bi-list"></i>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto align-items-xl-center">
                    <?php foreach ($menu as [$nombre, $url, $activo]): ?>
                        <li class="nav-item"><?= Html::a(Html::encode($nombre), $url, ['class' => 'nav-link' . ($activo ? ' active' : '')]) ?></li>
                    <?php endforeach; ?>
                    <?php if (!Yii::$app->user->isGuest): ?>
                        <li class="nav-item ms-xl-2"><?= Html::a('<i class="bi bi-pencil-square"></i> Panel', ['/panel/item/index'], ['class' => 'btn btn-sm btn-primario']) ?></li>
                        <li class="nav-item">
                            <?= Html::beginForm(['/site/salir'], 'post') ?>
                            <?= Html::submitButton('<i class="bi bi-box-arrow-right"></i> Salir', ['class' => 'btn btn-link nav-link']) ?>
                            <?= Html::endForm() ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
