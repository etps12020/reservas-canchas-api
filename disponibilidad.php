<?php
    include_once 'apiHorarioReservacion.php';
    include_once 'Mensajes.php';

    $mensaje = new Mensajes_JSON();
    $api = new ApiHorariosReservacion();

    //peticion get para listar los horarios disponibles
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $data = $mensaje->obtenerJSON();
     
        if(isset($data['cancha']) && isset($data['fecha']))
        {
            $fecha =  $mensaje->formatFecha($data['fecha']);

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