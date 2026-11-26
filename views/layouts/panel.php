<?php

/**
 * Layout del panel: menú a la izquierda (arriba en el celular) y el contenido.
 *
 * @var yii\web\View $this
 * @var string $content
 */

use app\components\Migraciones;
use yii\helpers\Html;

$usuario = Yii::$app->user->identity;
$actual = Yii::$app->controller->id;
$menu = [
    ['item', 'bi-grid-3x3-gap', 'Comidas y servicios'],
    ['banner', 'bi-image', 'Banners de portada'],
    ['seccion', 'bi-card-text', 'Textos y secciones'],
    ['foto', 'bi-images', 'Galería'],
    ['ajustes', 'bi-shop', 'Datos y estilo del sitio'],
    ['usuario', 'bi-people', 'Usuarios'],
];
?>
<?php $this->beginContent('@app/views/layouts/main.php') ?>
<div class="container contenido">
    <div class="row g-4">
        <aside class="col-lg-3">
            <nav class="menu-panel">
                <div class="menu-panel-titulo d-none d-lg-block">
                    <i class="bi bi-speedometer2"></i> Panel de control
                    <small><?= Html::encode($usuario->nombre) ?></small>
                </div>
                <?php foreach ($menu as [$id, $icono, $nombre]): ?>
                    <?= Html::a("<i class=\"bi $icono\"></i> $nombre", ["/panel/$id/index"], [
                        'class' => 'menu-panel-enlace' . ($actual === $id ? ' activo' : ''),
                    ]) ?>
                <?php endforeach; ?>
                <?= Html::a('<i class="bi bi-eye"></i> Ver el sitio', ['/site/index'], ['class' => 'menu-panel-enlace']) ?>
            </nav>
        </aside>
        <div class="col-lg-9">
            <?php if ($pendientes = Migraciones::pendientes()): ?>
                <div class="alert alert-warning d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <span><i class="bi bi-database-exclamation"></i> Hay <?= count($pendientes) ?> actualizaciones de la base de datos pendientes.</span>
                    <?= Html::beginForm(['/panel/mantenimiento/aplicar'], 'post') ?>
                    <?= Html::submitButton('Aplicar ahora', ['class' => 'btn btn-sm btn-warning']) ?>
                    <?= Html::endForm() ?>
                </div>
            <?php endif; ?>
            <?= $content ?>
        </div>
    </div>
</div>
<?php $this->endContent() ?>
