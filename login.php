<?php
    include_once 'apiUsuario.php';
    include_once 'Mensajes.php';

    $mensaje = new Mensajes_JSON();
    $api = new ApiUsuarios();

    //peticion get para listar todos los datos o solo el ID requerido
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $data = $mensaje->obtenerJSON();

        if(isset($data['usuario']) && isset($data['password']))
        {
            $item = array
            (
                'usuario'   =>$data['usuario'],
                'password'  =>$data['password']
            );
            $api->getAllUser($item);
        }
        else
        {
            $mensaje->error('No hay datos');
            header("HTTP/1.1 400 Bad Request");
        }
    }

?>