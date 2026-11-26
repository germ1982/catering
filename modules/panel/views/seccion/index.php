<?php

/**
 * @var yii\web\View $this
 * @var app\models\Seccion[] $secciones
 */

use yii\helpers\Html;

$this->title = 'Textos y secciones';
?>
<h1 class="h3 mb-3"><?= $this->title ?></h1>
<p class="opacity-75">Cada bloque de la portada: su título, texto e imagen, el orden en que aparece y si se muestra.</p>
<div class="table-responsive">
    <table class="table align-middle">
        <thead><tr><th>Orden</th><th>Bloque</th><th>Visible</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($secciones as $s): ?>
            <tr>
                <td><?= $s->orden ?></td>
                <td><?= Html::a(Html::encode($s->titulo), ['editar', 'id' => $s->id]) ?>
                    <small class="d-block opacity-75"><?= Html::encode($s->clave . ($s->subtitulo ? ' · ' . $s->subtitulo : '')) ?></small></td>
                <td><?= $s->visible ? 'Sí' : 'No' ?></td>
                <td class="text-end"><?= Html::a('<i class="bi bi-pencil"></i>', ['editar', 'id' => $s->id], ['class' => 'btn btn-sm btn-contorno', 'aria-label' => 'Editar']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
