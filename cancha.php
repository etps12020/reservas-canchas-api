<?php
    include_once 'apiCancha.php';
    include_once 'Mensajes.php';

    $mensaje = new Mensajes_JSON();
    $api 	= new ApiCanchas();

    //peticion get para listar todos los datos o solo el ID requerido
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $data = $mensaje->obtenerJSON();

        if(!empty($data))
        {
            $api->getById($data);
            exit;
        }
        else
        {
            $data = ['id'=>0, 'accion'=>'listar'];
            $api->getById($data);
            exit;
        }
    
    }

    //insertar datos
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $data = $mensaje->obtenerJSON();

        if(isset($data['nombre']) && isset($data['descripcion']) && isset($data['telefono']) && isset($data['horaInicio']) 
            && isset($data['horaFin']) && isset($data['idEdificio']) && isset($data['idTipoCancha']) &&  
            isset($data['idEstado']) &&  isset($data['idRestricciones']) &&  isset($data['imagen']))
        {
            $api->add($data);
        }
        else
        {   
            $mensaje->error('Error al llamar la API insertar validar que los campos esten llenos');
        }
    }

    //actualizar
    if ($_SERVER['REQUEST_METHOD'] == 'PUT')
    {
        $data = $mensaje->obtenerJSON();

        if(isset($data['id']) && isset($data['nombre']) && isset($data['descripcion']) && isset($data['telefono']) && isset($data['horaInicio']) 
            && isset($data['horaFin']) && isset($data['idEdificio']) && isset($data['idTipoCancha']) &&  
            isset($data['idEstado']) &&  isset($data['idRestricciones']) &&  isset($data['imagen']) )
        {
            $api->update($data);
        }
        else
        {
            $mensaje->error('Error al llamar la API Actualizar');
        
        }
    }

    //eliminar
     if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
    {
        $data = $mensaje->obtenerJSON();
     
        if(isset($data['id']))
        {
            $id = $data['id'];
            
            //validar solo un id numerico
            if(is_numeric($id))
            {
                $api->delete($id);
            }
            else
            {
                $mensaje->error('Los parametros son incorrectos');          
            }
        }
        else
        {
            $mensaje->error('Error al llamar la API eliminar');
        }
    }   
?>