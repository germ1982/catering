<?php

namespace app\components;

use Yii;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/** Base de los controladores del panel: pide sesión iniciada. Las acciones de $post solo aceptan POST. */
class PanelController extends Controller
{
    /** @var string[] acciones que modifican datos sin formulario propio */
    protected array $post = [];

    public function behaviors()
    {
        return [
            'access' => ['class' => AccessControl::class, 'rules' => [['allow' => true, 'roles' => ['@']]]],
            'verbs' => ['class' => VerbFilter::class, 'actions' => array_fill_keys($this->post, ['POST'])],
        ];
    }

    /**
     * Si un envío supera post_max_size, PHP descarta todos los datos (también el token CSRF)
     * y Yii mostraría "no se pudieron verificar los datos". Se avisa algo entendible.
     */
    public function beforeAction($action)
    {
        $pedido = Yii::$app->request;
        if ($pedido->isPost && empty($_POST) && empty($_FILES) && (int)($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
            Yii::$app->session->setFlash('error', 'Las fotos pesan demasiado para subirlas juntas (el servidor acepta hasta '
                . ini_get('post_max_size') . 'B por vez). Probá con menos fotos por vez.');
            $this->redirect($pedido->referrer ?: ['/panel/item/index']);

            return false;
        }

        return parent::beforeAction($action);
    }

    /** @param class-string<ActiveRecord> $clase */
    protected function buscar(string $clase, int $id): ActiveRecord
    {
        $modelo = $clase::findOne($id);
        if (!$modelo) {
            throw new NotFoundHttpException('No se encontró lo que buscabas.');
        }

        return $modelo;
    }

    /**
     * Guarda un formulario con imágenes (modelo con el trait ConFoto).
     * Devuelve true si se guardó; los problemas con las fotos quedan como aviso.
     */
    protected function guardarFormulario(ActiveRecord $modelo, string $mensaje = 'Se guardaron los cambios.'): bool
    {
        if (!Yii::$app->request->isPost || !$modelo->load(Yii::$app->request->post())) {
            return false;
        }
        $modelo->tomarFotos();
        if (!$modelo->save()) {
            return false;
        }
        $errores = $modelo->guardarFotos((array)Yii::$app->request->post('quitar', []));
        if ($errores) {
            Yii::$app->session->setFlash('warning', Html::encode($mensaje) . '<br>' . implode('<br>', array_map([Html::class, 'encode'], $errores)));
        } else {
            Yii::$app->session->setFlash('success', Html::encode($mensaje));
        }

        return true;
    }
}
