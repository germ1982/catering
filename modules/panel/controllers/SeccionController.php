<?php

namespace app\modules\panel\controllers;

use app\components\PanelController;
use app\models\Seccion;

/** Títulos, textos e imágenes de cada bloque del sitio */
class SeccionController extends PanelController
{
    public function actionIndex()
    {
        return $this->render('index', ['secciones' => Seccion::todas()]);
    }

    public function actionEditar(int $id)
    {
        $modelo = $this->buscar(Seccion::class, $id);
        if ($this->guardarFormulario($modelo)) {
            return $this->redirect(['index']);
        }

        return $this->render('formulario', ['modelo' => $modelo]);
    }
}
