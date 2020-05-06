<?php
    include_once 'DBUsuario.php';
    include_once 'Mensajes.php';

    class ApiUsuarios                        
    {

        //lista todos los datos
        function getAll()
        {
            $mensaje = new Mensajes_JSON();
            
            //creo un objeto de la clase Usuario, donde esta la consulta
            $usuario = new usuario();
            $usuarios = array();

            $res = $usuario->obtenerUsuarios();

            if($res->rowCount())
            {
                while($row = $res->fetch(PDO::FETCH_ASSOC))
                {
                    $item = array(
                        'id'            =>$row['idUsuario'],
                        'nombre'        =>$row['nombreCompleto'],
                        'usuario'       =>$row['usuario'],
                        'carnet'        =>$row['carnet'],
                        'correo'        =>$row['correo'],
                        'telefono'      =>$row['telefono'],
                        'password'      =>$row['password'],
                        'rol'           =>$row['rol'],
                        'estado'        =>$row['estado'],
                        'fechaCreacion' =>$row['fechaCreacion']
                    );
                    array_push($usuarios, $item);
                }
                header("HTTP/1.1 200 OK");
                $mensaje->printJSON($usuarios);
            }
            else
            {
                $mensaje->error('No hay elementos seleccionados');
               
            }
        }

        //consulta solo el id solicitado
        function getById($id)
        {
            
            //creo un objeto de la clase Usuario, donde esta la consulta
            $mensaje = new Mensajes_JSON();
            $usuario = new usuario();
            $usuarios = array();

            $res = $usuario->obtenerUsuario($id);
 
            if($res->rowCount() != 0)
            {
                $row = $res->fetch();

                $item = array(
                    'id'            =>$row['idUsuario'],
                    'nombre'        =>$row['nombreCompleto'],
                    'usuario'       =>$row['usuario'],
                    'carnet'        =>$row['carnet'],
                    'correo'        =>$row['correo'],
                    'telefono'      =>$row['telefono'],
                    'password'      =>$row['password'],
                    'rol'           =>$row['rol'],
                    'estado'        =>$row['estado'],
                    'fechaCreacion' =>$row['fechaCreacion']
                );
                array_push($usuarios, $item);
                
                header("HTTP/1.1 200 OK");
                $mensaje->printJSON($usuarios);
            }
            else
            {
                $mensaje->error('No hay elementos seleccionados');
            }
        }


       //registrar nuevo usuario
       function add($item)
       {
           $usuario = new usuario();
           $mensaje = new Mensajes_JSON();

           $res = $usuario->validarCarnet($item);
           $row = $res->fetch();
      
            if($row['var'] == 0)
            {
               $res = $usuario->nuevoUsuario($item);
               $usuarios = array();
               $usuarios["items"] = array();
   
               if($res->rowCount() == 1)
               {
                   $row = $res->fetch();
   
                   $item = array(
                       'usuario'       =>$row['usuario'],
                       'password'      =>$row['password'],
                       'fechaCreacion' =>$row['fechaCreacion']
                   );
                   array_push($usuarios['items'], $item);
                   
                   $mensaje->printJSON($usuarios);
               }
            }
            else
            {
                $mensaje->error('ERROR el carnet ya existe!');
            }
       }


         //actualizar datos usuario administrador
         function update($item)
         {
            
            $usuario = new usuario();
            $res = $usuario->actualizarUsuario($item);
             
            //imprimir mensajes
            $mensaje = new Mensajes_JSON();
            $mensaje->exito('Datos actualizados');
         }

         //actualizar datos usuario final
         function updateUsu($item)
         {
            
            $usuario = new usuario();
            $res = $usuario->modificarDatos($item);
             
            //imprimir mensajes
            $mensaje = new Mensajes_JSON();
            $mensaje->exito('Datos actualizados');
         }

         //eliminar usuario
         function delete($id)
         {
             $mensaje = new Mensajes_JSON();
             $usuario = new usuario();
             //se realiza una consulta previa validando que el ID no este siendo utilizado en otra tabla
             $res = $usuario->validarUsuarioID($id);
             
             $row = $res->fetch();
             //si la consulta retorna 0 se procede a eliminar sino muestra el mensaje de error
             if($row['cantidad'] == 0)
             {
                 $res = $usuario->eliminarUsuario($id);
                 $mensaje->exito('Datos eliminados con exito');
             }
             else
             {
                 $mensaje->error('No se puede eliminar este dato ya que esta siendo utilizado');
             }
             
         }

         //funcion login
         function getAllUser($item)
         {
             //creo un objeto de la clase Usuario, donde esta la consulta
            $mensaje = new Mensajes_JSON();
            $usuario = new usuario();

            $usuarios = array();
            $usuarios["items"] = array();
            $res = $usuario->loginUsuario($item);
            
            if($res->rowCount() != 0)
            {
                $row = $res->fetch();

                if($row['idEstado'] == 1)
                {
                    $item = array(
                        'id'            =>$row['idUsuario'],
                        'nombre'        =>$row['nombreCompleto'],
                        'usuario'       =>$row['usuario'],
                        'carnet'        =>$row['carnet'],
                        'correo'        =>$row['correo'],
                        'telefono'      =>$row['telefono'],
                        'password'      =>$row['password'],
                        'idRol'         =>$row['idRol'],
                        'rol'           =>$row['rol'],
                        'idEstado'      =>$row['idEstado'],
                        'estado'        =>$row['estado'],
                        'fechaCreacion' =>$row['fechaCreacion']
                    );
                    array_push($usuarios['items'], $item);
                    
                    $mensaje->printJSON($usuarios);
                }
                else
                {
                    $mensaje->error('Usuario Inactivo');
                }
            }
            else
            {
                $mensaje->error('Usuario o password incorrectos');
            }
         }

         
         //generar password aleatorio por defecto
        function generarPassword()
        {
            $longitud = 8;
            $psswd = substr( md5(microtime()), 1, $longitud);
            $psswd = strtoupper($psswd);

            return $this->psswd = $psswd;
        }

        //obtener fecha actual
        function obtenerFecha()
        {
            $date = date('Y-m-d h:i:s', time());
            return $this->date = $date;
        }


    }
?>