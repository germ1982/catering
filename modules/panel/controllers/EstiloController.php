<?php

namespace app\modules\panel\controllers;

use app\components\PanelController;
use app\models\Ajustes;
use Yii;
use yii\web\BadRequestHttpException;

/** Estilo del sitio: se elige desde el selector (views/layouts/_estilos.php) */
class EstiloController extends PanelController
{
    protected array $post = ['elegir'];

    public function actionElegir(string $tema)
    {
        if (!isset(Yii::$app->params['temas'][$tema])) {
            throw new BadRequestHttpException('Ese estilo no existe.');
        }
        Ajustes::actual()->updateAttributes(['tema' => $tema]);
        Yii::$app->session->setFlash('success', 'Estilo cambiado a ' . Yii::$app->params['temas'][$tema]['nombre'] . '.');

        return $this->redirect(Yii::$app->request->referrer ?: ['/site/index']);
    }
}
