<?php

/**
 * Selector de estilo, solo para usuarios logueados. El elegido lo ven todos los visitantes.
 *
 * @var yii\web\View $this
 * @var string $actual
 */

use app\models\Ajustes;
use yii\helpers\Html;

$nombre = Ajustes::actual()->nombre;
?>
<div class="modal fade" id="estilos" tabindex="-1" aria-labelledby="estilos-titulo" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title h4" id="estilos-titulo"><i class="bi bi-palette"></i> Elegí un estilo</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p class="opacity-75">El estilo que elijas lo ven todos los visitantes del sitio.</p>
                <div class="estilos-grilla">
                    <?php foreach (Yii::$app->params['temas'] as $clave => $t): ?>
                        <?= Html::beginForm(['/panel/estilo/elegir', 'tema' => $clave], 'post') ?>
                        <button type="submit" class="estilo-opcion<?= $clave === $actual ? ' activo' : '' ?>">
                            <span class="estilo-muestra" data-tema="<?= $clave ?>" aria-hidden="true">
                                <span class="m-portada"><?= Html::encode($nombre) ?></span>
                                <span class="m-cuerpo">
                                    <span class="m-foto"></span>
                                    <span class="m-texto">Plato de la casa<small>$ 12.500</small></span>
                                    <span class="m-boton">Pedir</span>
                                </span>
                            </span>
                            <strong><?= Html::encode($t['nombre']) ?><?= $clave === $actual ? ' <i class="bi bi-check-circle-fill"></i>' : '' ?></strong>
                            <span class="estilo-desc"><?= Html::encode($t['desc']) ?></span>
                        </button>
                        <?= Html::endForm() ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
