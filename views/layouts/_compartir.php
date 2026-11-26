<?php

/**
 * @var yii\web\View $this
 * @var string $url
 * @var string $titulo
 */

use yii\helpers\Html;

?>
<div class="compartir">
    <span>Compartir:</span>
    <a href="https://wa.me/?text=<?= rawurlencode($titulo . ' ' . $url) ?>" target="_blank" rel="noopener" aria-label="Compartir por WhatsApp"><i class="bi bi-whatsapp"></i></a>
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= rawurlencode($url) ?>" target="_blank" rel="noopener" aria-label="Compartir en Facebook"><i class="bi bi-facebook"></i></a>
    <button type="button" data-copiar="<?= Html::encode($url) ?>" aria-label="Copiar el link"><i class="bi bi-link-45deg"></i></button>
    <button type="button" class="d-none" data-compartir-nativo data-url="<?= Html::encode($url) ?>" data-titulo="<?= Html::encode($titulo) ?>" aria-label="Más opciones"><i class="bi bi-share"></i></button>
</div>
