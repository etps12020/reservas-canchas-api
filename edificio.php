<?php
    include_once 'apiEdificio.php';
    include_once 'Mensajes.php';

    $mensaje = new Mensajes_JSON();
    $api = new ApiEdificios();

    //peticion get para listar todos los datos o solo el ID requerido
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $data = $mensaje->obtenerJSON();
     
        if(isset($data['id']))
        {
            $id = $data['id'];

            //validar solo un id numerico
            if(is_numeric($id))
            {
                 $api->getById($id);
                exit;
            }
            else
            {
                $mensaje->error('Los parametros son incorrectos');          
            }
        }
        else
        {   
             //listar todos
            $api->getAll();
            exit;
        }
    }

    //insertar datos
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $data = $mensaje->obtenerJSON();

        if(isset($_POST['nombre']) && isset($_POST['direccion']) && isset($_POST['estado']) 
            && isset($_POST['descripcion']) && isset($_POST['imagen']))
        {

            $api->add($data);
           
        }
        else
        {   
            $mensaje->error('Error al llamar API insertar');
        }
    }

    //actualizar
    if ($_SERVER['REQUEST_METHOD'] == 'PUT')
    {
        $data = $mensaje->obtenerJSON();

        if(isset($data['id']) && isset($data['nombre']) && isset($data['direccion']) && isset($data['estado']) 
            && isset($data['descripcion']) && isset($data['imagen']) )
        {
            
            $api->update($data);
        }
        else
        {
            $mensaje->error('Error al llamar API Actualizar');
        
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
                exit;
            }
            else
            {
                $mensaje->error('Los parametros son incorrectos');          
            }
        }
        else
        {
            $mensaje->error('Error al llamar API eliminar');
        }
    }   

?>