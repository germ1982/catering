<?php

/**
 * "Tu pedido": lo que el visitante va agregando de la carta. Queda en su navegador y se
 * manda como mensaje de WhatsApp (no se guarda en el servidor).
 *
 * @var yii\web\View $this
 * @var app\models\Ajustes $sitio
 */

use yii\helpers\Html;

?>
<button type="button" class="pedido-boton d-none" data-bs-toggle="offcanvas" data-bs-target="#pedido">
    <i class="bi bi-basket3"></i> Tu pedido <span data-pedido-cantidad></span>
</button>
<div class="offcanvas offcanvas-end" tabindex="-1" id="pedido" aria-labelledby="pedido-titulo" data-whatsapp="<?= Html::encode($sitio->whatsappUrl()) ?>">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title h4" id="pedido-titulo">Tu pedido</h2>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="pedido-lista" data-pedido-lista></ul>
        <p class="pedido-total" data-pedido-total></p>
        <form data-pedido-form>
            <label class="form-label" for="p-nombre">Tu nombre</label>
            <input class="form-control mb-2" id="p-nombre" required>
            <label class="form-label" for="p-entrega">Entrega</label>
            <select class="form-select mb-2" id="p-entrega"><option>Delivery</option><option>Retiro</option></select>
            <label class="form-label" for="p-nota">Dirección, horario o aclaraciones</label>
            <textarea class="form-control mb-3" id="p-nota" rows="2"></textarea>
            <button type="submit" class="btn btn-primario w-100"><i class="bi bi-whatsapp"></i> Enviar pedido por WhatsApp</button>
            <button type="button" class="btn btn-link w-100" data-pedido-vaciar>Vaciar el pedido</button>
        </form>
        <p class="small opacity-75 mb-0">El precio y la disponibilidad se confirman por WhatsApp.</p>
    </div>
</div>
