<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\components\AppAsset;
use app\components\Fotos;
use app\models\Ajustes;
use yii\bootstrap5\Html;
use yii\helpers\Url;

AppAsset::register($this);

$sitio = Ajustes::actual();
$temas = Yii::$app->params['temas'];
$tema = isset($temas[$sitio->tema]) ? $sitio->tema : Yii::$app->params['temaPredeterminado'];
$datosTema = $temas[$tema];
$descripcion = ($this->params['descripcion'] ?? null) ?: ($sitio->descripcion ?: ($sitio->eslogan ?: $sitio->nombre));
$titulo = $this->title ? $this->title . ' · ' . $sitio->nombre : $sitio->nombre;

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']);
$this->registerMetaTag(['name' => 'description', 'content' => $descripcion]);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/svg+xml', 'href' => Yii::getAlias('@web/favicon.svg')]);
// Quien está logueado ve el selector de estilos, así que se cargan las letras de todos
$conFuentes = Yii::$app->user->isGuest ? [$datosTema] : $temas;
foreach ($conFuentes as $t) {
    $this->registerCssFile('https://fonts.googleapis.com/css2?' . $t['fuentes'] . '&display=swap', ['position' => $this::POS_HEAD]);
}

// Vista previa al compartir el link (WhatsApp, Facebook...): etiquetas Open Graph
$og = $this->params['og'] ?? [];
$imagen = $og['image'] ?? ($sitio->logo ? Fotos::urlAbsoluta($sitio->logo) : null);
$ogDatos = [
    'og:site_name' => $sitio->nombre,
    'og:locale' => 'es_AR',
    'og:type' => 'website',
    'og:title' => $titulo,
    'og:description' => $descripcion,
    'og:url' => Url::to(Yii::$app->request->url, true),
] + ($imagen ? ['og:image' => $imagen] : []);
foreach ($ogDatos as $propiedad => $valor) {
    $this->registerMetaTag(['property' => $propiedad, 'content' => $valor], $propiedad);
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="es" class="h-100" data-tema="<?= $tema ?>" data-bs-theme="<?= $datosTema['oscuro'] ? 'dark' : 'light' ?>">
<head>
    <title><?= Html::encode($titulo) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<?= $this->render('_header', ['sitio' => $sitio]) ?>

<main id="main" class="flex-shrink-0" role="main">
    <?= $content ?>
</main>

<?= $this->render('_footer', ['sitio' => $sitio]) ?>

<?php if ($sitio->whatsapp && Yii::$app->controller->module->id !== 'panel'): ?>
    <a class="whatsapp-flotante" href="<?= Html::encode($sitio->whatsappUrl('¡Hola! Quiero hacer una consulta.')) ?>"
       target="_blank" rel="noopener" aria-label="Escribinos por WhatsApp"><i class="bi bi-whatsapp"></i></a>
    <?= $this->render('_pedido', ['sitio' => $sitio]) ?>
<?php endif; ?>

<?php if (!Yii::$app->user->isGuest): ?>
    <?= $this->render('_estilos', ['actual' => $tema]) ?>
<?php endif; ?>

<?= $this->render('_mensajes') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
