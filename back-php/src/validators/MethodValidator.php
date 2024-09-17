<?php
    function isMetodo($metodo){
        return (!(strcasecmp($_SERVER['REQUEST_METHOD'], $metodo)) ? true : false);
    }

?>