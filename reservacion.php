<?php
    include_once 'apiReservacion.php';
    include_once 'Mensajes.php';

    $mensaje = new Mensajes_JSON();
    $api = new ApiReservacion();

    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $data = $mensaje->obtenerJSON();

        if(!empty($data))
        {
            if(isset($data['usuario']) or isset($data['numReservacion']) or isset($data['cancha']) or isset($data['fecha']))
            {
                $api->getById($data);
                exit;
            }
            else
            {
                $mensaje->error('ERROR Los parametros son incorrectos');
            }
            
        }
        else
        {
            $data = ['fecha' =>'0000-00-0'];
            $api->getById($data);
            exit;
        }
        
    }

    //insert
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $data = $mensaje->obtenerJSON();

        $i = count($data);

        //reservacion administrativa
        if($i == 6)
        {
            if(isset($data['fecha']) && isset($data['usuarioAd']) && isset($data['dui']) && isset($data['hora']) 
            && isset($data['cancha']) && isset($data['tipo']))
            { 
                $usuario = $api->obtenerIdUsuario($data['dui']);
                $data['usuario'] = $usuario;
                
                $api->add($data);
            }
            else
            {   
                $mensaje->error('Error al llamar la API insertar');
            }
        }
        
        //reservacion usuario final
        else
        {
            if(isset($data['fecha']) && isset($data['usuario']) && isset($data['hora']) 
            && isset($data['cancha']) && isset($data['tipo']))
            {
                $api->add($data);
            }
            else
            {   
                $mensaje->error('Error al llamar la API insertar');
            }
        }
    }

    //actualizar
    if ($_SERVER['REQUEST_METHOD'] == 'PUT')
    {
        $data = $mensaje->obtenerJSON();
     
        if(isset($data['numReserva'])  && isset($data['usuario']) && isset($data['estado'])
            && isset($data['comentario']))
        {
            $api->update($data);
        }
        else
        {
            $mensaje->error('Error con datos JSON al Actualizar');
        }
    }

?>