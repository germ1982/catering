<?php

namespace app\modules\panel\controllers;

use app\components\PanelController;
use app\models\Usuario;
use Yii;

/** Usuarios que pueden entrar al panel. Nadie puede desactivarse ni borrarse a sí mismo. */
class UsuarioController extends PanelController
{
    protected array $post = ['borrar'];

    public function actionIndex()
    {
        return $this->render('index', ['usuarios' => Usuario::find()->orderBy('nombre')->all()]);
    }

    public function actionCrear()
    {
        return $this->formulario(new Usuario(['activo' => 1]));
    }

    public function actionEditar(int $id)
    {
        return $this->formulario($this->buscar(Usuario::class, $id));
    }

    public function actionBorrar(int $id)
    {
        if ($id === (int)Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'No podés borrar tu propio usuario.');
        } else {
            $this->buscar(Usuario::class, $id)->delete();
            Yii::$app->session->setFlash('success', 'Usuario borrado.');
        }

        return $this->redirect(['index']);
    }

    private function formulario(Usuario $modelo)
    {
        $propio = !$modelo->isNewRecord && $modelo->id === (int)Yii::$app->user->id;
        if ($modelo->load(Yii::$app->request->post())) {
            if ($propio) {
                $modelo->activo = 1;
            }
            if ($modelo->save()) {
                if ($propio && $modelo->clave) {
                    // Cambió su contraseña: se renueva la sesión para que no lo saque
                    Yii::$app->user->login($modelo, 3600 * 24 * 30);
                }
                Yii::$app->session->setFlash('success', 'Usuario guardado.');

                return $this->redirect(['index']);
            }
        }
        $modelo->clave = '';

        return $this->render('formulario', ['modelo' => $modelo, 'propio' => $propio]);
    }
}
