<?php
    include_once 'apiUsuario.php';
    include_once 'Mensajes.php';

    $mensaje = new Mensajes_JSON();
    $api = new ApiUsuarios();

    //peticion get para loguear usuario
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $data = $mensaje->obtenerJSON();

        if(isset($data['usuario']) && isset($data['password']))
        {
           $api->getAllUser($data);
        }
        else
        {
            $mensaje->error('No hay datos');
            header("HTTP/1.1 400 Bad Request");
        }
    }
?>