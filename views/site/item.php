<?php

/**
 * @var yii\web\View $this
 * @var app\models\Item $item
 * @var app\models\Item[] $otros
 */

use app\components\Fotos;
use app\models\Ajustes;
use yii\helpers\Html;

$sitio = Ajustes::actual();
$seccion = Yii::$app->params['secciones'][$item->seccion];
$this->title = $item->titulo;
$this->params['descripcion'] = $item->resumen;
if ($item->imagen) {
    $this->params['og'] = ['image' => Fotos::urlAbsoluta($item->imagen)];
}
$mensaje = '¡Hola! Me interesa: ' . $item->titulo . ' (' . $item->getUrlCompartir() . ')';
?>
<div class="container contenido">
    <p><?= Html::a('<i class="bi bi-arrow-left"></i> ' . $seccion['nombre'], ['/site/seccion', 'seccion' => $item->seccion], ['class' => 'volver']) ?></p>
    <div class="row g-4">
        <div class="col-md-6">
            <?php if ($item->imagen): ?>
                <button type="button" class="ficha-foto" data-ampliar="<?= Html::encode(Fotos::url($item->imagen)) ?>">
                    <img src="<?= Html::encode(Fotos::url($item->imagen)) ?>" alt="<?= Html::encode($item->titulo) ?>">
                </button>
            <?php else: ?>
                <div class="ficha-foto"><span class="sin-foto"><i class="bi <?= $seccion['icono'] ?>"></i></span></div>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <?php if ($item->grupo): ?><span class="antetitulo"><?= Html::encode($item->grupo) ?></span><?php endif; ?>
            <h1><?= Html::encode($item->titulo) ?></h1>
            <p class="precio precio-grande"><?= Html::encode($item->precioTexto) ?>
                <?php if ($item->unidad): ?><small><?= Html::encode($item->unidad) ?></small><?php endif; ?>
            </p>
            <?php if ($item->resumen): ?><p class="lead"><?= Html::encode($item->resumen) ?></p><?php endif; ?>
            <?php if ($item->descripcion): ?><div class="texto-bloque"><?= nl2br(Html::encode($item->descripcion)) ?></div><?php endif; ?>
            <div class="d-flex flex-wrap gap-2 my-3">
                <?php if ($seccion['pedido'] && $sitio->whatsapp): ?>
                    <button type="button" class="btn btn-lg btn-primario" data-agregar="<?= $item->id ?>" data-nombre="<?= Html::encode($item->titulo) ?>"
                            data-precio="<?= (float)$item->precio ?>"><i class="bi bi-plus-circle"></i> Agregar al pedido</button>
                <?php endif; ?>
                <?php if ($sitio->whatsapp): ?>
                    <?= Html::a('<i class="bi bi-whatsapp"></i> ' . ($seccion['pedido'] ? 'Consultar' : $seccion['boton']), $sitio->whatsappUrl($mensaje),
                        ['class' => 'btn btn-lg ' . ($seccion['pedido'] ? 'btn-contorno' : 'btn-primario'), 'target' => '_blank', 'rel' => 'noopener']) ?>
                <?php else: ?>
                    <?= Html::a($seccion['boton'], ['/site/contacto'], ['class' => 'btn btn-lg btn-primario']) ?>
                <?php endif; ?>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?= Html::a('<i class="bi bi-pencil"></i> Editar', ['/panel/item/editar', 'id' => $item->id], ['class' => 'btn btn-lg btn-contorno']) ?>
                <?php endif; ?>
            </div>
            <?= $this->render('//layouts/_compartir', ['url' => $item->getUrlCompartir(), 'titulo' => $item->titulo]) ?>
        </div>
    </div>
    <?php if ($otros): ?>
        <h2 class="grupo-titulo"><span>También te puede gustar</span></h2>
        <?= $this->render('_mosaico', ['items' => $otros]) ?>
    <?php endif; ?>
</div>
