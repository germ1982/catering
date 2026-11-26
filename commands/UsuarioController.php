<?php

namespace app\commands;

use app\models\Usuario;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * Usuarios desde la consola (sirve para el primero).
 *
 *   php yii usuario/crear
 */
class UsuarioController extends Controller
{
    public function actionCrear(string $usuario = '', string $nombre = '')
    {
        $usuario = $usuario ?: Console::prompt('Usuario (un nombre corto o tu email):', ['required' => true]);
        $nombre = $nombre ?: Console::prompt('Nombre (el que se ve en el panel):', ['required' => true]);
        $clave = Console::prompt('Contraseña (mínimo 8 caracteres):', ['required' => true]);
        if ($clave !== Console::prompt('Repetí la contraseña:', ['required' => true])) {
            $this->stderr("Las contraseñas no coinciden.\n", Console::FG_RED);

            return ExitCode::DATAERR;
        }
        $nuevo = new Usuario(['usuario' => $usuario, 'nombre' => $nombre, 'activo' => true, 'clave' => $clave]);
        if (!$nuevo->save()) {
            foreach ($nuevo->getFirstErrors() as $error) {
                $this->stderr("- $error\n", Console::FG_RED);
            }

            return ExitCode::DATAERR;
        }
        $this->stdout("Listo: se creó el usuario «{$nuevo->usuario}».\n", Console::FG_GREEN);

        return ExitCode::OK;
    }
}
