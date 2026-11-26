<?php

/**
 * Lista de datos de contacto cargados.
 *
 * @var yii\web\View $this
 * @var app\models\Ajustes $sitio
 */

use yii\helpers\Html;

$datos = [
    ['bi-whatsapp', $sitio->whatsapp ? '+' . $sitio->whatsapp : null, $sitio->whatsappUrl()],
    ['bi-telephone', $sitio->telefono, 'tel:' . preg_replace('/[^\d+]/', '', (string)$sitio->telefono)],
    ['bi-envelope', $sitio->email, 'mailto:' . $sitio->email],
    ['bi-geo-alt', $sitio->direccion, null],
    ['bi-truck', $sitio->zona, null],
    ['bi-clock', $sitio->horario, null],
    ['bi-instagram', $sitio->instagram ? '@' . $sitio->instagram : null, 'https://instagram.com/' . $sitio->instagram],
    ['bi-facebook', $sitio->facebook ? 'Facebook' : null, $sitio->facebook],
];
?>
<ul class="lista-contacto">
    <?php foreach ($datos as [$icono, $texto, $enlace]): ?>
        <?php if ($texto): ?>
            <li><i class="bi <?= $icono ?>"></i>
                <?= $enlace ? Html::a(Html::encode($texto), $enlace, ['target' => '_blank', 'rel' => 'noopener']) : Html::encode($texto) ?>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
