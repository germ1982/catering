<?php

/**
 * @var yii\web\View $this
 * @var app\models\Usuario[] $usuarios
 */

use yii\helpers\Html;

$this->title = 'Usuarios';
?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <h1 class="h3 mb-0"><?= $this->title ?></h1>
    <?= Html::a('<i class="bi bi-plus-lg"></i> Agregar usuario', ['crear'], ['class' => 'btn btn-primario']) ?>
</div>
<div class="table-responsive">
    <table class="table align-middle">
        <thead><tr><th>Nombre</th><th>Usuario</th><th>Activo</th><th>Último ingreso</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= Html::encode($u->nombre) ?></td>
                <td><?= Html::encode($u->usuario) ?></td>
                <td><?= $u->activo ? 'Sí' : 'No' ?></td>
                <td><?= $u->ultimo_ingreso ? Yii::$app->formatter->asDatetime($u->ultimo_ingreso) : '—' ?></td>
                <td class="text-end text-nowrap">
                    <?= Html::a('<i class="bi bi-pencil"></i>', ['editar', 'id' => $u->id], ['class' => 'btn btn-sm btn-contorno', 'aria-label' => 'Editar']) ?>
                    <?php if ($u->id !== Yii::$app->user->id): ?>
                        <?= Html::a('<i class="bi bi-trash"></i>', ['borrar', 'id' => $u->id], [
                            'class' => 'btn btn-sm btn-outline-danger', 'data-method' => 'post', 'data-confirm' => '¿Borrar a ' . $u->nombre . '?', 'aria-label' => 'Borrar',
                        ]) ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
