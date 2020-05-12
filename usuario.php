<?php
    include_once 'apiUsuario.php';
    include_once 'Mensajes.php';

    $mensaje = new Mensajes_JSON();
    $api = new ApiUsuarios();


    //peticion get para listar todos los datos o solo el ID requerido
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $data = $mensaje->obtenerJSON();
     
        if(!empty($data))
        {
            $id = $data['id'];
            
            //validar solo un id numerico
            if(is_numeric($id) && isset($data['accion']))
            {
                if($data['accion'] == 'dui')
                {
                   $api->getAll($data);
                }
                else
                {
                    $api->getById($data);
                }
            }
            else
            {
                $mensaje->error('Los parametros son incorrectos');          
            }
        }
        else
        {
            $mensaje->error('Error al llamar la API');
        }
    }

    //insert
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $data = $mensaje->obtenerJSON();

        if(isset($data['nombre']) && isset($data['dui']) && isset($data['carnet']) && isset($data['correo']) 
            && isset($data['telefono']) && isset($data['rol']))
        {
            $api->add($data);
             
        }
        else
        {   
            $mensaje->error('Error al llamar la API insertar');
        }
    }

    //actualizar  modificar
    if ($_SERVER['REQUEST_METHOD'] == 'PUT')
    {
        $data = $mensaje->obtenerJSON();
        $i = count($data);

        if($i == 10)
        {
            if(isset($data['usuloguedo']) && isset($data['id']) && isset($data['nombre']) && isset($data['dui']) && isset($data['carnet']) && isset($data['correo']) && isset($data['telefono']) && isset($data['password']) 
            && isset($data['rol']) && isset($data['estado']))
            {
                
                $api->update($data);
            }
            else
            {
                $mensaje->error('Error al llamar la API Actualizar');
            }
        }
        else
        {
            if(isset($data['id']) && isset($data['telefono']) && isset($data['password']))
            {
                if(!empty($data['id']) && !empty($data['telefono']) && !empty($data['password']))
                {
                    $api->update($data);
                }
                else
                {
                    $mensaje->error('Campos vacios no se puede actualizar');
                }
                
            }
            else
            {
                $mensaje->error('Error al llamar la API Actualizar');
            }
        }
    }

    //eliminar
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
    {
        $data = $mensaje->obtenerJSON();
     
        if(isset($data['id']))
        {
            $id = $data['id'];

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