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
            
            $api->GenerarDisponibilidad($data);
            
        }
        else
        {
            $mensaje->error('Datos incorrectos');
        }
    }
?>