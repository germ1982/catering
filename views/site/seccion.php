<?php

/**
 * Página de una sección: carta, filas o mosaico según config/params.php.
 *
 * @var yii\web\View $this
 * @var string $clave
 * @var app\models\Seccion $bloque
 * @var array<string, app\models\Item[]> $grupos
 */

use app\components\Fotos;
use yii\helpers\Html;
use yii\helpers\Inflector;

$oferta = Yii::$app->params['secciones'][$clave];
$this->title = $bloque->titulo;
if ($bloque->imagen) {
    $this->params['og'] = ['image' => Fotos::urlAbsoluta($bloque->imagen)];
}
$conNombre = array_filter(array_keys($grupos), 'strlen');
?>
<div class="cabecera<?= $bloque->imagen ? ' con-imagen' : '' ?>"<?= $bloque->imagen ? ' style="background-image: url(\'' . Html::encode(Fotos::url($bloque->imagen)) . '\')"' : '' ?>>
    <div class="container"><?= $this->render('_titulo', ['bloque' => $bloque, 'etiqueta' => 'h1']) ?></div>
</div>
<div class="container contenido">
    <?php if ($bloque->texto): ?><div class="texto-bloque text-center"><?= nl2br(Html::encode($bloque->texto)) ?></div><?php endif; ?>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p class="text-center"><?= Html::a('<i class="bi bi-plus-lg"></i> Agregar', ['/panel/item/crear', 'seccion' => $clave], ['class' => 'btn btn-sm btn-primario']) ?></p>
    <?php endif; ?>

    <?php if (count($conNombre) > 1): ?>
        <nav class="grupos">
            <?php foreach ($conNombre as $g): ?><a href="#<?= Inflector::slug($g) ?>"><?= Html::encode($g) ?></a><?php endforeach; ?>
        </nav>
    <?php endif; ?>

    <?php if (!$grupos): ?>
        <p class="text-center opacity-75 py-5">Pronto vas a ver las novedades acá.</p>
    <?php endif; ?>

    <?php foreach ($grupos as $nombre => $items): ?>
        <?php if ($nombre !== ''): ?><h2 class="grupo-titulo" id="<?= Inflector::slug($nombre) ?>"><span><?= Html::encode($nombre) ?></span></h2><?php endif; ?>
        <?= $this->render('_' . $oferta['formato'], ['items' => $items]) ?>
    <?php endforeach; ?>
</div>
