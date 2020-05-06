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
        
    }
?>