<?php

namespace app\modules\panel;

/** Panel de edición del contenido: para cualquier usuario con sesión iniciada. */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\panel\controllers';
    public $layout = '@app/views/layouts/panel';
}
