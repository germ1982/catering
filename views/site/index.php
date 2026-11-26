<?php

/**
 * Portada: carrusel de banners y los bloques visibles, en el orden elegido en el panel.
 *
 * @var yii\web\View $this
 * @var app\models\Banner[] $banners
 * @var app\models\Seccion[] $secciones
 * @var array<string, app\models\Item[]> $destacados
 * @var app\models\Foto[] $fotos
 */

use app\components\Fotos;
use app\models\Ajustes;
use yii\helpers\Html;

$sitio = Ajustes::actual();
if ($banners && $banners[0]->imagen) {
    $this->params['og'] = ['image' => Fotos::urlAbsoluta($banners[0]->imagen)];
}
$externo = ['target' => '_blank', 'rel' => 'noopener'];
$alterno = false;
?>
<?php if ($banners): ?>
<div id="portada" class="carousel slide carousel-fade portada" data-bs-ride="carousel" data-bs-interval="6000">
    <?php if (count($banners) > 1): ?>
        <div class="carousel-indicators">
            <?php foreach ($banners as $i => $b): ?>
                <button type="button" data-bs-target="#portada" data-bs-slide-to="<?= $i ?>"<?= $i ? '' : ' class="active"' ?> aria-label="Banner <?= $i + 1 ?>"></button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="carousel-inner">
        <?php foreach ($banners as $i => $b): ?>
            <div class="carousel-item<?= $i ? '' : ' active' ?>">
                <?php if ($b->imagen || $b->imagen_movil): ?>
                    <picture>
                        <?php if ($b->imagen_movil): ?><source media="(max-width: 767px)" srcset="<?= Html::encode(Fotos::url($b->imagen_movil)) ?>"><?php endif; ?>
                        <img src="<?= Html::encode(Fotos::url($b->imagen ?: $b->imagen_movil)) ?>" alt="">
                    </picture>
                <?php endif; ?>
                <div class="portada-texto">
                    <div class="container">
                        <?php if ($sitio->eslogan): ?><span class="antetitulo"><?= Html::encode($sitio->eslogan) ?></span><?php endif; ?>
                        <?php if ($b->titulo): ?><h2><?= Html::encode($b->titulo) ?></h2><?php endif; ?>
                        <?php if ($b->subtitulo): ?><p><?= Html::encode($b->subtitulo) ?></p><?php endif; ?>
                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            <?php if ($b->boton_texto && $b->enlace()): ?>
                                <?= Html::a(Html::encode($b->boton_texto), $b->enlace(), ['class' => 'btn btn-lg btn-primario']) ?>
                            <?php endif; ?>
                            <?= Html::a('Pedir presupuesto', ['/site/contacto'], ['class' => 'btn btn-lg btn-claro']) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if (count($banners) > 1): ?>
        <button class="carousel-control-prev" type="button" data-bs-target="#portada" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span><span class="visually-hidden">Anterior</span></button>
        <button class="carousel-control-next" type="button" data-bs-target="#portada" data-bs-slide="next"><span class="carousel-control-next-icon"></span><span class="visually-hidden">Siguiente</span></button>
    <?php endif; ?>
    <?php if (!Yii::$app->user->isGuest): ?>
        <?= Html::a('<i class="bi bi-pencil"></i> Editar banners', ['/panel/banner/index'], ['class' => 'btn btn-sm btn-claro editar-portada']) ?>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php foreach ($secciones as $clave => $bloque): ?>
    <?php
    $oferta = Yii::$app->params['secciones'][$clave] ?? null;
    if (!$bloque->visible || ($oferta && empty($destacados[$clave])) || ($clave === 'galeria' && !$fotos)) {
        continue;
    }
    $alterno = !$alterno;
    ?>
    <section class="bloque bloque-<?= $clave ?><?= $alterno ? '' : ' bloque-alterno' ?>" id="<?= $clave ?>">
        <div class="container">
            <?php if ($clave === 'nosotros'): ?>
                <?= $this->render('_nosotros', ['bloque' => $bloque, 'etiqueta' => 'h2']) ?>

            <?php elseif ($clave === 'pasos'): ?>
                <?= $this->render('_titulo', ['bloque' => $bloque, 'etiqueta' => 'h2']) ?>
                <ol class="pasos">
                    <?php foreach (preg_split('/\R+/', (string)$bloque->texto, -1, PREG_SPLIT_NO_EMPTY) as $linea): ?>
                        <?php [$paso, $detalle] = array_pad(explode(':', $linea, 2), 2, ''); ?>
                        <li><h3><?= Html::encode(trim($paso)) ?></h3><p><?= Html::encode(trim($detalle)) ?></p></li>
                    <?php endforeach; ?>
                </ol>

            <?php else: ?>
                <?= $this->render('_titulo', ['bloque' => $bloque, 'etiqueta' => 'h2']) ?>
                <?php if ($bloque->texto): ?><div class="texto-bloque text-center"><?= nl2br(Html::encode($bloque->texto)) ?></div><?php endif; ?>

                <?php if ($oferta): ?>
                    <?php // En la portada las comidas se lucen en grande; los servicios, en mosaico ?>
                    <?php $formato = ['comidas' => 'filas', 'servicios' => 'mosaico'][$clave] ?? $oferta['formato']; ?>
                    <?= $this->render('_' . $formato, ['items' => $destacados[$clave]]) ?>
                    <div class="text-center mt-4">
                        <?= Html::a(($clave === 'comidas' ? 'Ver la carta completa' : 'Ver todo en ' . $oferta['nombre']) . ' <i class="bi bi-arrow-right"></i>',
                            ['/site/seccion', 'seccion' => $clave], ['class' => 'btn btn-primario']) ?>
                    </div>
                <?php elseif ($clave === 'galeria'): ?>
                    <?= $this->render('_galeria', ['fotos' => $fotos]) ?>
                    <div class="text-center mt-4"><?= Html::a('Ver la galería <i class="bi bi-arrow-right"></i>', ['/site/galeria'], ['class' => 'btn btn-contorno']) ?></div>
                <?php else: ?>
                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        <?php if ($sitio->whatsapp): ?>
                            <?= Html::a('<i class="bi bi-whatsapp"></i> Escribinos', $sitio->whatsappUrl('¡Hola! Quiero hacer una consulta.'), ['class' => 'btn btn-lg btn-primario'] + $externo) ?>
                        <?php endif; ?>
                        <?= Html::a('Pedir presupuesto', ['/site/contacto'], ['class' => 'btn btn-lg btn-contorno']) ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>
<?php endforeach; ?>
