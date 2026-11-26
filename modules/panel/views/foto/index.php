<?php

/**
 * @var yii\web\View $this
 * @var app\models\Foto[] $fotos
 */

use app\components\Fotos;
use yii\helpers\Html;

$this->title = 'Galería';
?>
<h1 class="h3 mb-3"><?= $this->title ?></h1>
<?= Html::beginForm(['subir'], 'post', ['enctype' => 'multipart/form-data', 'class' => 'caja mb-4']) ?>
    <label class="form-label" for="fotos">Agregar fotos (podés elegir varias)</label>
    <input type="file" class="form-control mb-2" id="fotos" name="fotos[]" multiple accept="image/jpeg,image/png,image/webp"
           data-comprimir="<?= Yii::$app->params['fotoLadoMaximo'] ?>" data-vista-previa="#fotos-previa">
    <?= $this->render('//layouts/_camara', ['destino' => '#fotos']) ?>
    <div class="previa" id="fotos-previa"></div>
    <?= Html::submitButton('<i class="bi bi-upload"></i> Subir', ['class' => 'btn btn-primario']) ?>
<?= Html::endForm() ?>

<div class="fotos-panel">
    <?php foreach ($fotos as $f): ?>
        <div class="caja">
            <img src="<?= Html::encode(Fotos::url($f->miniatura)) ?>" alt="">
            <?= Html::beginForm(['guardar', 'id' => $f->id], 'post') ?>
                <input class="form-control form-control-sm mb-1" name="titulo" value="<?= Html::encode($f->titulo) ?>" placeholder="Título (opcional)" maxlength="120" aria-label="Título">
                <div class="input-group input-group-sm">
                    <span class="input-group-text">Orden</span>
                    <input type="number" class="form-control" name="orden" value="<?= $f->orden ?>" aria-label="Orden">
                    <button class="btn btn-contorno" type="submit" aria-label="Guardar"><i class="bi bi-check-lg"></i></button>
                </div>
            <?= Html::endForm() ?>
            <?= Html::a('<i class="bi bi-trash"></i> Borrar', ['borrar', 'id' => $f->id], [
                'class' => 'btn btn-sm btn-link text-danger', 'data-method' => 'post', 'data-confirm' => '¿Borrar esta foto?',
            ]) ?>
        </div>
    <?php endforeach; ?>
</div>
