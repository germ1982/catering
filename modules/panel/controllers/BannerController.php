<?php

namespace app\modules\panel\controllers;

use app\components\PanelController;
use app\models\Banner;
use Yii;

/** Imágenes grandes de la portada */
class BannerController extends PanelController
{
    protected array $post = ['borrar'];

    public function actionIndex()
    {
        return $this->render('index', ['banners' => Banner::find()->orderBy(['orden' => SORT_ASC, 'id' => SORT_ASC])->all()]);
    }

    public function actionCrear()
    {
        return $this->formulario(new Banner(['activo' => 1, 'orden' => 0]));
    }

    public function actionEditar(int $id)
    {
        return $this->formulario($this->buscar(Banner::class, $id));
    }

    public function actionBorrar(int $id)
    {
        $this->buscar(Banner::class, $id)->delete();
        Yii::$app->session->setFlash('success', 'Banner borrado.');

        return $this->redirect(['index']);
    }

    private function formulario(Banner $modelo)
    {
        if ($this->guardarFormulario($modelo)) {
            return $this->redirect(['index']);
        }

        return $this->render('formulario', ['modelo' => $modelo]);
    }
}
