<?php

namespace app\modules\panel\controllers;

use app\components\Fotos;
use app\components\PanelController;
use app\models\Foto;
use Yii;
use yii\helpers\Html;
use yii\web\UploadedFile;

/** Galería de fotos: subida de varias a la vez, título y orden */
class FotoController extends PanelController
{
    protected array $post = ['subir', 'guardar', 'borrar'];

    public function actionIndex()
    {
        return $this->render('index', ['fotos' => Foto::ordenadas()]);
    }

    public function actionSubir()
    {
        $subidas = 0;
        $errores = [];
        foreach (UploadedFile::getInstancesByName('fotos') as $archivo) {
            $r = Fotos::guardar($archivo, 'galeria');
            if (is_string($r)) {
                $errores[] = Html::encode($r);
                continue;
            }
            $foto = new Foto(['orden' => 0]);
            $foto->archivo = $r[0];
            $foto->miniatura = $r[1];
            $foto->save();
            $subidas++;
        }
        if ($errores) {
            Yii::$app->session->setFlash('warning', "Fotos subidas: $subidas.<br>" . implode('<br>', $errores));
        } elseif ($subidas) {
            Yii::$app->session->setFlash('success', "Fotos subidas: $subidas.");
        } else {
            Yii::$app->session->setFlash('info', 'No elegiste ninguna foto.');
        }

        return $this->redirect(['index']);
    }

    public function actionGuardar(int $id)
    {
        $foto = $this->buscar(Foto::class, $id);
        if ($foto->load(Yii::$app->request->post(), '') && $foto->save()) {
            Yii::$app->session->setFlash('success', 'Foto actualizada.');
        } else {
            Yii::$app->session->setFlash('error', 'Revisá el título y el orden.');
        }

        return $this->redirect(['index']);
    }

    public function actionBorrar(int $id)
    {
        $this->buscar(Foto::class, $id)->delete();

        return $this->redirect(['index']);
    }
}
