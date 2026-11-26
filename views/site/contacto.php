<?php

/**
 * Datos de contacto y un pedido de presupuesto que abre WhatsApp con el mensaje escrito.
 *
 * @var yii\web\View $this
 * @var app\models\Seccion $bloque
 */

use app\models\Ajustes;
use yii\helpers\Html;

$sitio = Ajustes::actual();
$this->title = $bloque->titulo;
?>
<div class="container contenido">
    <?= $this->render('_titulo', ['bloque' => $bloque, 'etiqueta' => 'h1']) ?>
    <?php if ($bloque->texto): ?><div class="texto-bloque text-center"><?= nl2br(Html::encode($bloque->texto)) ?></div><?php endif; ?>
    <div class="row g-4 justify-content-center">
        <div class="col-md-5">
            <div class="caja"><?= $this->render('//layouts/_contacto', ['sitio' => $sitio]) ?></div>
        </div>
        <?php if ($sitio->whatsapp): ?>
        <div class="col-md-6">
            <form class="caja" data-consulta="<?= Html::encode($sitio->whatsappUrl()) ?>">
                <h2 class="h4">Pedí tu presupuesto</h2>
                <div class="mb-2"><label class="form-label" for="c-nombre">Tu nombre</label><input class="form-control" id="c-nombre" data-etiqueta="Nombre" required></div>
                <?php if ($tipos = $sitio->opciones('tipos_evento')): ?>
                <div class="mb-2"><label class="form-label" for="c-tipo">¿Qué estás organizando?</label>
                    <select class="form-select" id="c-tipo" data-etiqueta="Evento">
                        <?php foreach ($tipos as $op): ?>
                            <option><?= Html::encode($op) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                <div class="row g-2 mb-2">
                    <div class="col-7"><label class="form-label" for="c-fecha">Fecha</label><input type="date" class="form-control" id="c-fecha" data-etiqueta="Fecha"></div>
                    <div class="col-5"><label class="form-label" for="c-personas">Personas</label><input type="number" min="1" class="form-control" id="c-personas" data-etiqueta="Personas"></div>
                </div>
                <?php if ($extras = $sitio->opciones('extras_evento')): ?>
                <fieldset class="mb-2">
                    <legend class="form-label fs-6">¿Qué querés incluir?</legend>
                    <?php foreach ($extras as $extra): ?>
                        <label class="form-check form-check-inline"><input type="checkbox" class="form-check-input" data-incluye value="<?= Html::encode($extra) ?>"> <?= Html::encode($extra) ?></label>
                    <?php endforeach; ?>
                </fieldset>
                <?php endif; ?>
                <div class="mb-3"><label class="form-label" for="c-detalle">Detalles</label><textarea class="form-control" id="c-detalle" rows="3" data-etiqueta="Detalles"></textarea></div>
                <button type="submit" class="btn btn-primario w-100"><i class="bi bi-whatsapp"></i> Enviar por WhatsApp</button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>
