<?php
    include_once 'apiUsuario.php';
    include_once 'Mensajes.php';
    include_once 'creacionUsuario.php';

    $mensaje = new Mensajes_JSON();
    $api = new ApiUsuarios();
    $creacion = new CrearUsuario();

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

    //insert
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $data = $mensaje->obtenerJSON();

        if(isset($data['nombre']) && isset($data['carnet']) && isset($data['correo']) 
            && isset($data['telefono']) && isset($data['rol']))
        {
            $nombreCompleto = $data['nombre'];
            $creacion->generarUsuario($nombreCompleto);
            $usuario = $creacion->registrarUsuario();

            $password = $api->generarPassword();

            $fechayHora = $api->obtenerFecha();

            $estado = "1";

            $item = array(
                'usuario'     =>$usuario,
                'nombre'      =>$data['nombre'],
                'carnet'      =>$data['carnet'],
                'correo'      =>$data['correo'],
                'telefono'    =>$data['telefono'],
                'password'    =>$password,
                'rol'         =>$data['rol'],
                'estado'      =>$estado,
                'fecha'       =>$fechayHora
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
        $i = count($data);

        if($i == 8)
        {
            if(isset($data['id']) && isset($data['nombre']) && isset($data['carnet']) && isset($data['correo']) 
            && isset($data['telefono']) && isset($data['password']) && isset($data['rol']) && isset($data['estado']))
            {
                $item = array
                (
                    'id'          =>$data['id'],
                    'nombre'      =>$data['nombre'],
                    'carnet'      =>$data['carnet'],
                    'correo'      =>$data['correo'],
                    'telefono'    =>$data['telefono'],
                    'password'    =>$data['password'],
                    'rol'         =>$data['rol'],
                    'estado'      =>$data['estado']
                );
                $api->update($item);
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
                $item = array
                (
                    'id'          =>$data['id'],
                    'telefono'    =>$data['telefono'],
                    'password'    =>$data['password']
                );
                $api->updateUsu($item);
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
            $api->delete($id);
        }
        else
        {
            $mensaje->error('Error al llamar la API eliminar');
        }
    }   

?>