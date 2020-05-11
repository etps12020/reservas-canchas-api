<?php
    include_once 'DBUsuario.php';
    include_once 'creacionUsuario.php';
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
                        'dui'           =>$row['dui'],
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
                    'dui'           =>$row['dui'],
                    'carnet'        =>$row['carnet'],
                    'correo'        =>$row['correo'],
                    'telefono'      =>$row['telefono'],
                    'password'      =>$row['password'],
                    'idRol'         =>$row['idRol'],
                    'rol'           =>$row['rol'],
                    'idRol'         =>$row['idRol'],
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
           $creacion = new CrearUsuario();
           $mensaje = new Mensajes_JSON();

           $res = $usuario->validarCarnet($item);
           $row = $res->fetch();
      
            if($row['var'] == 0)
            {
               //estado activo por defecto
               $item['estado'] = 1;

               //crear usuario apartir del nombre
               $creacion->generarUsuario($item['nombre']);
               $nuevousuario = $creacion->registrarUsuario();
               $item['usuario'] = $nuevousuario;

               //generar password
               $this->generarPassword();
               $item['password'] = $this->psswd;
                
               //registrar los datos en la base
               $res = $usuario->nuevoUsuario($item);
               $usuarios = array();
                
               //mostrar datos del usuario creado
               if($res->rowCount() == 1)
               {
                   $row = $res->fetch();
   
                   $item = array(
                       'usuario'       =>$row['usuario'],
                       'password'      =>$row['password'],
                       'fechaCreacion' =>$row['fechaCreacion']
                   );
                   array_push($usuarios, $item);
                   
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
            $mensaje = new Mensajes_JSON();

            $i = count($item);

            if($i != 3)
            {
                $res = $usuario->actualizarUsuario($item);
            }
            else
            {
                $res = $usuario->modificarDatos($item);
            }
            
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
                    array_push($usuarios, $item);
                    
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

            $this->psswd = $psswd;
        }
    }
?>