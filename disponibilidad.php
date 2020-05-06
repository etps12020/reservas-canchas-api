<?php
    include_once 'apiReservacion.php';
    include_once 'Mensajes.php';

    $mensaje = new Mensajes_JSON();
    $api = new ApiReservacion();

    //peticion get para listar los horarios disponibles
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $data = $mensaje->obtenerJSON();
     
        if(isset($data['cancha']) && isset($data['fecha']))
        {
            $fecha =  $api->formatFecha($data['fecha']);

            $item = array
            (
                'cancha' =>$data['cancha'],
                'fecha'  =>$fecha
            );
            $api->GenerarDisponibilidad($item);
            
        }
        else
        {
            $mensaje->error('No hay datos');
            header("HTTP/1.1 400 Bad Request");
        }
    }
?>