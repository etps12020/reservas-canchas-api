<?php
    include_once 'apiReservacion.php';
    include_once 'Mensajes.php';

    $mensaje = new Mensajes_JSON();
    $api = new ApiReservacion();

    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $data = $mensaje->obtenerJSON();
    }

    //insert
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $data = $mensaje->obtenerJSON();

        $i = count($data);

        //reservacion administrativa
        if($i == 6)
        {
            if(isset($data['fecha']) && isset($data['usuarioAd']) && isset($data['usuario']) && isset($data['hora']) 
            && isset($data['cancha']) && isset($data['tipo']))
            { 
                $usuario = $api->obtenerIdUsuario($data['usuario']);
                $fecha =  $mensaje->formatFecha($data['fecha']);

                $item = array(
                        'fecha'         =>$fecha, 
                        'usuarioAd'     =>$data['usuarioAd'], 
                        'usuario'       =>$usuario, 
                        'hora'          =>$data['hora'],
                        'cancha'        =>$data['cancha'], 
                        'tipo'          =>$data['tipo'], 
                        'qr'            =>$qr 
                );
                $api->add($item);
                
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
                $fecha =  $mensaje->formatFecha($data['fecha']);

                $item = array(
                        'fecha'         =>$fecha, 
                        'usuario'       =>$data['usuario'], 
                        'hora'          =>$data['hora'],
                        'cancha'        =>$data['cancha'], 
                        'tipo'          =>$data['tipo']
                );
                $api->add($item);
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
            $fechayHora = $mensaje->obtenerFecha();

            $item = array(   
                'numReserva'  =>$data['numReserva'], 
                'usuario'     =>$data['usuario'], 
                'estado'      =>$data['estado'],
                'comentario'  =>$data['comentario'],
                'fechayhora'  =>$fechayHora
            );
            $api->update($item);

        }
        else
        {
            $mensaje->error('Error con datos JSON al Actualizar');
        }
    }

?>