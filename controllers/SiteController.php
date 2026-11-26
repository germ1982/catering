<?php

namespace app\controllers;

use app\models\Ajustes;
use app\models\Banner;
use app\models\Foto;
use app\models\Item;
use app\models\LoginForm;
use app\models\Seccion;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    public function behaviors()
    {
        return ['verbs' => ['class' => VerbFilter::class, 'actions' => ['salir' => ['POST']]]];
    }

    public function actions()
    {
        return ['error' => ['class' => 'yii\web\ErrorAction']];
    }

    public function actionIndex()
    {
        // Tarjetas de la portada: las destacadas de cada sección
        $destacados = [];
        foreach (Item::visibles()->andWhere(['destacado' => 1])->all() as $item) {
            $destacados[$item->seccion][] = $item;
        }

        return $this->render('index', [
            'banners' => Banner::find()->where(['activo' => 1])->orderBy(['orden' => SORT_ASC, 'id' => SORT_ASC])->all(),
            'secciones' => Seccion::todas(),
            'destacados' => $destacados,
            'fotos' => Foto::ordenadas(8),
        ]);
    }

    public function actionSeccion(string $seccion)
    {
        $bloque = $this->visible($seccion);
        $grupos = [];
        foreach (Item::visibles()->andWhere(['seccion' => $seccion])->all() as $item) {
            $grupos[(string)$item->grupo][] = $item;
        }

        return $this->render('seccion', ['clave' => $seccion, 'bloque' => $bloque, 'grupos' => $grupos]);
    }

    public function actionItem(int $id, string $slug = '')
    {
        $item = $this->buscarItem($id);
        $otros = Item::visibles()->andWhere(['seccion' => $item->seccion])->andWhere(['<>', 'id', $item->id])->limit(3)->all();

        return $this->render('item', ['item' => $item, 'otros' => $otros]);
    }

    public function actionGaleria()
    {
        return $this->render('galeria', ['bloque' => $this->visible('galeria'), 'fotos' => Foto::ordenadas()]);
    }

    public function actionNosotros()
    {
        return $this->render('nosotros', ['bloque' => $this->visible('nosotros')]);
    }

    public function actionContacto()
    {
        return $this->render('contacto', ['bloque' => $this->visible('contacto')]);
    }

    /** Vista previa para WhatsApp / Facebook del sitio o de una tarjeta (ver views/site/tarjeta.php) */
    public function actionTarjeta(?int $id = null)
    {
        $sitio = Ajustes::actual();
        $banner = Banner::find()->where(['activo' => 1])->andWhere(['not', ['imagen' => null]])->orderBy('orden')->one();
        $datos = [
            'titulo' => $sitio->nombre,
            'descripcion' => $sitio->descripcion ?: ($sitio->eslogan ?: $sitio->nombre),
            'imagen' => $banner->imagen ?? $sitio->logo,
            'destino' => Url::home(true),
        ];
        if ($id !== null) {
            $item = $this->buscarItem($id);
            $datos = [
                'titulo' => $item->titulo . ($item->precio !== null ? ' · ' . $item->precioTexto : ''),
                'descripcion' => StringHelper::truncate((string)($item->resumen ?: $item->descripcion), 180) ?: $datos['descripcion'],
                'imagen' => $item->imagen ?: $datos['imagen'],
                'destino' => $item->getUrl(true),
            ];
        }
        Yii::$app->response->headers->set('X-Robots-Tag', 'noindex');

        return $this->renderPartial('tarjeta', $datos + ['sitio' => $sitio]);
    }

    public function actionIngresar()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/panel/item/index']);
        }
        $modelo = new LoginForm();
        if ($modelo->load(Yii::$app->request->post()) && $modelo->ingresar()) {
            return $this->goBack(['/panel/item/index']);
        }
        $modelo->clave = '';

        return $this->render('ingresar', ['modelo' => $modelo]);
    }

    public function actionSalir()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /** Un bloque oculto solo lo ve quien está logueado */
    private function visible(string $clave): Seccion
    {
        $bloque = Seccion::porClave($clave);
        if (!$bloque->visible && Yii::$app->user->isGuest) {
            throw new NotFoundHttpException('Página no encontrada.');
        }

        return $bloque;
    }

    private function buscarItem(int $id): Item
    {
        $item = Item::findOne($id);
        if (!$item || (Yii::$app->user->isGuest && (!$item->activo || !Seccion::porClave($item->seccion)->visible))) {
            throw new NotFoundHttpException('Esto no existe o ya no está disponible.');
        }

        return $item;
    }
}
