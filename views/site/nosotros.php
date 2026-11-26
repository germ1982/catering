<?php

/**
 * @var yii\web\View $this
 * @var app\models\Seccion $bloque
 */

$this->title = $bloque->titulo;
?>
<div class="container contenido">
    <?= $this->render('_nosotros', ['bloque' => $bloque, 'etiqueta' => 'h1']) ?>
</div>
