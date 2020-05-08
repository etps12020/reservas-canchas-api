<?php
    class Mensajes_JSON
    {
        function printJSON($array)
        {
            echo '<code>' . json_encode($array) .'</code>';
        }

        function error($mensaje)
        {
            echo '<code>' . json_encode(array('mensaje' => $mensaje)) . '</code>';
        }

        function exito($mensaje)
        {
            echo '<code>' . json_encode(array('mensaje' => $mensaje)) . '</code>';
        }

        function obtenerJSON()
        {
            $decode = json_decode(file_get_contents('php://input'), true);
            return $this->decode = $decode;
        }

        //modificar el formato de la fecha recibida
        function formatFecha($fecha)
        {
            if(strpos($fecha, '/') !==  false)
            {
                $fecha = date_create_from_format('d/m/Y', $fecha);
                $date =  date_format($fecha, 'Y-m-d');
            }
            else
            {
                $date = $fecha;    
            }
            return $this->date =$date;
        }

        //obtener fecha actual
        function obtenerFecha()
        {
            $date = date('Y-m-d h:i:s', time());
            return $this->date = $date;
        }
        
    }
?>