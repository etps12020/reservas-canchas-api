<?php
    include_once 'apiRolUsuario.php';
    include_once 'Mensajes.php';

    $mensaje = new Mensajes_JSON();
    $api = new ApiRolUsuarios();

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

        if(isset($data['rol']))
        {
            $item = array(
            'rol' =>$data['rol']
        );

            $api->add($item);
        }
        else
        {   
            $mensaje->error('Error al llamar la API insertar');
        }
    }

    //actualizar
    if ($_SERVER['REQUEST_METHOD'] == 'PUT')
    {
        
        $data = $mensaje->obtenerJSON();

        if(isset($data['id']) && isset($data['rol']))
        {
            $item = array
            (
                'id'  =>$data['id'],
                'rol' =>$data['rol']
            );
            $api->update($item);
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
            $api->delete($id);
        }
        else
        {
            $mensaje->error('Error al llamar la API eliminar');
        }
    }   

?>