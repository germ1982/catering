<?php

namespace app\modules\panel\controllers;

use app\components\PanelController;
use app\models\Ajustes;

/** Nombre, logo, contacto y estilo del sitio */
class AjustesController extends PanelController
{
    public function actionIndex()
    {
        $modelo = Ajustes::find()->orderBy('id')->one() ?? Ajustes::actual();
        if ($this->guardarFormulario($modelo)) {
            return $this->refresh();
        }

        return $this->render('index', ['modelo' => $modelo]);
    }
}
