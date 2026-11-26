<?php

namespace app\modules\panel\controllers;

use app\components\PanelController;
use app\models\Item;
use Yii;

/** Tarjetas de la oferta: comidas, servicios, eventos, alquiler y bebidas */
class ItemController extends PanelController
{
    protected array $post = ['borrar', 'alternar'];

    public function actionIndex(string $seccion = '')
    {
        $consulta = Item::find()->orderBy(['seccion' => SORT_ASC, 'orden' => SORT_ASC, 'id' => SORT_ASC]);
        if (isset(Yii::$app->params['secciones'][$seccion])) {
            $consulta->where(['seccion' => $seccion]);
        } else {
            $seccion = '';
        }

        return $this->render('index', ['items' => $consulta->all(), 'seccion' => $seccion]);
    }

    public function actionCrear(string $seccion = 'comidas')
    {
        return $this->formulario(new Item(['seccion' => $seccion, 'activo' => 1, 'destacado' => 0, 'orden' => 0]));
    }

    public function actionEditar(int $id)
    {
        return $this->formulario($this->buscar(Item::class, $id));
    }

    public function actionAlternar(int $id, string $campo)
    {
        $modelo = $this->buscar(Item::class, $id);
        if (in_array($campo, ['activo', 'destacado'], true)) {
            $modelo->updateAttributes([$campo => $modelo->$campo ? 0 : 1]);
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    public function actionBorrar(int $id)
    {
        $modelo = $this->buscar(Item::class, $id);
        $modelo->delete();
        Yii::$app->session->setFlash('success', 'Tarjeta borrada.');

        return $this->redirect(['index', 'seccion' => $modelo->seccion]);
    }

    private function formulario(Item $modelo)
    {
        if ($this->guardarFormulario($modelo)) {
            return $this->redirect(['index', 'seccion' => $modelo->seccion]);
        }
        $grupos = Item::find()->select('grupo')->distinct()->where(['not', ['grupo' => null]])->column();

        return $this->render('formulario', ['modelo' => $modelo, 'grupos' => $grupos]);
    }
}
